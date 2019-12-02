<!DOCTYPE HTML>

<?php
session_start(); 
require 'tech/mojang-api.class.php';
include '../config.php';

include("tech/LanguageLoader.php");
$ll = new LanguageLoader();


  $options = array('http'=>array('method'=>"GET",'header'=>"-Xversion:aktuelleversion\r\n"));
  $context = stream_context_create($options);
  $jsonlol = file_get_contents($versioncheck, false, $context);
  $json = json_decode($jsonlol);
  $oldversion = $json->response->oldversion;
  
if (in_array($version, $oldversion)) { ?>
	<h1><span style="color: #FF0000"> <?= $ll->getMessage("oldversion1") ?></span></h1>
	<h1><span style="color: #FF0000"> <?= $ll->getMessage("oldversion2") ?></span></h1><?php
}
?>
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>
<?php
  $options = array('http'=>array('method'=>"GET",'header'=>"-Xversion:aktuelleversion\r\n"));
  $context = stream_context_create($options);
  $jsonlol = file_get_contents($versioncheck, false, $context);
  $json = json_decode($jsonlol);
  $publicversion = $json->response->publicversion;
  
if (in_array($version, $publicversion)){
	} else {
		session_destroy();
		setcookie("loginname","1",time()-1);
		setcookie("loginpass","1",time()-1); 
		header('Location: '.$domain.'/index.php?error=versionerror');
	} 
	?>
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>
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



$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.editproxy\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
	echo "";
} else {
	header('Location: '.$domain.'/logged/');
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
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		</noscript>
<style>

table {
    width: 100%;
    margin: 2em 0;
    border-collapse: collapse;
    word-break:normal;
}

td {
    padding: .5em;
    vertical-align: top;
    border: 1px solid #bbbbbb;
}

th {
    padding: .5em;
    text-align: left;
    border: 1px solid #bbbbbb;
    border-bottom: 3px solid #bbbbbb;
    background:#f4f7fa;
}

	
.table-scrollable {
	width: 100%;
	overflow-y: auto;
	margin: 0 0 1em;	
}

.table-scrollable::-webkit-scrollbar {
	-webkit-appearance: none;
	width: 14px;
	height: 14px;
}

.table-scrollable::-webkit-scrollbar-thumb {
	border-radius: 8px;
	border: 3px solid #fff;
	background-color: rgba(0, 0, 0, .3);
}

</style>
		
		
</head>

<body id="landing">
<!-- Header -->

<header id="header">


    <h1><a href="<?php echo $domain; ?>"><?php echo $servername; ?></a></h1>
    <nav id="nav">
        <ul>
		<?php
		if($pagestyle == 1) {
			?>
			<li><a href="#1"><?= $ll->getMessage("header1") ?></a></li>
			<li><a href="#2"><?= $ll->getMessage("header2") ?></a></li>
			<li><a href="#3"><?= $ll->getMessage("header3") ?></a></li>
			<li><a href="#4"><?= $ll->getMessage("header4") ?></a></li>
			<li><a href="#5"><?= $ll->getMessage("header5") ?></a></li>
			<li><a href="#6"><?= $ll->getMessage("header6") ?></a></li>
			<?php
		} else {
			?>
			<li><a href="index.php"><?= $ll->getMessage("startpage") ?></a></li>
			<li><a href="index.php?set=server"><?= $ll->getMessage("serverpage") ?></a></li>
			<li><a href="index.php?set=proxy"><?= $ll->getMessage("proxypage") ?></a></li>
			<?php
		}
		?>
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
            <div class="20u 12u$(medium)">
                <section class="box">
                    <h5><?php 
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:corelog\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);



$log = $json->log;



echo $log;   
?>  </h5>
                </section>
            </div>
			
			<div class="6u 12u$(medium)">
                <section id="1" class="box">
                    <h3><?= $ll->getMessage("sendcommandtoconsole") ?></h3>
                    <p><?= $ll->getMessage("sendcommandtoconsoleinfo") ?></p>
				<form action="tech/consoledispatchcommand.php" method="get">
					<p><?= $ll->getMessage("command") ?>: <input type="text" name="command" class="form-control" placeholder="<?= $ll->getMessage("command") ?>" required /></p>
					<p></p>
					<input type="submit" value="<?= $ll->getMessage("sendcommand") ?>" />
				</form>	
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "commandsend") { 
						echo '<span style="color: #40FF00">' . $ll->getMessage("successcommandsendconsole") . '</span>';
						}
					}	
						
					?>	</p>
                </section>
            </div>
			<div class="6u 12u$(medium)">
                <section id="2" class="box">
                    <h3><?= $ll->getMessage("consoleclear") ?></h3>
                    <p><?= $ll->getMessage("consoleclearinfo") ?></p>
					<p><a href="tech/clearconsole.php" class="button"><?= $ll->getMessage("consoleclear") ?></a></p>
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "consoleclear") { 
						echo '<span style="color: #40FF00">' . $ll->getMessage("successconsoleclear") . '</span>';
						}
					}	
						
					?>	</p>
                </section>
            </div>
        </div>
    </div>
</section>




