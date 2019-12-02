<?php
include 'config.php';
session_start();
$true = "true";
if (isset($_POST['email']) && isset($_POST['password'])) {
    if($recapchaenabled == $true) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $response = $_POST["g-recaptcha-response"];
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $recapchaprivatkey,
            'response' => $_POST["g-recaptcha-response"]
        );
        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success = json_decode($verify);
        if ($captcha_success->success == false) {
			$error = $captcha_success->error-codes;
            header('Location: '.$domain.'/index.php?error=bot&errorcode='.$error.'&#2');
			
        } else if ($captcha_success->success == true) {
            $url1 = "http://" . $ip . ":" . $webport . "/" . $dir . "";
            $options1 = array('http' => array('method' => "GET", 'header' => "-Xcloudnet-user:" . $cloudnetuser . "\r\n" . "-Xcloudnet-token:" . $cloudnettoken . "\r\n" . "-Xmessage:authorize\r\n" . "-Xvalue:" . $email . "\r\n-Xpassword:" . $password . "\r\n"));
            $context1 = stream_context_create($options1);
            $jsonlol = file_get_contents($url1, false, $context1);
            $json1 = json_decode($jsonlol);
            if ($json1->response == true) {
				if (isset($_POST['cookielogged'])){
					setcookie("loginname", $email);
					setcookie("loginpass", $password);	
				}
                $_SESSION['email'] = $email;
                $_SESSION['Logged'] = true;
                header('Location: ' . $domain . '/logged/index.php');
            } else {
                header('Location: ' . $domain . '/index.php?error=401&#2');
            }
        }
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $url = "http://". $ip . ":" . $webport . "/" . $dir. "";
        $options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:authorize\r\n"."-Xvalue:".$email."\r\n-Xpassword:".$password."\r\n"));
        $context = stream_context_create($options);
        $jsonlol = file_get_contents($url, false, $context);
        $json = json_decode($jsonlol);
        if($json->response == true) {
			if (isset($_POST['cookielogged'])){
				setcookie("loginname", $email);
				setcookie("loginpass", $password);	
			}	
            $_SESSION['email'] = $email;
            $_SESSION['Logged'] = true;
            header('Location: '.$domain.'/logged/index.php');
        } else {
            header('Location: '.$domain.'/index.php?error=401&#2');
        }
    }
} else {
	header('Location: ' . $domain . '/index.php?error=401&#2');

}

?>