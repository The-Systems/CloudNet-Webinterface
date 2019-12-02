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
<section id="1" class="wrapper style<?php echo $style; ?>">
    <div class="container">
        <div class="row">
			<!-- -->
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.creategroup\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>
			<!-- -->
			<div class="4u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("createproxygroup") ?></h3>
                    <p><?= $ll->getMessage("createproxygroupinfo") ?></p>
				<form action="<?php echo $domain; ?>/logged/tech/createproxy.php" method="get">
					<p><?= $ll->getMessage("creategroupname") ?>: <input type="text" name="groupname" class="form-control" placeholder="<?= $ll->getMessage("creategroupname") ?>" required /></p>
					<p><?= $ll->getMessage("creategroupram") ?>: <input type="text" name="memory" class="form-control" placeholder="<?= $ll->getMessage("creategroupram") ?>" required /></p>
					<p><?= $ll->getMessage("creategroupstartport") ?>: <input type="text" name="startport" class="form-control" placeholder="<?= $ll->getMessage("creategroupstartport") ?>" required /></p>
					<p><?= $ll->getMessage("creategroupalwaysonline") ?>: <input type="text" name="minonline" class="form-control" placeholder="<?= $ll->getMessage("creategroupalwaysonline") ?>" required /></p>
					<p><?= $ll->getMessage("creategroupmode") ?>: <select name="groupmode"></p>
                                <option value="DYNAMIC">Dynamic</span></option>
                                <option value="STATIC">Static</span></option>
					</select>
					<p><?= $ll->getMessage("creategrouptemplateplace") ?>: <select name="speicherort"></p>
                                <option value="LOCAL">Local</span></option>
                                <option value="MASTER">Master</span></option>
					</select>
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
					<p><?= $ll->getMessage("wrapper") ?>: <select name="wrapper"></p>
					<!-- Alle gruppen auflisten -->
                            <?php foreach ($wrapper as $element):?>
                                <option value="<?php echo $element->id; ?>"><?php echo $element->id; ?></option>
                            <?php endforeach; ?>
									
      
					</select>					
					<p></p>
					<input type="submit" value="Gruppe erstellen" />
				</form>		
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "serverstart") { 
						echo '<span style="color: #40FF00">' . $ll->getMessage("successcreategroup") . '</span>';
						}
					}	
						
					?>	</p>

                </section>
            </div>
