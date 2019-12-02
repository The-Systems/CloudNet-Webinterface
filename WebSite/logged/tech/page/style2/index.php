<!DOCTYPE HTML>

<?php
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

}?> 


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
		
			<li><a href="index.php"><?= $ll->getMessage("startpage") ?></a></li>
			<li><a href="index.php?set=server"><?= $ll->getMessage("serverpage") ?></a></li>
			<li><a href="index.php?set=proxy"><?= $ll->getMessage("proxypage") ?></a></li>
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
<section class="wrapper style<?php echo $style; ?> special">
    <header class="major">
        <h2><?php echo $servername; ?></h2>
    </header>	
    <div class="container">
        <div class="row">
            <div class="4u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("welcome1") ?> <?php echo $email; ?></h3>
					<h4><?= $ll->getMessage("welcome2") ?></h4>
					<p><img src="https://minotar.net/cube/<?php echo $email;?>/120" class="img-responsive"></p>
					<p><a href="<?php echo $domain; ?>/logout.php" class="button"><?= $ll->getMessage("logout") ?></a></p>
                </section>
			</div>
            <div class="4u 12u$(medium)">	
				<section class="box">
<h2>
<?php

$null = "0";
$one = "1";
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:networkinfo\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$online = $json->response->onlineCount;
$maxonline = $json->response->maxPlayers;

if ($json->response->onlineCount == 0){
	echo $ll->getMessage("noplayeronline");
} else {
	if ($json->response->onlineCount == 1){
		echo strtr($ll->getMessage("oneplayeronline"), ["@online" => $online, "@maxonline" => $maxonline]);
	} else {
		echo strtr($ll->getMessage("playeronline"), ["@online" => $online, "@maxonline" => $maxonline]);
	}
} 


?></h2>
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.setgroup\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
	?>
