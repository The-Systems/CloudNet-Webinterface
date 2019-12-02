package eu.thesystems.cloudnet.webinterface.command;

/*
 * Created by Mc_Ruben on 29.07.2018
 * 

 */


import de.dytanic.cloudnet.command.Command;
import de.dytanic.cloudnet.command.CommandSender;
import eu.thesystems.cloudnet.webinterface.WebInterfaceModule;

public class CommandWiVersion extends Command {

    private WebInterfaceModule webInterface;

    public CommandWiVersion(WebInterfaceModule webInterface) {
        super("wiversion", "cloudnet.eu.thesystems.cloudnet.webinterface.command.version");
        this.webInterface = webInterface;
        super.description = "prints the version of your web interface (by Niekold and derrop)";
    }

    @Override
    public void onExecuteCommand(CommandSender sender, String[] strings) {
        boolean latestVersion = this.webInterface.checkUpdates();
        sender.sendMessage("Your version: " + this.webInterface.getModuleConfig().getVersion() + " by Niekold and derrop");
        sender.sendMessage(latestVersion ? "You are up to date!" : "You have to update your WebInterfaceModule!");
    }
}