<?php } ?>
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.startserver\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>
			<div class="4u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("startproxy") ?></h3>
                    <p><?= $ll->getMessage("startproxyinfo") ?></p>
				<form action="<?php echo $domain; ?>/logged/tech/startproxy.php" method="get">
					<p><?= $ll->getMessage("many") ?>: <input type="text" name="anzahl" class="form-control" placeholder="<?= $ll->getMessage("many") ?>" required /></p>
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:cloudnetwork\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$proxygroups = $json->response->proxyGroups;	
?>	
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>	
			
					<p><?= $ll->getMessage("group") ?> <select name="gruppe"></p>
					<!-- Alle gruppen auflisten -->
                            <?php foreach ($proxygroups as $element):?>
                                <option value="<?php echo $element->name; ?>"><span style="color: #40FF00"><?php echo $element->name; ?></span></option>
                            <?php endforeach; ?>
									
      
					</select>
					<p></p>
					<input type="submit" value="Proxy starten" />
				</form>	
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "proxystart") { 
						echo '<span style="color: #40FF00"> ' . $ll->getMessage("successproxystart") . '</span>';
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
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.editproxy\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>
			<div class="4u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("changeproxy") ?></h3>
                    <p><?= $ll->getMessage("changeproxyinfo") ?></p>
					
					<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:proxygroups\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$proxygroups = $json->response;
?>
    <?php
      $groupamount = 0;
      foreach ($proxygroups as $element) {
          $groupamount++;
      }
	  
		if($groupamount == 1) { 
	  ?>
				<form action="<?php echo $domain; ?>/logged/setting.php" method="post">
					
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:cloudnetwork\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$proxygroups = $json->response->proxyGroups;	
?>		
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>		
					<p><?= $ll->getMessage("group") ?> <select name="proxy"></p>
					<!-- Alle gruppen auflisten -->
                            <?php foreach ($proxygroups as $element):?>
                                <option value="<?php echo $element->name; ?>"><span style="color: #40FF00"><?php echo $element->name; ?></span></option>
                            <?php endforeach; ?>
									
      
					</select>
					<p></p>
					<input type="submit" value="<?= $ll->getMessage("changesettings") ?>" />
				</form>	
		<?php } else {
			echo $ll->getMessage("noproxygroupsexits");
		} ?>
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "serverstart") { 
						echo '<span style="color: #40FF00">' . $ll->getMessage("successsettingsave") . '</span>';
						}
					}	
						
					?>	</p>

                </section>
            </div>
			<?php } ?>
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.deletegroup\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>
			<div class="4u 12u$(medium)">
                <section class="box">
                    <h3><?= $ll->getMessage("deleteproxygroup") ?></h3>
                    <p><?= $ll->getMessage("deleteproxygroup") ?></p>
				<form action="<?php echo $domain; ?>/logged/tech/deleteproxygroup.php" method="get">
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:cloudnetwork\r\n"."-Xvalue:\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
$servergroups = $json->response->proxyGroups;	
?>	
								<?php if($debug == 1) { 
										echo $jsonlol;
										} ?>			
					<p><?= $ll->getMessage("group") ?>: <select name="gruppe"></p>
					<!-- Alle gruppen auflisten -->
                            <?php foreach ($proxygroups as $element):?>
                                <option value="<?php echo $element->name; ?>"><span style="color: #40FF00"><?php echo $element->name; ?></span></option>
                            <?php endforeach; ?>
									
      
					</select>
					<p></p>
					<input type="submit" value="<?= $ll->getMessage("deletegroup") ?>" />
				</form>	
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "deleteproxygroup") { 
						echo '<span style="color: #40FF00">' . $ll->getMessage("successgroupdelete") . '</span>';
						}
					}	
						
					?>	</p>

                </section>
            </div>		
<?php } ?>
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.stopserver\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>	
			<div class="4u 12u$(medium)">
                <section id="2" class="box">
                    <h3><?= $ll->getMessage("stopproxy") ?></h3>
                    <p><?= $ll->getMessage("stopproxyinfo") ?></p>
				<form action="<?php echo $domain; ?>/logged/tech/stopproxy.php" method="get">
					<p><?= $ll->getMessage("proxy") ?>: <input type="text" name="gruppe" class="form-control" placeholder="<?= $ll->getMessage("proxy") ?>" required /></p>	
					<p></p>
					<input type="submit" value="<?= $ll->getMessage("stopproxy") ?>" />
				</form>	
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "stopproxy") { 
						echo '<span style="color: #40FF00"> ' . $ll->getMessage("successproxystop") . '</span>';
						}
					}	
						
					?>	</p>

                </section>
            </div>	
<?php } ?>
<?php
$url = "http://". $ip . ":" . $webport . "/" . $dir. "";
$options = array('http'=>array('method'=>"GET",'header'=>"-Xcloudnet-user:".$cloudnetuser."\r\n"."-Xcloudnet-token:".$cloudnettoken."\r\n"."-Xmessage:permission\r\n"."-Xvalue:".$email."\r\n"."-Xextras:web.stopserver\r\n"));
$context = stream_context_create($options);
$jsonlol = file_get_contents($url, false, $context);
$json = json_decode($jsonlol);
if ($json->response == true) {
?>	
			<div class="4u 12u$(medium)">
                <section id="2" class="box">
                    <h3><?= $ll->getMessage("stopallproxy") ?></h3>
                    <p><?= $ll->getMessage("stopallproxyinfo") ?></p>
					<p><a href="tech/stopallproxy.php" class="button"><?= $ll->getMessage("stopallproxy") ?></a></p>
						<p><?php
					if(isset($_GET["erfolg"])) {
						if($_GET["erfolg"] == "stopallproxy") { 
						echo '<span style="color: #40FF00"> ' . $ll->getMessage("successallproxystop") . '</span>';
						}
					}	
						
					?>	</p>

                </section>
            </div>	
<?php } ?>
		</div>
	</div>
</section>	