<h3><?= $ll->getMessage("setplayergroup") ?></h3>
<?php 
$null = "0";
	if ($online == $null) { 
		echo $ll->getMessage("notuseronlinetosetgroup");
	} else {?>
					
				<form action="<?php echo $domain; ?>/logged/tech/setpermgroup.php" method="get">	
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:onlineplayers\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$playersonline = $json->response;	
?>					
					<p><?= $ll->getMessage("player") ?> <select name="spieler"></p>
					<!-- Alle gruppen auflisten -->
                            <?php foreach ($playersonline as $element):?>
                                <option value="<?php echo $element->name; ?>"><span style="color: #40FF00"><?php echo $element->name; ?></span></option>
                            <?php endforeach; ?>
									
      
					</select>
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permissiongroups\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$permgroups = $json->response;	
?>	
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>	
			
					<p><?= $ll->getMessage("group") ?> <select name="gruppe"></p>
					<!-- Alle gruppen auflisten -->
                            <?php foreach ($permgroups as $element):?>
                                <option value="<?php echo $element->name; ?>"><span style="color: #40FF00"><?php echo $element->name; ?></span></option>
                            <?php endforeach; ?>
									
      
					</select>
					<p></p>
					<input type="submit" value="Gruppe setzen" />
				</form>	
				<?php
	}			
}
?>
                </section>
				
			</div>
			<div class="4u 12u$(medium)">
                <section class="box">
                    <h3>CloudNet - Webinterface</h3>
					<h4><?= $ll->getMessage("version") ?> <?php echo $version;?> <?= $ll->getMessage("from") ?></h4>
					
				<?php
				
  $options = array('http'=>array('method'=>"GET",'header'=>"-Xversion:aktuelleversion\r\n"));
  $context = stream_context_create($options);
  $jsonlol = file_get_contents($versioncheck, false, $context);
  $json = json_decode($jsonlol);
  $newversion = $json->response->version;
  $devversion = $json->response->devversion;
  $oldversion = $json->response->oldversion;
  
  
			if (in_array($version, $oldversion)) {?>
				<h4><?= $ll->getMessage("versionold") ?> <?= $ll->getMessage("newtestversion") ?>: <?php echo $newversion;?></h4> <?php
			} else {
				if ($version == $devversion) { ?>
					<h4><?= $ll->getMessage("versiondev") ?></h4> <?php
				} else {
					if ($version == $newversion) { ?>
						<h4><?= $ll->getMessage("versionnewtest") ?></h4> <?php
					} else { ?>
						<h4><?= $ll->getMessage("versionerror") ?></h4> <?php
						}
				}	
			}
		
  ?>
					<p></p>
					<p><a href="https://discord.gg/CYHuDpx" class="button"><?= $ll->getMessage("supportdiscord") ?></a></p>
					<p><a href="https://www.spigotmc.org/resources/cloudnet-webinterface.58905/" class="button"><?= $ll->getMessage("spigotpage") ?></a></p>
					
					<?php
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
					</section>
				</div>
				<div class="container">
					<div class="row 150%">
						<div class="4u 12u$(medium)">
							<section class="box">
								<i class="icon big rounded color1 fa-cloud"></i>
								<?php
								$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
								$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:cpucores\r\n"."-Xvalue:\r\n"));
								$context = stream_context_create($options);
								$jsonlol = file_get_contents($url, false, $context);
								$json = json_decode($jsonlol);
								?>
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>
								<h3><?= $ll->getMessage("cpu") ?></h3>
								<h1><?= $ll->getMessage("all") ?>: <?php echo $json->response; ?></h1>
							</section>
						</div>
						<div class="4u 12u$(medium)">
							<section class="box">
								<i class="icon big rounded color1 fa-desktop"></i>

								<?php
								$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
								$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:wrappers\r\n"."-Xvalue:\r\n"));
								$context = stream_context_create($options);
								$jsonlol = file_get_contents($url, false, $context);
								$json = json_decode($jsonlol);
								?>
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>
								<h3><?= $ll->getMessage("wrapper") ?></h3>
								<h1><?= $ll->getMessage("connect") ?>: <?php echo $json->response->connected; ?></h1>
								<h1><?= $ll->getMessage("notconnect") ?>: <?php echo $json->response->notConnected; ?></h1>
							</section>
						</div>
						<div class="4u$ 12u$(medium)">
							<section class="box">
								<i class="icon big rounded color1 fa-hdd-o"></i>
								<?php
								$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
								$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:networkmemory\r\n"."-Xvalue:\r\n"));
								$context = stream_context_create($options);
								$jsonlol = file_get_contents($url, false, $context);
								$json = json_decode($jsonlol);
								$usedmemory = $json->response->usedMemory;
								$maxmemory = $json->response->maxMemory;
								?>
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>
								<h3><?= $ll->getMessage("ram") ?></h3>
								<h1><?php echo strtr($ll->getMessage("mbused"), ["@used" => $usedmemory, "@max" => $maxmemory]); ?></h1>
							</section>
						</div>
						<?php
						$true = "true";
							if ($urlshortenabled == $true) {
						?>
						<div class="4u 12u$(medium)">
							<section class="box">
								<i class="icon big rounded color1 fa-clipboard"></i>
								<h3><?= $ll->getMessage("urlshorting") ?></h3>
								
								<form action="<?php echo $domain; ?>/logged/tech/shorturl.php" method="get">
									<p><?= $ll->getMessage("url") ?>: <input type="text" name="shorturl" class="form-control" placeholder="<?= $ll->getMessage("url") ?>" required /></p>
									<p></p>
									<input type="submit" value="<?= $ll->getMessage("urlshorting") ?>" />
								</form>	
							<p></p>
								<?php
									if(isset($_GET["erfolg"])) {
										if($_GET["erfolg"] == "urlshorted") { 
											?><?= $ll->getMessage("yourshortedurl") ?> <?php echo $_GET['shortedurl'];
										}
								}?>
							</section>
						</div>
						<?php 
						}
						?>
						<?php
							if ($hastenabled == $true) {
						?>
						<div class="4u$ 12u$(medium)">
							<section class="box">
								<i class="icon big rounded color1 fa-clipboard"></i>
								<h3><?= $ll->getMessage("hastefromconsole") ?></h3>
								<p>(<?= $ll->getMessage("ownrisk") ?>)</p>
								<p><a href="tech/createhaste.php" class="button"><?= $ll->getMessage("createhaste") ?></a></p>
							<p></p>
								<?php
									if(isset($_GET["erfolg"])) {
										if($_GET["erfolg"] == "hastecreated") { 
											?><?= $ll->getMessage("yourhastelink") ?> <?php echo $hasteurl;?>/<?php echo $_GET['hastekey'];
										}
								}?>
							</section>
						</div>
						<?php 
						}
						?>
						
					</div>
				</div>
			</section>
	</div>
