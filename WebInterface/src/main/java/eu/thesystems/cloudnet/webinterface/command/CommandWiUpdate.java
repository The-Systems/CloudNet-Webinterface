package eu.thesystems.cloudnet.webinterface.command;

/*
 * Created by Mc_Ruben on 10.08.2018
 * 

 */


import de.dytanic.cloudnet.command.Command;
import de.dytanic.cloudnet.command.CommandSender;
import de.dytanic.cloudnet.lib.MultiValue;
import de.dytanic.cloudnet.lib.utility.Return;
import eu.thesystems.cloudnet.webinterface.WebInterfaceModule;

public class CommandWiUpdate extends Command {

    private WebInterfaceModule webInterface;

    public CommandWiUpdate(WebInterfaceModule webInterface) {
        super("wiupdate", "cloudnet.eu.thesystems.cloudnet.webinterface.command.update");
        this.webInterface = webInterface;
        super.description = "updates the web interface (by Niekold and derrop)";
    }

    @Override
    public void onExecuteCommand(CommandSender sender, String[] strings) {
        Return<MultiValue<String, String>, Boolean> return_ = this.webInterface.checkUpdatesSilent();
        if (return_.getSecond()) {
            sender.sendMessage("You are already using the newest version");
        } else {
            this.webInterface.update(return_);
        }
    }
}
