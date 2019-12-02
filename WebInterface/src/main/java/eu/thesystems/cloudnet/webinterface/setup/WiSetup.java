package eu.thesystems.cloudnet.webinterface.setup;

/*
 * Created by Mc_Ruben on 05.08.2018
 * 

 */


import de.dytanic.cloudnet.lib.NetworkUtils;
import de.dytanic.cloudnet.lib.server.ProxyGroup;
import de.dytanic.cloudnet.lib.user.BasicUser;
import de.dytanic.cloudnet.lib.user.User;
import de.dytanic.cloudnet.lib.utility.Catcher;
import de.dytanic.cloudnet.lib.utility.CollectionWrapper;
import de.dytanic.cloudnet.lib.utility.Return;
import de.dytanic.cloudnet.lib.utility.document.Document;
import de.dytanic.cloudnet.lib.zip.ZipConverter;
import de.dytanic.cloudnet.setup.Setup;
import de.dytanic.cloudnet.setup.SetupRequest;
import de.dytanic.cloudnet.setup.SetupResponseType;
import de.dytanic.cloudnetcore.CloudNet;
import de.dytanic.cloudnetcore.network.components.WrapperMeta;
import eu.thesystems.cloudnet.webinterface.WebInterfaceModule;

import java.io.*;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Arrays;
import java.util.Collection;
import java.util.LinkedList;

public class WiSetup extends Setup {

    private WebInterfaceModule webInterface;

    public WiSetup(WebInterfaceModule webInterface) {
        this.webInterface = webInterface;
        setupComplete(document -> {
            System.out.println("Das Setup wird beendet...");

            Document updateConfigurations = CloudNet.getInstance().getDbHandlers().getUpdateConfigurationDatabase().get();

            String serverName = document.getString("name");
            String domain = document.getString("domain");
            String ip = CloudNet.getInstance().getConfig().getConfig().getString("server.webservice.hostaddress");
            int webport = CloudNet.getInstance().getConfig().getConfig().getInt("server.webservice.port");
            String userName;
            String token;
            String bungeeip;
            int bungeeport;

            {
                User user = new BasicUser(document.getString("username"), document.getString("password"), Arrays.asList("*"));
                for (User x : CloudNet.getInstance().getUsers()) {
                    if (x.getName().equals(user.getName())) {
                        CloudNet.getInstance().getUsers().remove(x);
                    }
                }
                CloudNet.getInstance().getUsers().add(user);
                CloudNet.getInstance().getConfig().save(CloudNet.getInstance().getUsers());
            }

            {
                User user = getUserWithAllPermissions();

                userName = user.getName();
                token = user.getApiToken();
            }

            {
                Return<String, Integer> hostAndPort = getBungeeHostAndPort();
                bungeeip = hostAndPort.getFirst();
                bungeeport = hostAndPort.getSecond();
            }

            {
                if (!domain.startsWith("http://") && !domain.startsWith("https://"))
                    domain = "http://" + domain;
                if (domain.endsWith("/"))
                    domain = domain.substring(0, domain.length() - 1);
            }

            {
                File file = new File("Website");
                if (file.exists())
                    this.webInterface.deleteDirectory(file);

                file.mkdir();

                try {
                    String finalDomain = domain;
                    readAndWriteConfig(updateConfigurations, "Website/config.php", input -> input.replace("%server_name%", serverName)
                            .replace("%domain%", finalDomain)
                            .replace("%ip%", ip)
                            .replace("%webport%", String.valueOf(webport))
                            .replace("%token%", token)
                            .replace("%user%", userName)
                            .replace("%bungeeip%", bungeeip)
                            .replace("&bungeeport%", String.valueOf(bungeeport))
                            .replace("%version%", this.webInterface.getModuleConfig().getVersion()));
                    extractTo("Website");
                } catch (IOException e) {
                    e.printStackTrace();
                }

            }

            System.out.println("Das Setup wurde erfolgreich beendet, du findest dein Webinterface in \"CloudNet-Master/Website\", bitte kopiere den Inhalt davon auf deinen Webserver");
            updateConfigurations.append("webinterface_setup_complete", true);
            CloudNet.getInstance().getDbHandlers().getUpdateConfigurationDatabase().set(updateConfigurations);
        })
                .setupCancel(() -> System.out.println("Du hast das Setup abgebrochen"))

                .request(new SetupRequest("name", "Wie lautet der Name des Webinterfaces? (Dieser wird auf dem Webinterface als Header angezeigt)", "", SetupResponseType.STRING, s -> true))
                .request(new SetupRequest("domain", "Wie lautet die genaue URL zu dem Webinterface? (falls dein Webinterface in einem Unterordner auf deinem Webserver liegen soll, muss dieser mit angegeben werden)", "", SetupResponseType.STRING, s -> true))
                .request(new SetupRequest("username", "Wie lautet der Name deines ersten Accounts?", "Dieser User existiert bereits", SetupResponseType.STRING, s -> CloudNet.getInstance().getUser(s) == null))
                .request(new SetupRequest("password", "Wie lautet das Passwort deines ersten Accounts?", "", SetupResponseType.STRING, s -> true))
                //.request(new SetupRequest("time", "Nach wie vielen Sekunden soll man automatisch ausgeloggt werden?", "Deine Eingabe muss eine Zahl sein", SetupResponseType.NUMBER, s -> true))

                .start(CloudNet.getLogger().getReader());
    }

