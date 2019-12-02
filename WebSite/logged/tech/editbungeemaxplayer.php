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
		
        $options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:proxygroup\r\n"."-Xvalue:Bungee\r\n"));

		$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
        $context = stream_context_create($options);
        $jsonlol = file_get_contents($url, false, $context);
        $json = json_decode($jsonlol);

		$maxplayer = $_GET['maxplayer'];
        $json->response->proxyConfig->maxPlayers = $maxplayer;
		
    
        $update = json_encode($json->response);
		
        $options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:updateproxygroup\r\n"."-Xvalue:{\"group\":".$update."}\r\n"));

		$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
        $context = stream_context_create($options);
        $jsonlol = file_get_contents($url, false, $context);
        $json = json_decode($jsonlol);

		header('Location: '.$domain.'/logged/index.php?set=proxy&erfolg=settingerfolg');

        //erfolg
        //erfolg
    } else {
		header('Location: '.$domain.'/index.php?error=403');
//error
    
	}
} else {
	if(isset($_SESSION['Logged'])) {
		
        $options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:proxygroup\r\n"."-Xvalue:Bungee\r\n"));

		$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
        $context = stream_context_create($options);
        $jsonlol = file_get_contents($url, false, $context);
        $json = json_decode($jsonlol);

		$maxplayer = $_GET['maxplayer'];
        $json->response->proxyConfig->maxPlayers = $maxplayer;
		
    
        $update = json_encode($json->response);
		
        $options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:updateproxygroup\r\n"."-Xvalue:{\"group\":".$update."}\r\n"));

		$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
        $context = stream_context_create($options);
        $jsonlol = file_get_contents($url, false, $context);
        $json = json_decode($jsonlol);

		header('Location: '.$domain.'/logged/index.php?erfolg=settingerfolg&#3');

        //erfolg
    } else {
		header('Location: '.$domain.'/index.php?error=403');
//error
  
	}
}
?>