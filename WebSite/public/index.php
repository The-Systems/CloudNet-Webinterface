<?php
use cloudnet2_webinterface\main;

session_start();

define('DS', DIRECTORY_SEPARATOR, true);
define('BASE_PATH', __DIR__ . DS, TRUE);


$path_vendor = __DIR__ . '/../vendor/autoload.php';
$path_config = BASE_PATH . '../config/config.php';
$path_version = BASE_PATH . '../config/version.php';
$path_message = BASE_PATH . '../config/message.json';

if (file_exists($path_vendor)) {
    require $path_vendor;
} else {
    echo '<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Datei "/vendor/autoload.php" konnte nicht gefunden werden.</h3><h3>Führe im Webseiten-Root "composer install" aus!</h3>';
    die();
}

if (file_exists($path_config)) {
    require $path_config;
} else {
    die('<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Datei "/config/config.php" konnte nicht gefunden werden.</h3><h3>Führe das Setup mit "wisetup" im Master erneut aus!</h3>');
}

if (file_exists($path_version)) {
    require $path_version;
} else {
    die('<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Datei "/config/version.php" konnte nicht gefunden werden</h3><h3>Führe das Setup mit "wisetup" im Master erneut aus!</h3>');
}

if (!file_exists($path_message)) {
    die('<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Datei "/config/message.json" konnte nicht gefunden werden</h3><h3>Führe das Setup mit "wisetup" im Master erneut aus!</h3>');
}

$main = new main($config, $version);

$json = $main->sendRequest("testonline");
if ($json->success != true) {
    die('<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Cloud ist nicht erreichbar.</h3><h3>Überprüfe die Einstellungen in "/config/config.php"!</h3>');
}


$app = System\App::instance();
$app->request = System\Request::instance();
$app->route = System\Route::instance($app->request);

$route = $app->route;