</section>
<section class="wrapper style<?php echo $style; ?> special">
    <div class="container">
        <div class="row">
			<div class="8u 12u$(medium)" name="test">
                <section class="box">
				
				 <h3><?= $ll->getMessage("stats") ?></h3>
                    <p></p>
<?php
  $url = "http://". $ip . ":" . $webport . "/" . $dir. "";
  $options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:statistics\r\n"."-Xvalue:\r\n"));
  $context = stream_context_create($options);
  $jsonlol = file_get_contents($url, false, $context);
  $json = json_decode($jsonlol);
?>		
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>			
<h5><?= $ll->getMessage("statscloudstart") ?>:										
<?php 

if(strpos($jsonlol, 'cloudStartup') === false){
	echo $ll->getMessage("nostatsexits");
} else {
    echo $json->response->cloudStartup; ?></h5><?php
}?>


<h5><?= $ll->getMessage("statswrapperstart") ?>:
<?php
if(strpos($jsonlol, 'wrapperConnections') === false){
	echo $ll->getMessage("nostatsexits");
} else {
    echo $json->response->wrapperConnections; ?></h5><?php
}?>

<h5><?= $ll->getMessage("statsplayerlogin") ?>:		
<?php
if(strpos($jsonlol, 'playerLogin') === false){
	echo $ll->getMessage("nostatsexits");
} else {
    echo $json->response->playerLogin; ?></h5><?php
}?>

<h5><?= $ll->getMessage("statsplayermaxon") ?>:	
<?php
if(strpos($jsonlol, 'highestPlayerOnline') === false){
	echo $ll->getMessage("nostatsexits");
} else {
    echo $json->response->highestPlayerOnline; ?></h5><?php
}?>

<h5><?= $ll->getMessage("statssendcommands") ?>:	
<?php
if(strpos($jsonlol, 'playerCommandExecutions') === false){
	echo $ll->getMessage("nostatsexits");
} else {
    echo $json->response->playerCommandExecutions; ?></h5><?php
}?>

<h5><?= $ll->getMessage("statsstartserver") ?>:		
<?php
if(strpos($jsonlol, 'startedServers') === false){
	echo $ll->getMessage("nostatsexits");
} else {
    echo $json->response->startedServers; ?></h5><?php
}?>

<h5><?= $ll->getMessage("statsstartproxy") ?>:		
<?php
if(strpos($jsonlol, 'startedProxys') === false){
	echo $ll->getMessage("nostatsexits");
} else {
    echo $json->response->startedProxys; ?></h5><?php
}?>

<h5><?= $ll->getMessage("statsmaxonlineserver") ?>:	
<?php
if(strpos($jsonlol, 'highestServerOnlineCount') === false){
	echo $ll->getMessage("nostatsexits");
} else {
    echo $json->response->highestServerOnlineCount; ?></h5><?php
}?>


    <h5><?= $ll->getMessage("statsservergroups") ?>: <?php
	

$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:servergroups\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$servergroups = $json->response;

      $groupamount = 0;
      foreach ($servergroups as $element) {
          $groupamount++;
      }
      echo $groupamount;
      ?></h5>
	  
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:proxygroups\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$proxygroups = $json->response;
?>
    <h5><?= $ll->getMessage("statsproxygroups") ?>: <?php
      $groupamount = 0;
      foreach ($proxygroups as $element) {
          $groupamount++;
      }
      echo $groupamount;
      ?></h5>
	  
	  
	  
	  
                </section>
            </div>
			<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.createuser\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>
			<div class="4u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("createuser") ?></h3>
                    <p><?= $ll->getMessage("createuserinfo") ?></p>
				<form action="<?php echo $domain; ?>/logged/tech/createuser.php" method="post">
					<p><?= $ll->getMessage("createusername") ?>: <input type="text" name="user" class="form-control" placeholder="<?= $ll->getMessage("createusername") ?>" required /></p>
					<p><?= $ll->getMessage("createuserpassword") ?>: <input type="password" name="password" class="form-control" placeholder="<?= $ll->getMessage("createuserpassword") ?>" required /></p>
					<p></p>
					<input type="submit" value="<?= $ll->getMessage("createtheuser") ?>" />
				</form>	
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "createuser") { 
						echo '<span style="color: #40FF00">' . $ll->getMessage("successusercreated") . '</span>';
						}
					}	
						
					?>	</p>
                </section>
            </div>
			<?php
}
?>
					<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.deleteuser\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);

