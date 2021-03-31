package eu.thesystems.cloudnet.webinterface;

/*
 * Created by Mc_Ruben on 13.07.2018
 * 

 */


import com.google.gson.JsonParser;
import com.google.gson.reflect.TypeToken;
import de.dytanic.cloudnet.lib.MultiValue;
import de.dytanic.cloudnet.lib.utility.Return;
import de.dytanic.cloudnet.lib.utility.document.Document;
import de.dytanic.cloudnet.lib.zip.ZipConverter;
import de.dytanic.cloudnetcore.CloudNet;
import de.dytanic.cloudnetcore.api.CoreModule;
import eu.thesystems.cloudnet.webinterface.command.CommandWiSetup;
import eu.thesystems.cloudnet.webinterface.command.CommandWiUpdate;
import eu.thesystems.cloudnet.webinterface.command.CommandWiVersion;
import eu.thesystems.cloudnet.webinterface.webhandler.RestAPIHandler;
import io.netty.util.internal.PlatformDependent;
import lombok.Getter;
import net.md_5.bungee.config.Configuration;
import net.md_5.bungee.config.ConfigurationProvider;
import net.md_5.bungee.config.YamlConfiguration;

import java.io.*;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Collection;

@lombok.ToString
@lombok.Getter
public class WebInterfaceModule extends CoreModule {

    private static final JsonParser PARSER = new JsonParser();

    private StringBuilder corelog = new StringBuilder();
    private boolean debug;

    private ConfigManager configManager = new ConfigManager(this);

