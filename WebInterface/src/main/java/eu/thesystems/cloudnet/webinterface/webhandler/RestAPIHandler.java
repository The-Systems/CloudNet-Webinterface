package eu.thesystems.cloudnet.webinterface.webhandler;

/*
 * Created by Mc_Ruben on 13.07.2018
 * 

 */


import com.google.gson.JsonElement;
import com.google.gson.stream.MalformedJsonException;
import de.dytanic.cloudnet.lib.NetworkUtils;
import de.dytanic.cloudnet.lib.hash.DyHash;
import de.dytanic.cloudnet.lib.player.CloudPlayer;
import de.dytanic.cloudnet.lib.player.OfflinePlayer;
import de.dytanic.cloudnet.lib.player.permission.PermissionPool;
import de.dytanic.cloudnet.lib.proxylayout.ProxyConfig;
import de.dytanic.cloudnet.lib.server.ProxyGroup;
import de.dytanic.cloudnet.lib.server.ServerGroup;
import de.dytanic.cloudnet.lib.server.info.ProxyInfo;
import de.dytanic.cloudnet.lib.server.info.ServerInfo;
import de.dytanic.cloudnet.lib.user.User;
import de.dytanic.cloudnet.lib.utility.CollectionWrapper;
import de.dytanic.cloudnet.lib.utility.document.Document;
import de.dytanic.cloudnet.web.server.handler.WebHandler;
import de.dytanic.cloudnet.web.server.util.PathProvider;
import de.dytanic.cloudnet.web.server.util.QueryDecoder;
import de.dytanic.cloudnetcore.CloudNet;
import de.dytanic.cloudnetcore.database.StatisticManager;
import de.dytanic.cloudnetcore.network.components.MinecraftServer;
import de.dytanic.cloudnetcore.network.components.ProxyServer;
import de.dytanic.cloudnetcore.network.components.Wrapper;
import de.dytanic.cloudnetcore.player.CorePlayerExecutor;
import eu.thesystems.cloudnet.webinterface.WebInterfaceModule;
import eu.thesystems.cloudnet.webinterface.wrapperinfo.AdvancedWrapperInfo;
import io.netty.channel.ChannelHandlerContext;
import io.netty.handler.codec.http.*;

import java.nio.charset.StandardCharsets;
import java.util.*;

@lombok.ToString
@lombok.Getter
public class RestAPIHandler extends WebHandler {
    private WebInterfaceModule webInterface;

    public RestAPIHandler(WebInterfaceModule webInterface) {
        super("/cloudnet/webinterface/api/v2");
        this.webInterface = webInterface;
    }