$route->group('/', function () use ($main) {
    $this->any('/', function () use ($main) {
        if (isset($_SESSION['cn_webinterface-logged'])) {
            header('Location:' . $main->getconfig("domainurl") . '/logged');
            die();
        }
        if (isset($_POST['action'])) {
            $_POST['action'] == "login" ? include "../sites/login.php" : false;
        }
        include "../sites/header.php";
        include "../sites/index.php";
        include "../sites/footer.php";
    });
    $this->any('/logout', function () use ($main) {
        unset($_SESSION['cn_webinterface-name']);
        unset($_SESSION['cn_webinterface-logged']);
        header('Location:' . $main->getconfig("domainurl") . '/');
    });
    $this->group('/logged', function () use ($main) {
        $this->any('/', function () use ($main) {
            if (!isset($_SESSION['cn_webinterface-logged'])) {
                header('Location:' . $main->getconfig("domainurl"));
                die();
            }
            if (isset($_POST['action'])) {
                $_POST['action'] == "createuser" ? $main->sendRequest("dispatchcloudcommand", "create USER " . $_POST['user'] . " " . $_POST['password']) : false;
                $_POST['action'] == "setpermgroup" ? $main->sendRequest("dispatchcloudcommand+", "perms user " . $_POST['player'] . " group set " . $_POST['group'] . " lifetime") : false;
                $_POST['action'] == "deleteuser" ? $main->sendRequest("deleteuser", $_POST['user']) : false;
                $_POST['action'] == "dispatchcommand" ? $main->sendRequest("dispatchcloudcommand", $_POST['command']) : false;
                $_POST['action'] == "sendcommandtoserver" ? $main->sendRequest("dispatchcloudcommand", "cmd " . $_POST['server'] . " " . $_POST['command']) : false;

                $_POST['action'] == "stopcloud" ? $main->sendRequest("shutdownwrappers", "stop") : false;
                $_POST['action'] == "stopcloud" ? $main->sendRequest("dispatchcloudcommand", "stop") : false;

                $_POST['action'] == "infostopallserver" ? $main->sendRequest("shutdownservers") : false;
                $_POST['action'] == "infostopallproxy" ? $main->sendRequest("shutdownproxys") : false;
                $_POST['action'] == "infostopallwrapper" ? $main->sendRequest("shutdownwrappers") : false;


                $_POST['action'] == "infostopserver" ? $main->sendRequest("stopserver", $_POST['id']) : false;
                $_POST['action'] == "infostopproxy" ? $main->sendRequest("stopproxy", $_POST['id']) : false;
                $_POST['action'] == "infostopwrapper" ? $main->sendRequest("shutdownwrapper", $_POST['id']) : false;
                $_POST['action'] == "infostopgroup" ? $main->sendRequest("dispatchcloudcommand", "shutdown GROUP " . $_POST['id']) : false;

                header('Location:' . $main->getconfig("domainurl") . '/logged?action=' . $_POST['action']);
                die();
            }

            include "../sites/header.php";
            include "../sites/logged/index.php";
            include "../sites/footer.php";
        });
        $this->any('/console', function () use ($main) {
            if (!isset($_SESSION['cn_webinterface-logged'])) {
                header('Location:' . $main->getconfig("domainurl"));
                die();
            }
            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.console");
            if ($json->response != true) {
                header('Location:' . $main->getconfig("domainurl") . '/logged');
            }
            if (isset($_POST['action'])) {
                $_POST['action'] == "dispatchcommand" ? $main->sendRequest("dispatchcloudcommand", $_POST['command']) : false;

                header('Location:' . $main->getconfig("domainurl") . '/logged/console?action=' . $_POST['action']);
                die();
            }
            include "../sites/header.php";
            include "../sites/logged/console.php";
            include "../sites/footer.php";
        });
        $this->group('/proxy', function () use ($main) {
            $this->any('/', function () use ($main) {
                if (!isset($_SESSION['cn_webinterface-logged'])) {
                    header('Location:' . $main->getconfig("domainurl"));
                    die();
                }
                if (isset($_POST['action'])) {
                    if ($_POST['action'] == "createproxy") {
                        $wrapper = $_POST['wrapper'];
                        $groupname = $_POST['groupname'];
                        $groupmode = $_POST['groupmode'];
                        $speicherort = $_POST['speicherort'];
                        $memory = $_POST['memory'];
                        $minonline = $_POST['minonline'];
                        $startport = $_POST['startport'];

                        $string = '{"name": "' . $groupname . '","wrapper": ["' . $wrapper . '"],"template": {"name": "default","backend": "' . $speicherort . '","url": null,"processPreParameters": [],"installablePlugins": []},"proxyVersion": "BUNGEECORD","startPort": ' . $startport . ',"startup": ' . $minonline . ',"memory": ' . $memory . ',"proxyConfig": {"enabled": true,"maintenance": false,"motdsLayouts": [{"firstLine": "   §b§lCloud§f§lNet§8■ §7your §bfree §7cloudsystem §8§l【§f%version%§8§l】","secondLine": "         §aOnline §8» §7We are now §aavailable §7for §ball"}],"maintenanceMotdLayout": {"firstLine": "   §b§lCloud§f§lNet§8■ §7your §bfree §7cloudsystem §8§l【§f%version%§8§l】","secondLine": "         §bMaintenance §8» §7We are still in §bmaintenance"},"maintenaceProtocol": "§8➜ §bMaintenance §8§l【§c✘§8§l】","maxPlayers": 1000,"fastConnect": false,"customPayloadFixer": true,"autoSlot": {"dynamicSlotSize": 0,"enabled": false},"tabList": {"enabled": true,"header": " \n§b§lCloud§f§lNet §8× §7your §bfree §7cloudsystem §8➜ §f%online_players%§8/§f%max_players%§f\n §8► §7Current server §8● §b%server% §8◄ \n ","footer": " \n §7Twitter §8» §f@Dytanic §8▎ §7Discord §8» §fdiscord.gg/UNQ4wET \n §7powered by §8» §b§b§lCloud§f§lNet \n "},"playerInfo": [" ","§b§lCloud§f§lNet §8× §7your §bfree §7cloudsystem","§7Twitter §8» §f@CloudNetService","§7Discord §8» §fdiscord.gg/UNQ4wET"," "],"whitelist": [],"dynamicFallback": {"defaultFallback": "Lobby","fallbacks": [{"group": "Lobby","permission": null}]}},"proxyGroupMode": "' . $groupmode . '","settings": {}}';
                        $string1 = '{"group": ' . $string . '}';

                        $main->sendRequest("updateproxygroup", $string1);
                    }

                    $_POST['action'] == "startproxy" ? $main->sendRequest_amount("startproxy", $_POST['group'], $_POST['count']) : false;
                    $_POST['action'] == "deleteproxygroup" ? $main->sendRequest("dispatchcloudcommand", "shutdown GROUP " . $_POST['group']) : false;
                    $_POST['action'] == "deleteproxygroup" ? $main->sendRequest("deleteproxygroup", $_POST['group']) : false;
                    $_POST['action'] == "stopproxy" ? $main->sendRequest("stopproxy", $_POST['group']) : false;
                    $_POST['action'] == "shutdownproxys" ? $main->sendRequest("shutdownproxys") : false;


                    header('Location:' . $main->getconfig("domainurl") . '/logged/proxy?action=' . $_POST['action']);
                    die();
                }


                include "../sites/header.php";
                include "../sites/logged/proxy.php";
                include "../sites/footer.php";
            });
            $this->any('/setting', function () use ($main) {
                if (!isset($_SESSION['cn_webinterface-logged'])) {
                    header('Location:' . $main->getconfig("domainurl"));
                    die();
                }
                $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.editproxy");
                if ($json->response != true) {
                    header('Location:' . $main->getconfig("domainurl") . '/logged/proxy');
                }
                if (!isset($_GET['bungee'])) {
                    header('Location:' . $main->getconfig("domainurl") . '/logged/proxy');
                }

                if (isset($_POST['action'])) {

                    if ($_POST['action'] == "editbungeemotd") {
                        $json = $main->sendRequest("proxygroup", $_GET['bungee'])->response;

                        $count = 0;
                        $motd = array();
                        foreach ($_POST['firstline'] as $element) {
                            $firstline = $_POST['firstline'][$count];
                            $secondline = $_POST['secondline'][$count];
                            if ($firstline != "" and $secondline != "") {
                                array_push($motd, array("firstLine" => $firstline, "secondLine" => $secondline));
                            }
                            $count++;
                            if ($count == count($_POST['firstline'])) {
                                break;
                            }
                        }

                        $json->proxyConfig->motdsLayouts = $motd;

                        $string = array("group" => $json);
                        $string = json_encode($string);
                        $main->sendRequest("updateproxygroup", $string);
                    }
                    if ($_POST['action'] == "editbungeemaintenancemotd") {
                        $json = $main->sendRequest("proxygroup", $_GET['bungee'])->response;

                        $firstline = $_POST['firstline'];
                        $secondline = $_POST['secondline'];

                        $json->proxyConfig->maintenanceMotdLayout->firstLine = $firstline;
                        $json->proxyConfig->maintenanceMotdLayout->secondLine = $secondline;

                        $string = array("group" => $json);
                        $string = json_encode($string);
                        $main->sendRequest("updateproxygroup", $string);
                    }
                    if ($_POST['action'] == "editbungeemaxplayer") {
                        $json = $main->sendRequest("proxygroup", $_GET['bungee'])->response;

                        $maxplayer = $_POST['maxplayer'];

                        $json->proxyConfig->maxPlayers = $maxplayer;

                        $string = array("group" => $json);
                        $string = json_encode($string);
                        $main->sendRequest("updateproxygroup", $string);
                    }
                    if ($_POST['action'] == "editbungeetablist") {
                        $json = $main->sendRequest("proxygroup", $_GET['bungee'])->response;

                        $firstline = $_POST['firstline'];
                        $secondline = $_POST['secondline'];

                        $json->proxyConfig->tabList->header = $firstline;
                        $json->proxyConfig->tabList->footer = $secondline;

                        $string = array("group" => $json);
                        $string = json_encode($string);
                        $main->sendRequest("updateproxygroup", $string);
                    }


                    header('Location:' . $main->getconfig("domainurl") . '/logged/proxy/setting?bungee=' . $_GET['bungee']);
                    die();
                }

                include "../sites/header.php";
                include "../sites/logged/proxy_setting.php";
                include "../sites/footer.php";
            });
        });
        $this->any('/server', function () use ($main) {
            if (!isset($_SESSION['cn_webinterface-logged'])) {
                header('Location:' . $main->getconfig("domainurl"));
                die();
            }
            if (isset($_POST['action'])) {
                if ($_POST['action'] == "createserver") {
                    $wrapper = $_POST['wrapper'];
                    $groupname = $_POST['groupname'];
                    $servertype = $_POST['servertype'];
                    $groupmode = $_POST['groupmode'];
                    $speicherort = $_POST['speicherort'];
                    $memory = $_POST['memory'];
                    $onlinegroup = $_POST['onlinegroup'];
                    $onlineglobal = $_POST['onlineglobal'];
                    $minonline = $_POST['minonline'];
                    $percent = $_POST['percent'];
                    $string = '{"group": {"name": "' . $groupname . '","wrapper": ["' . $wrapper . '"],"kickedForceFallback": true,"serverType": "' . $servertype . '","groupMode": "' . $groupmode . '","globalTemplate": {"name": "globaltemplate","backend": "' . $speicherort . '","url": null,"processPreParameters": [],"installablePlugins": []},"templates": [{"name": "default","backend": "' . $speicherort . '","url": null,"processPreParameters": [],"installablePlugins": []}],"memory": "' . $memory . '","dynamicMemory": "' . $memory . '","joinPower": 0,"maintenance": true,"minOnlineServers": "' . $minonline . '","maxOnlineServers": -1,"advancedServerConfig": {"notifyPlayerUpdatesFromNoCurrentPlayer": true,"notifyProxyUpdates": true,"notifyServerUpdates": true,"disableAutoSavingForWorlds": true},"percentForNewServerAutomatically": "' . $percent . '","priorityService": {"stopTimeInSeconds": 300,"global": {"onlineServers": "' . $onlineglobal . '","onlineCount": 100},"group": {"onlineServers": "' . $onlinegroup . '","onlineCount": 100}},"settings": {}}}';;

                    $main->sendRequest("updateservergroup", $string);
                }

                $_POST['action'] == "stopgroup" ? $main->sendRequest("dispatchcloudcommand", "shutdown GROUP " . $_POST['group']) : false;
                $_POST['action'] == "stopserver" ? $main->sendRequest("stopserver", $_POST['group']) : false;
                $_POST['action'] == "startserver" ? $main->sendRequest_amount("startserver", $_POST['group'], $_POST['count']) : false;
                $_POST['action'] == "deletegroup" ? $main->sendRequest("dispatchcloudcommand", "shutdown GROUP " . $_POST['group']) : false;
                $_POST['action'] == "deletegroup" ? $main->sendRequest("deleteservergroup", $_POST['group']) : false;
                $_POST['action'] == "stopallserver" ? $main->sendRequest("shutdownservers") : false;


                header('Location:' . $main->getconfig("domainurl") . '/logged/server?action=' . $_POST['action']);
                die();
            }


            include "../sites/header.php";
            include "../sites/logged/server.php";
            include "../sites/footer.php";
        });

    });
});


$route->end();