    @Override
    public void onBootstrap() {
        registerCommand(new CommandWiVersion(this));
        registerCommand(new CommandWiUpdate(this));
        registerCommand(new CommandWiSetup(this));

        if (!checkUpdates()) {
            return;
        }

        this.configManager.loadConfigs();

        //add LoggerHandler
        CloudNet.getLogger().getHandler().add(line -> corelog.append("<p>").append(line).append("</p>"));

        //Register Webhandler
        getCloud().getWebServer().getWebServerProvider().registerHandler(new RestAPIHandler(this));

        File file = new File("modules/Webinterface/config.yml");
        if (!file.exists()) {
            file.getParentFile().mkdirs();
            try {
                file.createNewFile();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
        try {
            Configuration configuration = ConfigurationProvider.getProvider(YamlConfiguration.class).load(file);
            if (!configuration.contains("debug")) {
                configuration.set("debug", false);
                ConfigurationProvider.getProvider(YamlConfiguration.class).save(configuration, file);
            }

            if (!configuration.contains("websocket.host")) {
                configuration.set("websocket.host", getCloud().getConfig().getAddresses().iterator().next().getHostName());
                ConfigurationProvider.getProvider(YamlConfiguration.class).save(configuration, file);
            }

            if (!configuration.contains("websocket.port")) {
                configuration.set("websocket.port", 1430);
                ConfigurationProvider.getProvider(YamlConfiguration.class).save(configuration, file);
            }

            this.debug = configuration.getBoolean("debug");
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public boolean checkUpdates() {
        Document document = loadWebsite("https://project.the-systems.eu/api/resource/?resourceid=1&type=allinfos");

        if (document == null || !document.contains("response")) {
            System.out.println("[WebInterfaceModule] There was an error while parsing the version");
            return true;
        }

        Document response = new Document(document.get("response").getAsJsonObject());

        String newestVersion = response.getString("version");
        Collection<String> oldVersions = response.getObject("oldversion", new TypeToken<Collection<String>>() {
        }.getType());
        String currentVersion = getModuleConfig().getVersion();

        if (newestVersion.equals(currentVersion)) {
            System.out.println("[WebInterfaceModule] You are using the newest version of the Webinterface");
            return true;
        }

        if (oldVersions.contains(currentVersion)) {
            System.out.println("[WebInterfaceModule] You are using an old version of the Webinterface, you will get NO SUPPORT, please update with \"wiupdate\"");
            return true;
        }

        System.out.println("[WebInterfaceModule] You are using a disabled version of the Webinterface, please update with \"wiupdate\"");
        System.out.println("[WebInterfaceModule] The Module will be disabled");

        return false;
    }

    public Return<MultiValue<String, String>, Boolean> checkUpdatesSilent() {
        Document document = loadWebsite("https://project.the-systems.eu/api/resource/?resourceid=1&type=allinfos");

        if (document == null || !document.contains("response")) {
            System.out.println("[WebInterfaceModule] There was an error while parsing the version");
            return new Return<>(null, true);
        }

        Document response = new Document(document.get("response").getAsJsonObject());

        String newestVersion = response.getString("version");
        Collection<String> oldVersions = response.getObject("oldversion", new TypeToken<Collection<String>>() {
        }.getType());
        String currentVersion = getModuleConfig().getVersion();

        if (newestVersion.equals(currentVersion)) {
            return new Return<>(null, true);
        }

        if (oldVersions.contains(currentVersion)) {
            System.out.println("Your're using an old version, you WON'T GET ANY SUPPORT if you don't update");
            return new Return<>(new MultiValue<>(response.getString("versiondlzip"), response.getString("versiondljar")), false);
        }

        return new Return<>(new MultiValue<>(response.getString("versiondlzip"), response.getString("versiondljar")), false);
    }

    private Document loadWebsite(String url) {
        try {
            URLConnection connection = new URL(url).openConnection();
            connection.setRequestProperty("User-Agent", "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11");
            connection.connect();
            try (InputStream inputStream = connection.getInputStream();
                 InputStreamReader inputStreamReader = new InputStreamReader(inputStream)) {

                Document document = new Document(PARSER.parse(inputStreamReader).getAsJsonObject());
                inputStreamReader.close();
                inputStream.close();

                return document;
            }
        } catch (IOException e) {
            e.printStackTrace();
        }

        return null;
    }

    public void update(Return<MultiValue<String, String>, Boolean> response) {
        System.out.println("Updating the Webinterface...");

        File file = new File("Website");
        if (!file.exists()) {
            file.mkdir();
        } else {
            deleteDirectory(file);
        }


        try {
            HttpURLConnection httpURLConnection = (HttpURLConnection) (new URL(response.getFirst().getFirst())).openConnection();
            httpURLConnection.setRequestProperty("User-Agent", "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11");
            httpURLConnection.setUseCaches(false);
            httpURLConnection.setConnectTimeout(1000);
            httpURLConnection.connect();
            InputStream inputStream = httpURLConnection.getInputStream();
            ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
            byte[] buf = new byte[4096];
            int len;
            while ((len = inputStream.read(buf)) != -1) {
                byteArrayOutputStream.write(buf, 0, len);
            }
            byte[] zip = byteArrayOutputStream.toByteArray();
            inputStream.close();
            httpURLConnection.disconnect();
            this.extractTo(zip, "Website");
            this.readAndWriteConfig("Website/config/config.php");
        } catch (IOException e) {
            e.printStackTrace();
        }

        {
            if (PlatformDependent.isWindows()) {
                System.err.println("[WebInterfaceModule] CANNOT UPDATE THE JAR, YOU ARE ON WINDOWS");
                System.err.println("[WebInterfaceModule] You have to download and update the Jar manually!");
                return;
            }
            try {
                HttpURLConnection httpURLConnection = (HttpURLConnection) (new URL(response.getFirst().getSecond())).openConnection();
                httpURLConnection.setRequestProperty("User-Agent", "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11");
                httpURLConnection.setUseCaches(false);
                httpURLConnection.setConnectTimeout(1000);
                httpURLConnection.connect();
                InputStream inputStream = httpURLConnection.getInputStream();
                File configFile = getModuleConfig().getFile();
                if (!configFile.exists()) {
                    configFile.createNewFile();
                }
                FileOutputStream fileOutputStream = new FileOutputStream(configFile);
                byte[] buf = new byte[4096];
                int len;
                while ((len = inputStream.read(buf)) != -1) {
                    fileOutputStream.write(buf, 0, len);
                }
                inputStream.close();
                fileOutputStream.close();
                httpURLConnection.disconnect();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }

        System.out.println("Successfully updated the WebInterfaceModule, please restart the Cloud and put your Website directory onto your WebServer again just as in the first setup");
    }

    private void readAndWriteConfig(String outputPath) throws IOException {
        Document updateConfigurations = CloudNet.getInstance().getDbHandlers().getUpdateConfigurationDatabase().get();
        if (!updateConfigurations.contains("webinterface_config")) {
            updateConfigurations.append("webinterface_setup_complete", false);
            CloudNet.getInstance().getDbHandlers().getUpdateConfigurationDatabase().set(updateConfigurations);
            return;
        }

        Collection<String> config = updateConfigurations.getObject("webinterface_config", new TypeToken<Collection<String>>() {
        }.getType());

        File file = new File(outputPath);
        if (!file.exists()) {
            file.createNewFile();
        }
        FileOutputStream fileOutputStream = new FileOutputStream(file);
        PrintWriter printWriter = new PrintWriter(fileOutputStream);

        for (String line : config) {
            if (line.equals("%version%")) {
                printWriter.println(line.replace("%version%", getModuleConfig().getVersion()));
            } else {
                printWriter.println(line);
            }
            printWriter.flush();
        }

        fileOutputStream.close();
        printWriter.close();

    }

    private void extractTo(byte[] bytes, String outputPath) throws IOException {
        Path path = Paths.get(outputPath);
        if (!Files.exists(path))
            Files.createFile(path);

        /*InputStream inputStream = new ByteArrayInputStream(bytes);
        ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();

        byte[] buf = new byte[4096];
        int len;
        while ((len = inputStream.read(buf)) != -1) {
            byteArrayOutputStream.write(buf, 0, len);
        }*/

        ZipConverter.extract(bytes, path);

        //inputStream.close();
    }

    public void deleteDirectory(File file) {
        for (File subFile : file.listFiles()) {
            if (subFile.isDirectory()) {
                deleteDirectory(subFile);
            } else {
                subFile.delete();
            }
        }
    }

}