    @Override
    public FullHttpResponse handleRequest(ChannelHandlerContext channelHandlerContext, QueryDecoder queryDecoder, PathProvider pathProvider, HttpRequest httpRequest) throws Exception {
        FullHttpResponse response = newResponse(httpRequest.getProtocolVersion());
        response.setStatus(HttpResponseStatus.OK);
        Document responseDocument = new Document().append("success", false).append("response", "");

        if (!httpRequest.headers().contains("-Xcloudnet-user")
                || (!httpRequest.headers().contains("-Xcloudnet-token") && !httpRequest.headers().contains("-Xcloudnet-password"))
                || !httpRequest.headers().contains("-Xmessage")
                || !httpRequest.headers().contains("-Xvalue")) {
            responseDocument.append("reason", "-Xcloudnet-user, -Xcloudnet-token, -Xmessage or -Xvalue not found");
            response.content().writeBytes(responseDocument.toBytesAsUTF_8());
            return response;
        }

        User user = CloudNet.getInstance().getUser(httpRequest.headers().get("-Xcloudnet-user"));
        if (user == null) {
            responseDocument.append("reason", "-Xcloudnet-user not correct");
            return response;
        }
        if (httpRequest.headers().contains("-Xcloudnet-token")) {
            if (!user.getApiToken().equals(httpRequest.headers().get("-Xcloudnet-token"))) {
                responseDocument.append("reason", "-Xcloudnet-user and -Xcloudnet-token are not correct");
                response.content().writeBytes(responseDocument.toBytesAsUTF_8());
                return response;
            }
        } else if (httpRequest.headers().contains("-Xcloudnet-password")) {
            if (!user.getHashedPassword().equals(DyHash.hashString(httpRequest.headers().get("-Xcloudnet-password")))) {
                responseDocument.append("reason", "-Xcloudnet-user and -Xcloudnet-password are not correct");
                response.content().writeBytes(responseDocument.toBytesAsUTF_8());
                return response;
            }
        } else {
            responseDocument.append("reason", "-Xcloudnet-user, -Xcloudnet-token, -Xmessage or -Xvalue not found");
            response.content().writeBytes(responseDocument.toBytesAsUTF_8());
            return response;
        }

        String message = httpRequest.headers().get("-Xmessage");
        String value = httpRequest.headers().get("-Xvalue");

        if (this.webInterface.isDebug()) {
            System.out.println("[WebInterfaceModule] HttpRequest from " + channelHandlerContext.channel().remoteAddress() + " (message: " + message + "; value: " + value + ")");
        }

        switch (message.toLowerCase()) {

            case "testonline":
            {
                responseDocument.append("success", true);
            }
            break;

            case "authorize":
            {
                boolean auth = false;
                String password = httpRequest.headers().get("-Xpassword");
                String hashedPassword = DyHash.hashString(password);
                for (User user1 : CloudNet.getInstance().getUsers()) {
                    if (user1.getName().equals(value) && (user1.getHashedPassword().equals(hashedPassword) || user1.getApiToken().equals(password))) {
                        auth = true;
                        break;
                    }
                }
                responseDocument.append("success", true).append("response", auth);
            }
            break;

            case "startserver":
            {
                if (!user.hasPermission("web.startserver"))
                    return noPermission(httpRequest);
                ServerGroup serverGroup = CloudNet.getInstance().getServerGroup(value);
                if (serverGroup == null) {
                    responseDocument.append("reason", "The ServerGroup \"" + value + "\" was not found");
                    break;
                }

                String amount = httpRequest.headers().get("-Xamount");

                if (amount != null && NetworkUtils.checkIsNumber(amount))
                    for (int i = 0; i < Integer.parseInt(amount); i++)
                        CloudNet.getInstance().startGameServer(serverGroup);
                else
                    CloudNet.getInstance().startGameServer(serverGroup);

                responseDocument.append("success", true);
            }
            break;

            case "stopserver":
            {
                if (!user.hasPermission("web.stopserver"))
                    return noPermission(httpRequest);
                MinecraftServer minecraftServer = CloudNet.getInstance().getServer(value);
                if (minecraftServer == null) {
                    responseDocument.append("reason", "The Server \"" + value + "\" was not found");
                    break;
                }

                CloudNet.getInstance().stopServer(minecraftServer);

                responseDocument.append("success", true);
            }
            break;

            case "startproxy":
            {
                if (!user.hasPermission("web.startproxy"))
                    return noPermission(httpRequest);
                ProxyGroup proxyGroup = CloudNet.getInstance().getProxyGroup(value);
                if (proxyGroup == null) {
                    responseDocument.append("reason", "The ProxyGroup \"" + value + "\" was not found");
                    break;
                }

                String amount = httpRequest.headers().get("-Xamount");

                if (amount != null && NetworkUtils.checkIsNumber(amount))
                    for (int i = 0; i < Integer.parseInt(amount); i++)
                        CloudNet.getInstance().startProxy(proxyGroup);
                else
                    CloudNet.getInstance().startProxy(proxyGroup);

                responseDocument.append("success", true);
            }
            break;

            case "stopproxy":
            {
                if (!user.hasPermission("web.stopproxy"))
                    return noPermission(httpRequest);
                ProxyServer proxyServer = CloudNet.getInstance().getProxy(value);
                if (proxyServer == null) {
                    responseDocument.append("reason", "The Proxy \"" + value + "\" was not found");
                    break;
                }

                CloudNet.getInstance().stopProxy(proxyServer);

                responseDocument.append("success", true);
            }
            break;

            case "onlinecount":
            {
                responseDocument.append("success", true).append("onlineCount", CloudNet.getInstance().getNetworkManager().getOnlineCount());
            }
            break;

            case "dispatchcloudcommand":
            {
                if (!user.hasPermission("web.sendkommandtoconsole"))
                    return noPermission(httpRequest);
                CloudNet.getInstance().getCommandManager().dispatchCommand(value);
                responseDocument.append("success", true);
            }
            break;

            case "dispatchservercommand":
            {
                if (!user.hasPermission("web.sendcommandtoserver"))
                    return noPermission(httpRequest);
                MinecraftServer minecraftServer = CloudNet.getInstance().getServer(value);
                if (minecraftServer == null) {
                    responseDocument.append("reason", "The Server \"" + value + "\" was not found");
                    break;
                }

                minecraftServer.getWrapper().writeServerCommand(httpRequest.headers().get("-Xcommand"), minecraftServer.getServerInfo());
                responseDocument.append("success", true);
            }
            break;

            case "dispatchproxycommand":
            {
                if (!user.hasPermission("web.sendcommandtoserver"))
                    return noPermission(httpRequest);
                ProxyServer proxyServer = CloudNet.getInstance().getProxy(value);
                if (proxyServer == null) {
                    responseDocument.append("reason", "The Proxy \"" + value + "\" was not found");
                    break;
                }

                proxyServer.getWrapper().writeProxyCommand(httpRequest.headers().get("-Xcommand"), proxyServer.getProxyInfo());
                responseDocument.append("success", true);
            }
            break;

            case "corelog":
            {
                if (!user.hasPermission("web.console"))
                    return noPermission(httpRequest);
                responseDocument.append("success", true).append("log", this.webInterface.getCorelog().toString());
            }
            break;

            case "coreloghaste":
            {
                if (!user.hasPermission("web.console"))
                    return noPermission(httpRequest);
                responseDocument.append("success", true).append("log", this.webInterface.getCorelog().toString().replace("<p>", "").replace("</p>", "\n"));
            }
            break;

            case "createlog":
            {

            }
            break;

            case "getlog":
            {

            }
            break;

            case "servergroup":
            {
                responseDocument.append("success", true).append("response", CloudNet.getInstance().getServerGroup(value));
            }
            break;

            case "servergroups":
            {
                responseDocument.append("success", true).append("response", CloudNet.getInstance().getServerGroups().values());
            }
            break;

            case "proxygroup":
            {
                responseDocument.append("success", true).append("response", CloudNet.getInstance().getProxyGroup(value));
            }
            break;

            case "proxygroups":
            {
                responseDocument.append("success", true).append("response", CloudNet.getInstance().getProxyGroups().values());
            }
            break;

            case "proxynames":
            {
                if (value.isEmpty()) {
                    responseDocument.append("success", true).append("response", CloudNet.getInstance().getProxysByName());
                } else {
                    Collection<String> servers = new LinkedList<>();
                    for (ProxyServer minecraftServer : CloudNet.getInstance().getProxys().values())
                        if (minecraftServer.getServiceId().getGroup().equalsIgnoreCase(value))
                            servers.add(minecraftServer.getServiceId().getServerId());
                    responseDocument.append("success", true).append("response", servers);
                }
            }
            break;

            case "servernames":
            {
                if (value.isEmpty()) {
                    responseDocument.append("success", true).append("response", CloudNet.getInstance().getServersByName());
                } else {
                    Collection<String> servers = new LinkedList<>();
                    for (MinecraftServer minecraftServer : CloudNet.getInstance().getServers().values())
                        if (minecraftServer.getServiceId().getGroup().equalsIgnoreCase(value))
                            servers.add(minecraftServer.getServiceId().getServerId());
                    responseDocument.append("success", true).append("response", servers);
                }
            }
            break;

            case "proxyinfos":
            {
                if (value.isEmpty()) {
                    responseDocument.append("success", true).append("response", CollectionWrapper.transform(CloudNet.getInstance().getProxys().values(), ProxyServer::getProxyInfo));
                } else {
                    Collection<ProxyInfo> servers = new LinkedList<>();
                    for (ProxyServer minecraftServer : CloudNet.getInstance().getProxys().values())
                        if (minecraftServer.getServiceId().getGroup().equalsIgnoreCase(value))
                            servers.add(minecraftServer.getProxyInfo());
                    responseDocument.append("success", true).append("response", servers);
                }
            }
            break;

            case "serverinfos":
            {
                if (value.isEmpty()) {
                    responseDocument.append("success", true).append("response", CollectionWrapper.transform(CloudNet.getInstance().getServers().values(), MinecraftServer::getServerInfo));
                } else {
                    Collection<ServerInfo> servers = new LinkedList<>();
                    for (MinecraftServer minecraftServer : CloudNet.getInstance().getServers().values())
                        if (minecraftServer.getServiceId().getGroup().equalsIgnoreCase(value))
                            servers.add(minecraftServer.getServerInfo());
                    responseDocument.append("success", true).append("response", servers);
                }
            }
            break;

            case "serverinfo":
            {
                MinecraftServer proxyServer = CloudNet.getInstance().getServer(value);
                if (proxyServer == null) {
                    responseDocument.append("reason", "The Server was not found");
                    break;
                }
                responseDocument.append("success", true).append("response", proxyServer.getServerInfo());
            }
            break;

            case "proxyinfo":
            {
                ProxyServer proxyServer = CloudNet.getInstance().getProxy(value);
                if (proxyServer == null) {
                    responseDocument.append("reason", "The Proxy was not found");
                    break;
                }
                responseDocument.append("success", true).append("response", proxyServer.getProxyInfo());
            }
            break;

            case "updateservergroup":
            {
                if (!user.hasPermission("web.creategroup"))
                    return noPermission(httpRequest);
                ServerGroup serverGroup = Document.load(value).getObject("group", ServerGroup.TYPE);
                CloudNet.getInstance().getConfig().createGroup(serverGroup);

                CloudNet.getInstance().getServerGroups().put(serverGroup.getName(), serverGroup);
                CloudNet.getInstance().getNetworkManager().reload();
                CloudNet.getInstance().getNetworkManager().updateAll0();
                CloudNet.getInstance().toWrapperInstances(serverGroup.getWrapper()).forEach(Wrapper::updateWrapper);
                responseDocument.append("success", true);
            }
            break;

            case "updateproxygroup":
            {
                if (!user.hasPermission("web.creategroup"))
                    return noPermission(httpRequest);
                ProxyGroup proxyGroup = Document.load(value).getObject("group", ProxyGroup.class);
                CloudNet.getInstance().getConfig().createGroup(proxyGroup);

                CloudNet.getInstance().getProxyGroups().put(proxyGroup.getName(), proxyGroup);
                CloudNet.getInstance().getNetworkManager().reload();
                CloudNet.getInstance().getNetworkManager().updateAll0();
                CloudNet.getInstance().toWrapperInstances(proxyGroup.getWrapper()).forEach(Wrapper::updateWrapper);
                responseDocument.append("success", true);
            }
            break;

            case "deleteservergroup":
            {
                if (!user.hasPermission("web.deletegroup"))
                    return noPermission(httpRequest);
                ServerGroup serverGroup = CloudNet.getInstance().getServerGroup(value);
                if (serverGroup == null)
                    break;
                CloudNet.getInstance().getConfig().deleteGroup(serverGroup);
                CloudNet.getInstance().getServerGroups().remove(serverGroup.getName());
                responseDocument.append("success", true);
            }
            break;

            case "deleteproxygroup":
            {
                if (!user.hasPermission("web.deletegroup"))
                    return noPermission(httpRequest);
                ProxyGroup serverGroup = CloudNet.getInstance().getProxyGroup(value);
                if (serverGroup == null)
                    break;
                CloudNet.getInstance().getConfig().deleteGroup(serverGroup);
                CloudNet.getInstance().getProxyGroups().remove(serverGroup.getName());
                responseDocument.append("success", true);
            }
            break;

            case "cloudnetwork":
            {
                responseDocument.append("response", CloudNet.getInstance().getNetworkManager().newCloudNetwork());
            }
            break;

            case "statistics":
            {
                responseDocument.append("response", StatisticManager.getInstance().getStatistics().obj());
            }
            break;

            case "wrapper":
            {
                responseDocument.append("response", CloudNet.getInstance().getConfig().getWrappers());
            }
            break;

            case "onlineplayers":
            {
                responseDocument.append("response", CloudNet.getInstance().getNetworkManager().getOnlinePlayers().values());
            }
            break;

            case "permissiongroups":
            {
                PermissionPool permissionPool = CloudNet.getInstance().getNetworkManager().getModuleProperties().getObject("permissionPool", PermissionPool.TYPE);
                if (permissionPool == null || !permissionPool.isAvailable()) {
                    responseDocument.append("reason", "PermissionPool is not enabled");
                    break;
                }
                responseDocument.append("success", true).append("response", permissionPool.getGroups());
            }
            break;

            case "networkmemory":
            {
                int cpuCores = 0;
                int usedMemory = 0;
                int maxMemory = 0;
                for (Wrapper wrapper : CloudNet.getInstance().getWrappers().values()) {
                    if (wrapper.getWrapperInfo() != null) {
                        cpuCores += wrapper.getWrapperInfo().getAvailableProcessors();
                        maxMemory += wrapper.getWrapperInfo().getMemory();
                        usedMemory += wrapper.getUsedMemory();
                    }
                }
                responseDocument.append("success", true).append("response", new Document().append("usedMemory", usedMemory).append("maxMemory", maxMemory).append("cpuCores", cpuCores).obj());
            }
            break;

            case "cpucores":
            {
                int cpuCores = 0;
                for (Wrapper wrapper : CloudNet.getInstance().getWrappers().values())
                    if (wrapper.getWrapperInfo() != null)
                        cpuCores += wrapper.getWrapperInfo().getAvailableProcessors();
                responseDocument.append("success", true).append("response", cpuCores);
            }
            break;

            case "wrappers":
            {
                int connectedWrappers = 0;
                int notConnectedWrappers = 0;
                for (Wrapper wrapper : CloudNet.getInstance().getWrappers().values()) {
                    if (wrapper.getWrapperInfo() != null) {
                        connectedWrappers++;
                    } else {
                        notConnectedWrappers++;
                    }
                }

                responseDocument.append("success", true).append("response", new Document().append("connected", connectedWrappers).append("notConnected", notConnectedWrappers).obj());
            }
            break;

            case "wrapperinfos":
            {
                Collection<AdvancedWrapperInfo> advancedWrapperInfos = new ArrayList<>();
                for (Wrapper wrapper : CloudNet.getInstance().getWrappers().values()) {
                    if (wrapper.getWrapperInfo() != null) {
                        advancedWrapperInfos.add(new AdvancedWrapperInfo(wrapper.getCpuUsage(), wrapper.getUsedMemory(), wrapper.getWrapperInfo()));
                    }
                }
                responseDocument.append("success", true).append("response", advancedWrapperInfos);
            }
            break;

            case "user":
            {
                User user1 = CloudNet.getInstance().getUser(value);
                responseDocument.append("success", user1 != null).append("response", user1);
            }
            break;

            case "users":
            {
                responseDocument.append("success", true).append("response", CloudNet.getInstance().getUsers());
            }
            break;

            case "updateuser":
            {
                if (!user.hasPermission("web.createuser"))
                    return noPermission(httpRequest);
                try {
                    User user1 = Document.GSON.fromJson(value, User.class);
                    if (user1 != null) {
                        Collection<User> users = new ArrayList<>();
                        for (User x : CloudNet.getInstance().getUsers()) {
                            if (x.getName().equals(user1.getName())) {
                                users.add(x);
                            }
                        }
                        if (!users.isEmpty())
                            CloudNet.getInstance().getUsers().removeAll(users);
                        CloudNet.getInstance().getUsers().add(user1);
                        CloudNet.getInstance().getConfig().save(CloudNet.getInstance().getUsers());
                        responseDocument.append("success", true);
                    }
                } catch (Exception e) {
                    if (e instanceof MalformedJsonException) {
                        responseDocument.append("reason", "Malformed Json: " + e.getMessage());
                        break;
                    } else {
                        e.printStackTrace();
                        break;
                    }
                }
            }
            break;

            case "changeuserpassword":
            {
                if (!user.hasPermission("web.edituser"))
                    return noPermission(httpRequest);
                User user1 = CloudNet.getInstance().getUser(value);
                if (user1 == null) {
                    responseDocument.append("reason", "The User was not found");
                    break;
                }

                CloudNet.getInstance().getUsers().remove(user1);

                user1 = new User(user1.getName(), user1.getUniqueId(), user1.getApiToken(), DyHash.hashString(httpRequest.headers().get("-Xpassword")), user1.getPermissions(), user1.getMetaData());

                CloudNet.getInstance().getUsers().add(user1);
                CloudNet.getInstance().getConfig().save(CloudNet.getInstance().getUsers());

                responseDocument.append("success", true);
            }
            break;

            case "changeusername":
            {
                if (!user.hasPermission("web.edituser"))
                    return noPermission(httpRequest);
                User user1 = CloudNet.getInstance().getUser(value);
                if (user1 == null) {
                    responseDocument.append("reason", "The User was not found");
                    break;
                }

                CloudNet.getInstance().getUsers().remove(user1);

                user1 = new User(httpRequest.headers().get("-Xuser"), user1.getUniqueId(), user1.getApiToken(), user1.getHashedPassword(), user1.getPermissions(), user1.getMetaData());

                CloudNet.getInstance().getUsers().add(user1);
                CloudNet.getInstance().getConfig().save(CloudNet.getInstance().getUsers());

                responseDocument.append("success", true);
            }
            break;

            case "deleteuser":
            {
                if (!user.hasPermission("web.deleteuser"))
                    return noPermission(httpRequest);
                User user1 = CloudNet.getInstance().getUser(value);
                boolean success = false;
                if (user1 != null) {
                    if (CloudNet.getInstance().getUsers().remove(user1)) {
                        CloudNet.getInstance().getConfig().save(CloudNet.getInstance().getUsers());
                        success = true;
                    }
                }
                responseDocument.append("success", success);
                if (!success)
                    responseDocument.append("reason", "The User was not found");
            }
            break;

            case "networkinfo":
            {
                int onlineCount = CloudNet.getInstance().getNetworkManager().getOnlineCount();
                int maxPlayers = 0;
                for (ProxyGroup proxyGroup : CloudNet.getInstance().getProxyGroups().values()) {
                    ProxyConfig proxyConfig = proxyGroup.getProxyConfig();
                    maxPlayers += (proxyConfig.getAutoSlot().isEnabled() ? onlineCount + proxyConfig.getAutoSlot().getDynamicSlotSize() : proxyConfig.getMaxPlayers());
                }
                responseDocument.append("success", true).append("response", new Document().append("onlineCount", onlineCount).append("maxPlayers", maxPlayers).obj());
            }
            break;

            case "debug":
            {
                responseDocument.append("success", true).append("response", this.webInterface.isDebug());
            }
            break;

            case "permission":
            {
                User user1 = CloudNet.getInstance().getUser(value);
                if (user1 == null) {
                    responseDocument.append("reason", "The User was not found");
                    break;
                }

                responseDocument.append("success", true).append("response", user1.hasPermission(httpRequest.headers().get("-Xpermission")));
            }
            break;

            case "playerbyname":
            {
                CloudPlayer cloudPlayer = CloudNet.getInstance().getNetworkManager().getPlayer(value);
                if (cloudPlayer != null) {
                    responseDocument.append("success", true).append("response", new Document("online", true).append("player", cloudPlayer).obj());
                } else {
                    UUID uniqueId = CloudNet.getInstance().getDbHandlers().getNameToUUIDDatabase().get(value);
                    OfflinePlayer offlinePlayer = uniqueId == null ? null : CloudNet.getInstance().getDbHandlers().getPlayerDatabase().getPlayer(uniqueId);
                    if (offlinePlayer != null) {
                        responseDocument.append("success", true).append("response", new Document("online", false).append("player", offlinePlayer).obj());
                    } else {
                        responseDocument.append("reason", "The Player is not registered in the database");
                    }
                }
            }
            break;

            case "playerbyuniqueid":
            {
                UUID uniqueId = UUID.fromString(value);
                CloudPlayer cloudPlayer = CloudNet.getInstance().getNetworkManager().getOnlinePlayer(uniqueId);
                if (cloudPlayer != null) {
                    responseDocument.append("success", true).append("response", new Document("online", true).append("player", cloudPlayer).obj());
                } else {
                    OfflinePlayer offlinePlayer = CloudNet.getInstance().getDbHandlers().getPlayerDatabase().getPlayer(uniqueId);
                    if (offlinePlayer != null) {
                        responseDocument.append("success", true).append("response", new Document("online", false).append("player", offlinePlayer).obj());
                    } else {
                        responseDocument.append("reason", "The Player is not registered in the database");
                    }
                }
            }
            break;

            case "config":
            {
                JsonElement config = this.webInterface.getConfigManager().getConfig(value);
                if (config == null) {
                    responseDocument.append("reason", "The config was not found");
                    break;
                }
                response.content().writeBytes(config.toString().getBytes(StandardCharsets.UTF_8));
                return response;
            }

            case "sendplayer":
            {
                if (!user.hasPermission("web.sendplayer"))
                    return noPermission(httpRequest);
                CloudPlayer cloudPlayer = CloudNet.getInstance().getNetworkManager().getPlayer(value);
                if (cloudPlayer == null) {
                    responseDocument.append("reason", "The player is not online");
                    break;
                }

                CorePlayerExecutor.INSTANCE.sendPlayer(cloudPlayer, httpRequest.headers().get("-Xtarget"));
                responseDocument.append("success", true);
            }
            break;

            case "shutdownwrapper":
            {
                if (!user.hasPermission("web.stopwrapper"))
                    return noPermission(httpRequest);
                Wrapper wrapper = CloudNet.getInstance().getWrappers().get(value);
                if (wrapper == null) {
                    responseDocument.append("reason", "The Wrapper was not found");
                    break;
                }

                wrapper.writeCommand("stop");
                responseDocument.append("success", true);
            }
            break;

            case "shutdownwrappers":
            {
                for (Wrapper wrapper : CloudNet.getInstance().getWrappers().values()) {
                    wrapper.writeCommand("stop");
                }
            }
            break;

            case "shutdownservers":
            {
                for (Wrapper wrapper : CloudNet.getInstance().getWrappers().values()) {
                    for (MinecraftServer minecraftServer : wrapper.getServers().values()) {
                        wrapper.stopServer(minecraftServer);
                    }
                }
            }
            break;

            case "shutdownproxys":
            {
                for (Wrapper wrapper : CloudNet.getInstance().getWrappers().values()) {
                    for (ProxyServer proxyServer : wrapper.getProxys().values()) {
                        wrapper.stopProxy(proxyServer);
                    }
                }
            }
            break;

            case "shutdown":
            {
                if (!user.hasPermission("web.stopcloud"))
                    return noPermission(httpRequest);
                CloudNet.getInstance().shutdown();
            }
            break;

        }

        response.content().writeBytes(responseDocument.toBytesAsUTF_8());

        return response;
    }

    private FullHttpResponse noPermission(HttpRequest request) {
        FullHttpResponse response = new DefaultFullHttpResponse(request.protocolVersion(), HttpResponseStatus.FORBIDDEN);
        response.content().writeBytes(noPermissionBytes);
        return response;
    }

    private static final byte[] noPermissionBytes = new Document().append("success", false).append("response", (String) null).append("reason", Collections.singletonList("Missing permissions")).toBytesAsUTF_8();

}
