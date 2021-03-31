<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
    if ($main->getconfig("google_recaptcha_enabled") == "true") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $response = $_POST["g-recaptcha-response"];
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $main->getconfig("google_recaptcha_privat"),
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
            $error = $captcha_success->errorcodes;
            header('Location: ' . $main->getconfig("domainurl") . '?error=bot&errorcode=' . $error . '&#2');

        } else if ($captcha_success->success == true) {
            $json1 = $main->sendRequest_login("authorize", $email, $password);
            if ($json1->response == true) {
                $_SESSION['email'] = $email;
                $_SESSION['Logged'] = true;
                header('Location: ' . $main->getconfig("domainurl") . '/logged');
            } else {
                header('Location: ' . $main->getconfig("domainurl") . '?error=401&#2');
            }
        }
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $json = $main->sendRequest_login("authorize", $email, $password);
        if ($json->response == true) {
            $_SESSION['email'] = $email;
            $_SESSION['Logged'] = true;
            header('Location: ' . $main->getconfig("domainurl") . '/logged');
        } else {
            header('Location: ' . $main->getconfig("domainurl") . '?error=401&#2');
        }
    }
} else {
    header('Location: ' . $main->getconfig("domainurl") . '?error=401&#2');

}

?>