if ($json->response == true) {
?>
			<div class="4u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("deleteuser") ?></h3>
                    <p><?= $ll->getMessage("deleteuserinfo") ?></p>
				<form action="<?php echo $domain; ?>/logged/tech/deleteuser.php" method="post">
					<p><?= $ll->getMessage("createusername") ?>: <input type="text" name="user" class="form-control" placeholder="<?= $ll->getMessage("createusername") ?>" required /></p>
					<p></p>
					<input type="submit" value="<?= $ll->getMessage("deletetheuser") ?>" />
				</form>	
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "createuser") { 
						echo '<span style="color: #40FF00">' . $ll->getMessage("successusercreated") . '</span>';
						}
					}	
						
					?>	</p>
                </section>
            </div>
			<?php
}
?>	
		
					<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.changepw\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);

if ($json->response == true) {
?>
			<div class="4u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("changeuserpw") ?></h3>
                    <p><?= $ll->getMessage("changeuserpwinfo") ?></p>
				<form action="<?php echo $domain; ?>/logged/tech/userchangepw.php" method="post">
					<p><?= $ll->getMessage("createusername") ?>: <input type="text" name="user" class="form-control" placeholder="<?= $ll->getMessage("createusername") ?>" required /></p>
					<p><?= $ll->getMessage("createuserpassword") ?>: <input type="password" name="password" class="form-control" placeholder="<?= $ll->getMessage("createuserpassword") ?>" required /></p>
					<p></p>
					<input type="submit" value="<?= $ll->getMessage("changetheuserpw") ?>" />
				</form>	
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "createuser") { 
						echo '<span style="color: #40FF00">' . $ll->getMessage("successusercreated") . '</span>';
						}
					}	
						
					?>	</p>
                </section>
            </div>
			<?php
}
?>		
			
			<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.sendcommandtoconsole\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>
			<div class="6u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("sendcommandtoconsole") ?></h3>
                    <p><?= $ll->getMessage("sendcommandtoconsoleinfo") ?></p>
				<form action="<?php echo $domain; ?>/logged/tech/dispatchcommand.php" method="get">
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
			
			<?php
}
?>
			
			<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.sendcommandtoserver\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>
			<div class="6u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("sendcommandtoserver") ?></h3>
                    <p><?= $ll->getMessage("sendcommandtoserverinfo") ?></p>
				<form action="<?php echo $domain; ?>/logged/tech/sendcommandtoserver.php" method="get">
					<p><?= $ll->getMessage("sendcommandtoservername") ?>: <input type="text" name="server" class="form-control" placeholder="<?= $ll->getMessage("sendcommandtoservername") ?>" required /></p>
					<p><?= $ll->getMessage("command") ?>: <input type="text" name="command" class="form-control" placeholder="<?= $ll->getMessage("command") ?>" required /></p>
					<p></p>
					<input type="submit" value="Befehl senden" />
				</form>	
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "commandsendtoserver") { 
						echo '<span style="color: #40FF00">' . $ll->getMessage("successcommandsendserver") . '</span>';
						}
					}	
						
					?>	</p>
                </section>
            </div>
			
			<?php
}
?>
			
			<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.console\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>
			<div class="6u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("console") ?></h3>
                    <p><?= $ll->getMessage("consoleinfo") ?></p>
					<p></p>
					<p><a href ="<?php echo $domain; ?>/logged/console.php" class="button"><?= $ll->getMessage("openconsole") ?></a></p>
                </section>
            </div>
			
			<?php
}
?>
			
			<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.stopcloud\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>
			<div class="6u 12u$(medium)">
                <section class="box">
                   <h3><?= $ll->getMessage("stopcloud") ?></h3>
                    <p><?= $ll->getMessage("stopcloudinfo") ?></p>
					<p></p>
					<p><a href="<?php echo $domain; ?>/logged/tech/stopcloud.php" class="button"><?= $ll->getMessage("stopcloud") ?></a></p>
                </section>
            </div>
			
			<?php
}
?>
		</div>
	</div>
