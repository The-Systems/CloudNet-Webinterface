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
		$servertype = $_GET['servertype'];
		$groupmode = $_GET['groupmode'];
		$speicherort = $_GET['speicherort'];
		$memory = $_GET['memory'];
		$onlinegroup = $_GET['onlinegroup'];
		$onlineglobal = $_GET['onlineglobal'];
		$minonline = $_GET['minonline'];
		$percent = $_GET['percent'];

		
		$string = '{"group": {"name": "'.$groupname.'","wrapper": ["'.$wrapper.'"],"kickedForceFallback": true,"serverType": "'.$servertype.'","groupMode": "'.$groupmode.'","globalTemplate": {"name": "globaltemplate","backend": "'.$speicherort.'","url": null,"processPreParameters": [],"installablePlugins": []},"templates": [{"name": "default","backend": "'.$speicherort.'","url": null,"processPreParameters": [],"installablePlugins": []}],"memory": "'.$memory.'","dynamicMemory": "'.$memory.'","joinPower": 0,"maintenance": true,"minOnlineServers": "'.$minonline.'","maxOnlineServers": -1,"advancedServerConfig": {"notifyPlayerUpdatesFromNoCurrentPlayer": true,"notifyProxyUpdates": true,"notifyServerUpdates": true,"disableAutoSavingForWorlds": true},"percentForNewServerAutomatically": "'.$percent.'","priorityService": {"stopTimeInSeconds": 300,"global": {"onlineServers": "'.$onlineglobal.'","onlineCount": 100},"group": {"onlineServers": "'.$onlinegroup.'","onlineCount": 100}},"settings": {}}}';;


		$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
		$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:updateservergroup\r\n"."-Xvalue:".$string."\r\n"));
		$context = stream_context_create($options);
		$jsonlol = file_get_contents($url, false, $context);
		$json = json_decode($jsonlol);
		header('Location: '.$domain.'/logged/index.php?set=server&erfolg=gruppeerstellt');
        //erfolg
    } else {
		header('Location: '.$domain.'/index.php?error=403');
//error
	}
} else {
	if(isset($_SESSION['Logged'])) {
		
		$wrapper = $_GET['wrapper'];
		$groupname = $_GET['groupname'];
		$servertype = $_GET['servertype'];
		$groupmode = $_GET['groupmode'];
		$speicherort = $_GET['speicherort'];
		$memory = $_GET['memory'];
		$onlinegroup = $_GET['onlinegroup'];
		$onlineglobal = $_GET['onlineglobal'];
		$minonline = $_GET['minonline'];
		$percent = $_GET['percent'];

		
		$string = '{"group": {"name": "'.$groupname.'","wrapper": ["'.$wrapper.'"],"kickedForceFallback": true,"serverType": "'.$servertype.'","groupMode": "'.$groupmode.'","globalTemplate": {"name": "globaltemplate","backend": "'.$speicherort.'","url": null,"processPreParameters": [],"installablePlugins": []},"templates": [{"name": "default","backend": "'.$speicherort.'","url": null,"processPreParameters": [],"installablePlugins": []}],"memory": "'.$memory.'","dynamicMemory": "'.$memory.'","joinPower": 0,"maintenance": true,"minOnlineServers": "'.$minonline.'","maxOnlineServers": -1,"advancedServerConfig": {"notifyPlayerUpdatesFromNoCurrentPlayer": true,"notifyProxyUpdates": true,"notifyServerUpdates": true,"disableAutoSavingForWorlds": true},"percentForNewServerAutomatically": "'.$percent.'","priorityService": {"stopTimeInSeconds": 300,"global": {"onlineServers": "'.$onlineglobal.'","onlineCount": 100},"group": {"onlineServers": "'.$onlinegroup.'","onlineCount": 100}},"settings": {}}}';;


		$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
		$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:updateservergroup\r\n"."-Xvalue:".$string."\r\n"));
		$context = stream_context_create($options);
		$jsonlol = file_get_contents($url, false, $context);
		$json = json_decode($jsonlol);
		header('Location: '.$domain.'/logged/index.php?erfolg=gruppeerstellt&#3');
        //erfolg
    } else {
		header('Location: '.$domain.'/index.php?error=403');
//error
	}
}	
?>


