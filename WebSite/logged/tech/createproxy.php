<?php
require 'mojang-api.class.php';
include '../../config.php';
session_start(); 

?>
<?php if($expireenabled == 1) {
if(isset($_SESSION['Logged'])) {
        echo " ";
        //erfolg
    } else {
		header('Location: '.$domain.'/index.php?error=403');
//error
    
}                  

                
// Session automatisch nach 5 Minuten Inaktivität beenden. 


if (isset($_SESSION['Logged']) && isset($_SESSION['expires']) && $_SESSION['expires'] < $_SERVER['REQUEST_TIME']) { 
 session_destroy(); 
 if (isset($_COOKIE[session_name()]) ) { 
  setcookie(session_name(), null, 0); 
  header('Location: '.$domain.'/index.php?error=expires'); // Weiterleitung 
 } 
 session_start(); 
 session_regenerate_id(); 
} 
$_SESSION['expires'] = $_SERVER['REQUEST_TIME'] + $expiretime; // Angabe in Sekunden 

$email = $_SESSION['email'];
}?> 
<?php if($expireenabled == 0) {
                  

               
if(isset($_SESSION['Logged'])) {
        echo " ";
        //erfolg
    } else {
		header('Location: '.$domain.'/index.php?error=403');
//error
    
}


$email = $_SESSION['email'];

}

if($pagestyle == 2) {
	if(isset($_SESSION['Logged'])) {
		
		$wrapper = $_GET['wrapper'];
		$groupname = $_GET['groupname'];
		$groupmode = $_GET['groupmode'];
		$speicherort = $_GET['speicherort'];
		$memory = $_GET['memory'];
		$minonline = $_GET['minonline'];
		$startport = $_GET['startport'];

		
		$string = '{"name": "'.$groupname.'","wrapper": ["'.$wrapper.'"],"template": {"name": "default","backend": "'.$speicherort.'","url": null,"processPreParameters": [],"installablePlugins": []},"proxyVersion": "BUNGEECORD","startPort": '.$startport.',"startup": '.$minonline.',"memory": '.$memory.',"proxyConfig": {"enabled": true,"maintenance": false,"motdsLayouts": [{"firstLine": "   §b§lCloud§f§lNet§8■ §7your §bfree §7cloudsystem §8§l【§f%version%§8§l】","secondLine": "         §aOnline §8» §7We are now §aavailable §7for §ball"}],"maintenanceMotdLayout": {"firstLine": "   §b§lCloud§f§lNet§8■ §7your §bfree §7cloudsystem §8§l【§f%version%§8§l】","secondLine": "         §bMaintenance §8» §7We are still in §bmaintenance"},"maintenaceProtocol": "§8➜ §bMaintenance §8§l【§c✘§8§l】","maxPlayers": 1000,"fastConnect": false,"customPayloadFixer": true,"autoSlot": {"dynamicSlotSize": 0,"enabled": false},"tabList": {"enabled": true,"header": " \n§b§lCloud§f§lNet §8× §7your §bfree §7cloudsystem §8➜ §f%online_players%§8/§f%max_players%§f\n §8► §7Current server §8● §b%server% §8◄ \n ","footer": " \n §7Twitter §8» §f@Dytanic §8▎ §7Discord §8» §fdiscord.gg/UNQ4wET \n §7powered by §8» §b§b§lCloud§f§lNet \n "},"playerInfo": [" ","§b§lCloud§f§lNet §8× §7your §bfree §7cloudsystem","§7Twitter §8» §f@CloudNetService","§7Discord §8» §fdiscord.gg/UNQ4wET"," "],"whitelist": [],"dynamicFallback": {"defaultFallback": "Lobby","fallbacks": [{"group": "Lobby","permission": null}]}},"proxyGroupMode": "'.$groupmode.'","settings": {}}';

		$string1 = '{"group": '.$string.'}';

		$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
		$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:updateproxygroup\r\n"."-Xvalue:".$string1."\r\n"));
		$context = stream_context_create($options);
		$jsonlol = file_get_contents($url, false, $context);
		$json = json_decode($jsonlol);
		header('Location: '.$domain.'/logged/index.php?set=proxy&erfolg=proxyerstellt');
        //erfolg
    } else {
		header('Location: '.$domain.'/index.php?error=403');
//error
	}
} else {
	if(isset($_SESSION['Logged'])) {
		
		$wrapper = $_GET['wrapper'];
		$groupname = $_GET['groupname'];
		$groupmode = $_GET['groupmode'];
		$speicherort = $_GET['speicherort'];
		$memory = $_GET['memory'];
		$minonline = $_GET['minonline'];
		$startport = $_GET['startport'];

		
		$string = '{"name": "'.$groupname.'","wrapper": ["'.$wrapper.'"],"template": {"name": "default","backend": "'.$speicherort.'","url": null,"processPreParameters": [],"installablePlugins": []},"proxyVersion": "BUNGEECORD","startPort": '.$startport.',"startup": '.$minonline.',"memory": '.$memory.',"proxyConfig": {"enabled": true,"maintenance": false,"motdsLayouts": [{"firstLine": "   §b§lCloud§f§lNet§8■ §7your §bfree §7cloudsystem §8§l【§f%version%§8§l】","secondLine": "         §aOnline §8» §7We are now §aavailable §7for §ball"}],"maintenanceMotdLayout": {"firstLine": "   §b§lCloud§f§lNet§8■ §7your §bfree §7cloudsystem §8§l【§f%version%§8§l】","secondLine": "         §bMaintenance §8» §7We are still in §bmaintenance"},"maintenaceProtocol": "§8➜ §bMaintenance §8§l【§c✘§8§l】","maxPlayers": 1000,"fastConnect": false,"customPayloadFixer": true,"autoSlot": {"dynamicSlotSize": 0,"enabled": false},"tabList": {"enabled": true,"header": " \n§b§lCloud§f§lNet §8× §7your §bfree §7cloudsystem §8➜ §f%online_players%§8/§f%max_players%§f\n §8► §7Current server §8● §b%server% §8◄ \n ","footer": " \n §7Twitter §8» §f@Dytanic §8▎ §7Discord §8» §fdiscord.gg/UNQ4wET \n §7powered by §8» §b§b§lCloud§f§lNet \n "},"playerInfo": [" ","§b§lCloud§f§lNet §8× §7your §bfree §7cloudsystem","§7Twitter §8» §f@CloudNetService","§7Discord §8» §fdiscord.gg/UNQ4wET"," "],"whitelist": [],"dynamicFallback": {"defaultFallback": "Lobby","fallbacks": [{"group": "Lobby","permission": null}]}},"proxyGroupMode": "'.$groupmode.'","settings": {}}';

		$string1 = '{"group": '.$string.'}';

		$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
		$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:updateproxygroup\r\n"."-Xvalue:".$string1."\r\n"));
		$context = stream_context_create($options);
		$jsonlol = file_get_contents($url, false, $context);
		$json = json_decode($jsonlol);
		header('Location: '.$domain.'/logged/index.php?erfolg=proxyerstellt&#3');
        //erfolg
    } else {
		header('Location: '.$domain.'/index.php?error=403');
	}
}	
?>


