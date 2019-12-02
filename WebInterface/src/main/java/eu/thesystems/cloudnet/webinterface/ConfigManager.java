package eu.thesystems.cloudnet.webinterface;
/*
 * Created by Mc_Ruben on 21.10.2018
 */

import com.google.gson.JsonElement;
import com.google.gson.JsonParser;
import net.md_5.bungee.config.Configuration;
import net.md_5.bungee.config.ConfigurationProvider;
import net.md_5.bungee.config.YamlConfiguration;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Collection;
import java.util.HashMap;
import java.util.Map;

public class ConfigManager {

    private WebInterfaceModule webInterface;

    private Map<String, JsonElement> configsCache = new HashMap<>();

    public ConfigManager(WebInterfaceModule webInterface) {
        this.webInterface = webInterface;
    }

    void loadConfigs() {
        try (InputStream inputStream = this.webInterface.getClassLoader().getResourceAsStream("configs/configs.yml")) {
            Configuration configuration = ConfigurationProvider.getProvider(YamlConfiguration.class).load(inputStream);
            Collection<String> configs = configuration.getStringList("configs");
            for (String name : configs) {
                loadConfig(name);
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private void loadConfig(String name) {
        if (Files.exists(Paths.get("modules/Webinterface/" + name))) {
            return;
        }
        try (InputStream inputStream = this.webInterface.getClassLoader().getResourceAsStream("configs/" + name);
             InputStreamReader inputStreamReader = new InputStreamReader(inputStream);
             BufferedReader bufferedReader = new BufferedReader(inputStreamReader)) {
            StringBuilder stringBuilder = new StringBuilder();
            String line;
            while ((line = bufferedReader.readLine()) != null) {
                stringBuilder.append(line).append("\n");
            }
            bufferedReader.close();
            inputStreamReader.close();
            inputStream.close();
            Path path = Paths.get("modules/Webinterface/" + name);
            if (!Files.exists(path)) {
                Path parent = path.getParent();
                if (parent != null && !Files.exists(parent))
                    Files.createDirectories(parent);
                Files.createFile(path);
            }
            Files.write(path, stringBuilder.toString().getBytes(StandardCharsets.UTF_8));
            this.configsCache.put(name, JsonParser.parseString(stringBuilder.toString()));
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public JsonElement getConfig(String name) {
        if (this.configsCache.containsKey(name))
            return this.configsCache.get(name);
        if (Files.exists(Paths.get("modules/Webinterface/" + name))) {
            try {
                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(Files.newInputStream(Paths.get("modules/Webinterface/" + name))));
                StringBuilder builder = new StringBuilder();
                String line;
                while ((line = bufferedReader.readLine()) != null) {
                    builder.append(line);
                }
                JsonElement config = JsonParser.parseString(builder.toString());
                this.configsCache.put(name, config);
                return config;
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
        return null;
    }

}
