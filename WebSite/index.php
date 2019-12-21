<!DOCTYPE HTML>

<!-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --
	CloudNet Webinterface by Niekold (Niekold | DeinsystemNET#9410)

	- You are not allowed to resell the plugin
	- You are not allowed to reupload the plugin anywhere else
    - any error/bug should be posted in the resource's thread, not in the review section otherwise I will not give a support for reported bugs in     review section
    - You are not allowed to claim ownership of this resource

	Copyrighted by Niekold © 2018
	
	
	Support Discord: https://discord.gg/CYHuDpx
-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->

<?php
require 'mojang-api.class.php';
include 'config.php';

include("logged/tech/LanguageLoader.php");
$ll = new LanguageLoader();
?>
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://project.the-systems.eu/api/resource/?resourceid=1&type=latest",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 2,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$response = json_decode($response);
if (!$err) {

$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:testonline\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->success == true) {
if ($response->name != $version) {
?>
<h1><span style="color: #FF0000"> <?= $ll->getMessage("oldversion1") ?></span></h1>
<h1><span style="color: #FF0000"> <?= $ll->getMessage("oldversion2") ?></span></h1>
<?php
}
} else {
    echo '<span style="color: #FF0000"> Es konnte keine Verbindung mit dem CloudNet-Master hergestellt werden.</span>';
    exit;
}
} else {
    echo '<span style="color: #FF0000"> Einer Fehler beim Verbinden zum Kontrolserver ist aufgetreten.</span>';
    exit;
}