</section>
		
			<!-- -->	
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.onlineserver\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>	
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:servergroups\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$servergroups = $json->response;
?>	
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>
<section id="2" class="wrapper style<?php echo $style; ?>">
<header class="major">
        <h2><?= $ll->getMessage("onlineserver") ?></h2>
    </header>	
    <div class="container">
        <div class="row">
			<h3><?= $ll->getMessage("server") ?></h3>
			<p><a href="tech/infostopallserver.php" class="button"><?= $ll->getMessage("allstop") ?></a></p>
				<div class="table-scrollable">
					<table>
						<tr>
							<th><?= $ll->getMessage("group") ?></th>
							<th><?= $ll->getMessage("typ") ?></th>
							<th><?= $ll->getMessage("online") ?></th>
							<th><?= $ll->getMessage("server") ?></th>
							<th><?= $ll->getMessage("wrapper") ?></th>
							<th><?= $ll->getMessage("port") ?></th>
							<th><?= $ll->getMessage("player") ?></th>
							<th><?= $ll->getMessage("template") ?></th>
							<th><?= $ll->getMessage("state") ?></th>
							<th><?= $ll->getMessage("template") ?></th>
							<th><?= $ll->getMessage("ram") ?></th>
							<th><?= $ll->getMessage("stopserver") ?></th>
						</tr>	
			
					<!-- Alle gruppen auflisten -->
                            <?php foreach ($servergroups as $element):
							
								$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
								$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:serverinfos\r\n"."-Xvalue:".$element->name."\r\n"));
								$context = stream_context_create($options);
								$jsonlol = file_get_contents($url, false, $context);
								$json = json_decode($jsonlol);
								$serverinfos = $json->response;
								?>	
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>
									
									<tr>
										<td><?php echo $element->name; ?></td>
										<td><?php echo $element->groupMode; ?></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td><a href="tech/infostopgroup.php?server=<?php echo $element->name; ?>" class="button"><?= $ll->getMessage("stop") ?></a></td>
									</tr>
									<?php foreach ($serverinfos as $element): ?>
									<tr>
										<td></td>
										<td></td>
										<td><?php if ($element->online == true) { 
										?>
											<span style="font-size: 25px; color: #40FF00;">
												<i class="fa fa-check"></i>
											</span>
										<?php	
										} else { ?>
											<span style="font-size: 25px; color: #FF0000;">
												<i class="fa fa-times"></i>
											</span>
											<?php
										}
										?></td>
										<td><?php echo $element->serviceId->serverId; ?></td>
										<td><?php echo $element->serviceId->wrapperId; ?></td>
										<td><?php echo $element->port; ?></td>
										<td><?php echo $element->onlineCount; ?> / <?php echo $element->maxPlayers; ?>   </td>
										<td><?php echo $element->template->name; ?></td>
										<td><?php echo $element->serverState; ?></td>
										<td><?php echo $element->motd; ?></td>
										<td><?php echo $element->memory ?>mb</td>
										<td><a href="tech/infostopserver.php?server=<?php echo $element->serviceId->serverId; ?>" class="button"><?= $ll->getMessage("stop") ?></a></td>
									</tr>
									<?php endforeach; ?>
								<?php endforeach; ?>			
					</table>
				</div>
					

