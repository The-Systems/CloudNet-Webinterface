
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

if(isset($_SESSION['Logged'])){
	
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:coreloghaste\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$konsole = $json->log; 
}


if($pagestyle == 2) {
	if(isset($_SESSION['Logged'])) {
		$ch = curl_init(); 
	    curl_setopt($ch, CURLOPT_URL,            ''.$hasteurl.'/documents' );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('data'=>$konsole));
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: multipart/form-data'));
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response_array = json_decode($response_json,true);
			$hastekey = json_decode($response_json)->key;
			header('Location: '.$domain.'/logged/index.php?&erfolg=hastecreated&hastekey='.$hastekey.'#1');
			
		
    } else {
		header('Location: '.$domain.'/index.php?error=403');
//error
  
	}
} else {
	if(isset($_SESSION['Logged'])) {
		$ch = curl_init(); 
	    curl_setopt($ch, CURLOPT_URL,            ''.$hasteurl.'/documents' );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('data'=>$konsole));
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: multipart/form-data'));
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response_array = json_decode($response_json,true);
			$hastekey = json_decode($response_json)->key;
			header('Location: '.$domain.'/logged/index.php?&erfolg=hastecreated&hastekey='.$hastekey.'#1');
			 
		
    } else {
		header('Location: '.$domain.'/index.php?error=403');
//error
	}
 }

?>