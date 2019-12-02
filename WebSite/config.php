<?php
/*
-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-*-*-**-*-*-*
	CloudNet Webinterface by Niekold (Niekold#9410)

	- You are not allowed to resell the plugin/website
	- You are not allowed to reupload the plugin/website anywhere else
    - Refunds are not accepted
    - any error/bug should be posted in the resource's thread, not in the review section otherwise I will not give a support for reported bugs in     review section
	- You are not allowed to share this resource with others
    - You are not allowed to claim ownership of this resource

	Copyrighted by Niekold © 2018
	

	|-----------|
	|0 = false	|
	|1 = true	|
	|-----------|
	
	
-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-*-*-**-*-*-*
*/


/* Configurations */

$domain = "%domain%";
$ip = "%ip%";
$webport = "%webport%";
$cloudnettoken = "%token%";
$cloudnetuser = "%user%";
$dir = "cloudnet/webinterface/api/v2";
$dircn = "cloudnet/api/v1/util";
$version = "%version%";
$versioncheck = "https://spigot.nevercold.eu/cloudnet/webinterface/version.json";
$true = "true";
$false = "false";


$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n".	"-Xmessage:testonline\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->success == true) {
	

	
	$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
	$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:config\r\n"."-Xvalue:style.json\r\n"));
	$context = stream_context_create($options);
	$jsonlol = file_get_contents($url, false, $context);
	$json = json_decode($jsonlol);
	$style = $json->colorstyle;
	$pagestyle = $json->constructionstyle;

	$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
	$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:config\r\n"."-Xvalue:recaptcha.json\r\n"));
	$context = stream_context_create($options);
	$jsonlol = file_get_contents($url, false, $context);
	$json = json_decode($jsonlol);

	$recapchaenabled = $json->enabled;
	$recapchatype = $json->type;
	$recapchakey = $json->publickey;
	$recapchaprivatkey = $json->privatkey;

	$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
	$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:config\r\n"."-Xvalue:urlshort.json\r\n"));
	$context = stream_context_create($options);
	$jsonlol = file_get_contents($url, false, $context);
	$json = json_decode($jsonlol);
	$urlshortenabled = $json->enabled;
	$urlapikey = $json->apikey;

	$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
	$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:config\r\n"."-Xvalue:haste.json\r\n"));
	$context = stream_context_create($options);
	$jsonlol = file_get_contents($url, false, $context);
	$json = json_decode($jsonlol);
	$hastenabled = $json->enabled;
	$hasteurl = $json->hasteurl;

	$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
	$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:config\r\n"."-Xvalue:expire.json\r\n"));
	$context = stream_context_create($options);
	$jsonlol = file_get_contents($url, false, $context);
	$json = json_decode($jsonlol);
	$expireenabled = $json->enabled;
	$expiretime = $json->time;

	$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
	$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:config\r\n"."-Xvalue:option.json\r\n"));
	$context = stream_context_create($options);
	$jsonlol = file_get_contents($url, false, $context);
	$json = json_decode($jsonlol);
	$debug = $json->debug;
	$servername = $json->name;

 
}
