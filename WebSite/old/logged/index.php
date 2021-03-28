<?php 
include '../config.php';
session_start(); 

$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n".	"-Xmessage:testonline\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($versioncheck, false, $context);
$json = json_decode($jsonlol);
if ($json->success == true) {

		if($pagestyle == 2) {
			if(isset($_GET["set"])) {
				if($_GET["set"] == "server") { 
				include "tech/page/style2/server.php";
				}
				if($_GET["set"] == "proxy") { 
				include "tech/page/style2/proxy.php";
				} 
			} else {
				include "tech/page/style2/index.php";
				}
	
									
		} else {
		include "tech/page/style1/index.php";
		}

} else {
   session_destroy();
   setcookie("loginname","1",time()-1);
   setcookie("loginpass","1",time()-1);
   header('Location: '.$domain.'/index.php');

}	
	?> 
