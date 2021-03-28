<?php
class LanguageLoader {



    public function __construct() {
		
		if(isset($_SESSION['Logged'])) {
			include '../config.php';
		} else {
			include 'config.php';
		}
		$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
		$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:config\r\n"."-Xvalue:messages.json\r\n"));
		$context = stream_context_create($options);
		$jsonlol = file_get_contents($url, false, $context);
		$json = json_decode($jsonlol);
		$lang = $jsonlol;
        $this->messages = json_decode($lang, true);
    }
    public function getMessage($key) {
        return $this->messages[$key];
    }
}
?>