    private User getUserWithAllPermissions() {
        User user = CollectionWrapper.filter(CloudNet.getInstance().getUsers(), user1 -> user1.hasPermission("*"));

        if (user == null) {
            user = new BasicUser("webinterfaceadmin", NetworkUtils.randomString(16), Arrays.asList("*"));
            CloudNet.getInstance().getUsers().add(user);
            CloudNet.getInstance().getConfig().save(CloudNet.getInstance().getUsers());
        }

        return user;
    }

    private Return<String, Integer> getBungeeHostAndPort() {
        for (ProxyGroup proxyGroup : CloudNet.getInstance().getProxyGroups().values()) {
            for (String wrapperName : proxyGroup.getWrapper()) {
                WrapperMeta wrapper = CollectionWrapper.filter(CloudNet.getInstance().getConfig().getWrappers(), wrapperMeta -> wrapperMeta.getId().equals(wrapperName));
                if (wrapper != null) {
                    return new Return<>(wrapper.getHostName(), proxyGroup.getStartPort());
                }
            }
        }
        return new Return<>("Ein Fehler ist aufgetreten", -1);
    }

    private void readAndWriteConfig(Document updateConfigurations, String outputPath, Catcher<String, String> catcher) throws IOException {
        Collection<String> config = new LinkedList<>();

        InputStream inputStream = WiSetup.class.getClassLoader().getResourceAsStream("files/config.php");
        InputStreamReader inputStreamReader = new InputStreamReader(inputStream);
        BufferedReader bufferedReader = new BufferedReader(inputStreamReader);

        File file = new File(outputPath);
        if (!file.exists()) {
            file.createNewFile();
        }
        FileOutputStream fileOutputStream = new FileOutputStream(file);
        PrintWriter printWriter = new PrintWriter(fileOutputStream);

        String input;
        while ((input = bufferedReader.readLine()) != null) {
            String line = catcher.doCatch(input);
            if (input.equals("%version%")) {
                config.add(input);
            } else {
                config.add(line);
            }
            printWriter.println(line);
            printWriter.flush();
        }

        fileOutputStream.close();
        printWriter.close();

        bufferedReader.close();
        inputStreamReader.close();
        inputStream.close();

        updateConfigurations.append("webinterface_config", config);
    }

    private void extractTo(String outputPath) throws IOException {
        Path path = Paths.get(outputPath);
        if (!Files.exists(path))
            Files.createFile(path);

        InputStream inputStream = WiSetup.class.getClassLoader().getResourceAsStream("files/Website.zip");
        ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();

        byte[] buf = new byte[4096];
        int len;
        while ((len = inputStream.read(buf)) != -1) {
            byteArrayOutputStream.write(buf, 0, len);
        }

        ZipConverter.extract(byteArrayOutputStream.toByteArray(), path);

        inputStream.close();
    }

}
