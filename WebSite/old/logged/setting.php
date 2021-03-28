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
			<div class="6u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("settingmotd") ?></h3>
<?php
$bungee = $_POST['proxy'];
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:proxygroup\r\n"."-Xvalue:".$bungee."\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$motd = $json->response->proxyConfig->motdsLayouts;
$motdmaintenance = $json->response->proxyConfig->maintenanceMotdLayout;
$maxplayer = $json->response->proxyConfig->maxPlayers;
$bungeeversion = $json->response->proxyVersion;
$tablist = $json->response->proxyConfig->tabList;
?>	
					
				<form action="<?php echo $domain; ?>/logged/tech/editbungeemotd.php" method="get">  
				
							
				<?php $i = 1; ?>
							<?php foreach ($motd as $element):?>
								<p><?= $ll->getMessage("settingmotdfirstline") ?>: <input type="text" value="<?php echo $element->firstLine; ?>" name="firstline<?php echo $i++?>" class="form-control" placeholder="<?= $ll->getMessage("settingmotdfirstline") ?>" required /></p>
								<p><?= $ll->getMessage("settingmotdsecondline") ?>: <input type="text" value="<?php echo $element->secondLine; ?>" name="secondline<?php echo $i++?>" class="form-control" placeholder="<?= $ll->getMessage("settingmotdsecondline") ?>" required /></p>
                            <?php endforeach; ?>
				
					<p></p>
					<input type="submit" value="Speichern" />
				</form>
			</div>
<div class="6u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("settingmaintenancemotd") ?></h3>
					
<form action="<?php echo $domain; ?>/logged/tech/editbungeemaintenancemotd.php" method="get">                            

								<p><?= $ll->getMessage("settingmotdfirstline") ?>: <input type="text" value="<?php echo $motdmaintenance->firstLine; ?>" name="firstline" class="form-control" placeholder="<?= $ll->getMessage("settingmotdfirstline") ?>" required /></p>
								<p><?= $ll->getMessage("settingmotdsecondline") ?>: <input type="text" value="<?php echo $motdmaintenance->secondLine; ?>" name="secondline" class="form-control" placeholder="<?= $ll->getMessage("settingmotdsecondline") ?>" required /></p>
				
					<p></p>
					<input type="submit" value="Speichern" />
				</form>
			</div>				
			<div class="4u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("settingmaxplayerchange") ?></h3>
					
<form action="<?php echo $domain; ?>/logged/tech/editbungeemaxplayer.php" method="get">                            
				

					<p><?= $ll->getMessage("settingmaxplayer") ?>: <input type="text" value="<?php echo $maxplayer; ?>" name="maxplayer" class="form-control" placeholder="Maximale Spieler: " required /></p>
				
					<p></p>
					<input type="submit" value="Speichern" />
				</form>
			</div>		
			<div class="4u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("settingbungeeversionchange") ?></h3>
					
				<form action="<?php echo $domain; ?>/logged/tech/editbungeeversion.php" method="get">                            
				
					
					<p><?= $ll->getMessage("settingbungeeversion") ?>: <select name="version"></p>
                                <option value="<?php echo $bungeeversion; ?>"><?= $ll->getMessage("settingbungeeversionnochange") ?> (<?php echo $bungeeversion; ?>)</span></option>
                                <option value="BUNGEECORD">Bungeecord</option>
                                <option value="HEXACORD">Hexacord</option>
                                <option value="WATERFALL">Waterfall</option>
					</select>
				
					<p></p>
					<input type="submit" value="Speichern" />
				</form>
			</div>	
			<div class="10u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("settingtablist") ?></h3>
					
<form action="<?php echo $domain; ?>/logged/tech/editbungeetablist.php" method="get">                            
				
								<p><?= $ll->getMessage("settingtablistfirstline") ?>: <input type="text" value="<?php echo $tablist->header; ?>" name="firstline" class="form-control" placeholder="<?= $ll->getMessage("settingtablistfirstline") ?>" required /></p>
								<p><?= $ll->getMessage("settingtablistsecondline") ?>: <input type="text" value="<?php echo $tablist->footer; ?>" name="secondline" class="form-control" placeholder="<?= $ll->getMessage("settingtablistsecondline") ?>" required /></p>
				
					<p></p>
					<input type="submit" value="Speichern" />
				</form>
			</div>					
        </div>
    </div>
</section>




