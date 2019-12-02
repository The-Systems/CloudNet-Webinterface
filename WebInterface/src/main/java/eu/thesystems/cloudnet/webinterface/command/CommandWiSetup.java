package eu.thesystems.cloudnet.webinterface.command;

/*
 * Created by Mc_Ruben on 11.08.2018
 * 

 */


import de.dytanic.cloudnet.command.Command;
import de.dytanic.cloudnet.command.CommandSender;
import eu.thesystems.cloudnet.webinterface.WebInterfaceModule;
import eu.thesystems.cloudnet.webinterface.setup.WiSetup;

public class CommandWiSetup extends Command {
    private WebInterfaceModule webInterface;

    public CommandWiSetup(WebInterfaceModule webInterface) {
        super("wisetup", "cloudnet.eu.thesystems.cloudnet.webinterface.command.setup");
        this.webInterface = webInterface;
        super.description = "starts the setup for the web interface (by Niekold and derrop)";
    }

    @Override
    public void onExecuteCommand(CommandSender commandSender, String[] strings) {
        new WiSetup(this.webInterface);
    }
}