$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:testonline\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->success == true) {

session_start();

if(isset($_SESSION['Logged'])) {
    header('Location: '.$domain.'/logged/index.php');
    //man wird automatisch geleitet wenn eingeloggt
}


if(isset($_COOKIE['loginname'])) {
    $email = $_COOKIE['loginname'];
    $password = $_COOKIE['loginpass'];
    $url = "http://". $ip . ":" . $webport . "/" . $dir. "";
    $options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:authorize\r\n"."-Xvalue:".$email."\r\n-Xpassword:".$password."\r\n"));
    $context = stream_context_create($options);
    $jsonlol = file_get_contents($url, false, $context);
    $json = json_decode($jsonlol);
    if($json->response == true) {
        $_SESSION['email'] = $email;
        $_SESSION['Logged'] = true;
        header('Location: '.$domain.'/logged/index.php?test=erfolgreich');
    }

}


?>

<html>
<head>
    <title><?php echo $servername; ?></title>
    <meta name="description" content="<?php echo $servername; ?>">
    <meta name="theme-color" content="#424242">
    <meta charset="UTF-8">
    <script src="js/jquery.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/skel-layers.min.js"></script>
    <script src="js/init.js"></script>
    <?php
    if($recapchaenabled == $true) {
    if($recapchatype == 1) { ?>
        <script src='https://www.google.com/recaptcha/api.js'></script><?php
    }
    if($recapchatype == 2) { ?>
        <script src='https://www.google.com/recaptcha/api.js'></script><?php
    }
    if($recapchatype == 3) { ?>
        <script src='https://www.google.com/recaptcha/api.js?<?php echo $recapchakey;?>'></script><?php
    }
    }
    ?>
    <script>
        function onSubmit(token) {
            document.getElementById("login").submit();
        }
    </script>

    <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-xlarge.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    </noscript>

</head>

<body id="landing">
<!-- Header -->

<header id="header">


    <h1><a href="<?php echo $domain; ?>"><?php echo $servername; ?></a></h1>
    <nav id="nav">
        <ul>
            <li><a>
                    <?= $ll->getMessage("cloudstatus") ?>
                    <?php
                    $url = "http://". $ip . ":" . $webport . "/" . $dir. "";
                    $options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:testonline\r\n"."-Xvalue:\r\n"));
                    $context = stream_context_create($options);
                    $jsonlol = file_get_contents($url, false, $context);
                    $json = json_decode($jsonlol);
                    if ($json->success == true) {
                        echo '<span style="color: #40FF00"> ' .$ll->getMessage("online") . '</span>';
                    } else {
                        echo '<span style="color: #FF0000"> ' .$ll->getMessage("offline") . '</span>';
                    }

                    ?></a></li>
        </ul>
    </nav>
</header>
<!-- One -->
<section id="one" class="wrapper style<?php echo $style; ?>">
    <header class="major">
        <h2><?php echo $servername; ?></h2>
    </header>
    <div class="container">
        <div class="row">
            <div class="6u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("webinterface") ?></h3>
                    <p><?= $ll->getMessage("loginacc") ?></p>
                    <p></p>
                    <p><?= $ll->getMessage("data") ?></p>
                    <p></p>
                    <?php
                    if ($response->name != $version) { ?>
                        <h1><span style="color: #FF0000"> <?= $ll->getMessage("oldversion1") ?></span></h1>
                        <h1><span style="color: #FF0000"> <?= $ll->getMessage("oldversion2") ?></span></h1><?php
                    }
                    ?>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="6u 12u$(medium)">
                <section id="2" class="box">
                    <h3><?= $ll->getMessage("login") ?></h3>
                    <?php
                    if ($recapchatype == "2") {
                        echo $ll->getMessage("recaptchaloginon");
                    }?>
                    <p></p>
                    <form id="login" action="login.php" method="post">
                        <p><?= $ll->getMessage("username") ?>: <input type="text" name="email" class="form-control" placeholder="<?= $ll->getMessage("username") ?>" required /></p>
                        <p><?= $ll->getMessage("password") ?>: <input type="password" name="password" class="form-control" placeholder="<?= $ll->getMessage("password") ?>" autocomplete="off" required /></p>
                        <input type="checkbox" id="cookielogged" name="cookielogged">
                        <label for="cookielogged"><?= $ll->getMessage("savecookie") ?></label>
                        <p></p>


                        <?php
                        $true = "true";
                        if($recapchaenabled == $true) {
                        if($recapchatype == 1) { ?>
                        <div class="g-recaptcha" data-sitekey="<?php echo $recapchakey; ?>" required /></div>
            <p></p>
            <input type="submit" value="<?= $ll->getMessage("loginin") ?>" /><?php
            }
            if($recapchatype == 2) { ?>
                <input
                        class="g-recaptcha"
                        type="submit"
                        value="<?= $ll->getMessage("loginin") ?>"
                        data-sitekey="<?php echo $recapchakey;?>"
                        data-callback="onSubmit">
                </input> <?php
            }
            if($recapchatype == 3) { ?>

                <input
                        class="g-recaptcha"
                        type="submit"
                        value="<?= $ll->getMessage("loginin") ?>"
                        data-sitekey="<?php echo $recapchakey;?>"
                        data-callback="onSubmit">
                </input> <?php
            }
            } else { ?>
                <input type="submit" value="<?= $ll->getMessage("loginin") ?>" />
                <?php
            }
            ?>
            <p></p>
            </form>

            <p><?php
                if(isset($_GET["error"])) {
                    if($_GET["error"] == "401") {
                        echo '<span style="color: #FF0000"> ' . $ll->getMessage("error1") . '</span>';
                    }
                    if($_GET["error"] == "403") {
                        echo '<span style="color: #FF0000"> ' . $ll->getMessage("error2") . '</span>';
                    }
                    if($_GET["error"] == "logout") {
                        echo '<span style="color: #40FF00"> ' . $ll->getMessage("error3") . '</span>';
                    }
                    if($_GET["error"] == "expires") {
                        echo '<span style="color: #FF0000"> ' . $ll->getMessage("error4") . '</span>';
                    }
                    if($_GET["error"] == "shutdown") {
                        echo '<span style="color: #40FF00"> ' . $ll->getMessage("error5") . '</span>';
                    }
                    if($_GET["error"] == "bot") {
                        echo '<span style="color: #FF0000"> ' . $ll->getMessage("error6") . ' (' . $_GET['errorcode'] . ')</span>';
                    }
                    if($_GET["error"] == "versionerror") {
                        echo '<span style="color: #FF0000"> ' . $ll->getMessage("error7") . '</span>';
                    }
                }
                ?></p>
</section>
          </div>
        </div>
    </div>
<?php
}
?>

</body>
</html>