<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:proxygroups\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$proxygroups = $json->response;
?>	
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>
										
			<h3><?= $ll->getMessage("proxy") ?></h3>
			<p><a href="tech/infostopallproxy.php" class="button"><?= $ll->getMessage("allstop") ?></a></p>
				<div class="table-scrollable">
					<table>
						<tr>
							<th><?= $ll->getMessage("group") ?></th>
							<th><?= $ll->getMessage("typ") ?></th>
							<th><?= $ll->getMessage("online") ?></th>
							<th><?= $ll->getMessage("server") ?></th>
							<th><?= $ll->getMessage("wrapper") ?></th>
							<th><?= $ll->getMessage("port") ?></th>
							<th><?= $ll->getMessage("player") ?></th>
							<th><?= $ll->getMessage("ram") ?></th>
							<th><?= $ll->getMessage("stopproxy") ?></th>
						</tr>	
			
					<!-- Alle gruppen auflisten -->
                            <?php foreach ($proxygroups as $element):
							
								$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
								$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:proxyinfos\r\n"."-Xvalue:".$element->name."\r\n"));
								$context = stream_context_create($options);
								$jsonlol = file_get_contents($url, false, $context);
								$json = json_decode($jsonlol);
								$proxyinfos = $json->response;
								?>
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>
									
									<tr>
										<td><?php echo $element->name; ?></td>
										<td><?php echo $element->proxyGroupMode; ?></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td><a href="tech/infostopgroup.php?server=<?php echo $element->name; ?>" class="button"><?= $ll->getMessage("stop") ?></a></td>
									</tr>
									<?php foreach ($proxyinfos as $element): ?>
									<tr>
										<td></td>
										<td></td>
										<td><?php if ($element->online == true) { 
										?>
											<span style="font-size: 25px; color: #40FF00;">
												<i class="fa fa-check"></i>
											</span>
										<?php	
										} else { ?>
											<span style="font-size: 25px; color: #FF0000;">
												<i class="fa fa-times"></i>
											</span>
											<?php
										}
										?></td>
										<td><?php echo $element->serviceId->serverId; ?></td>
										<td><?php echo $element->serviceId->wrapperId; ?></td>
										<td><?php echo $element->port; ?></td>
										<td><?php echo $element->onlineCount; ?></td>
										<td><?php echo $element->memory ?>mb</td>
										<td><a href="tech/infostopproxy.php?server=<?php echo $element->serviceId->serverId; ?>" class="button"><?= $ll->getMessage("stop") ?></a></td>
									</tr>
									<?php endforeach; ?>
								<?php endforeach; ?>			
					</table>
				</div>
				<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:wrapper\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$wrapper = $json->response;
?>	
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>
										
			<h3><?= $ll->getMessage("wrapper") ?></h3>
			<p><a href="tech/infostopallwrapper.php" class="button"><?= $ll->getMessage("allstop") ?></a></p>
				<div class="table-scrollable">
					<table>
						<tr>
							<th><?= $ll->getMessage("wrapper") ?></th>
							<th><?= $ll->getMessage("ip") ?></th>
							<th><?= $ll->getMessage("startport") ?></th>
							<th><?= $ll->getMessage("ram") ?></th>
							<th><?= $ll->getMessage("cpucores") ?></th>
							<th><?= $ll->getMessage("cpuload") ?></th>
							<th><?= $ll->getMessage("queuesize") ?></th>
							<th><?= $ll->getMessage("stopwrapper") ?></th>
						</tr>	
			
					<!-- Alle gruppen auflisten --><?php
							
								$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
								$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:wrapperinfos\r\n"."-Xvalue:".$element->id."\r\n"));
								$context = stream_context_create($options);
								$jsonlol = file_get_contents($url, false, $context);
								$json = json_decode($jsonlol);
								$wrapperinfos = $json->response;
								?>
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>
									<?php foreach ($wrapperinfos as $element): ?>
									<tr>
										<td><?php echo $element->serverId; ?></td>
										<td><?php echo $element->hostName; ?></td>
										<td><?php echo $element->startPort; ?></td>
										<td><?php echo $element->usedMemory; ?>mb / <?php echo $element->memory; ?>mb</td>
										<td><?php echo $element->availableProcessors; ?></td>
										<td><?php echo $element->cpuUsage; ?></td>
										<td><?php echo $element->process_queue_size; ?></td>
										<td><a href="tech/infostopwrapper.php?server=<?php echo $element->serverId; ?>" class="button"><?= $ll->getMessage("stop") ?></a></td>
									</tr>
									<?php endforeach; ?>		
					</table>
				</div>
		</div>
	</div>	
</section>
	
	
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>	
										
<?php
}
?>
</body>
</html>
