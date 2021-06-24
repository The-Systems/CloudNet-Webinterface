<section class="wrapper style special">
    <header class="major">
        <h2><?= $main->getconfig("name") ?></h2>
    </header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <section class="box">
                    <h3><?= $main->language_getMessage("welcome1") ?> <?= $_SESSION['cn_webinterface-name'] ?></h3>
                    <h4><?= $main->language_getMessage("welcome2") ?></h4>
                    <p><img src="https://minotar.net/cube/<?= $_SESSION['cn_webinterface-name'] ?>/120"
                            class="img-responsive"></p>
                    <p><a href="<?= $main->getconfig("domainurl") ?>/logout"
                          class="button"><?= $main->language_getMessage("logout") ?></a></p>
                </section>
            </div>
            <div class="col-md-6 col-lg-4">
                <section class="box">
                    <h2>
                        <?php

                        $json = $main->sendRequest("networkinfo");

                        $online = $json->response->onlineCount;
                        $maxonline = $json->response->maxPlayers;

                        if ($json->response->onlineCount == 0) {
                            echo $main->language_getMessage("noplayeronline");
                        } else {
                            if ($json->response->onlineCount == 1) {
                                echo strtr($main->language_getMessage("oneplayeronline"), ["@online" => $online, "@maxonline" => $maxonline]);
                            } else {
                                echo strtr($main->language_getMessage("playeronline"), ["@online" => $online, "@maxonline" => $maxonline]);
                            }
                        }


                        ?></h2>
                    <?php
                    $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.setgroup");

                    if ($json->response == true) {
                        ?>
                        <h3><?= $main->language_getMessage("setplayergroup") ?></h3>
                        <?php
                        $null = "0";
                        if ($online == $null) {
                            echo $main->language_getMessage("notuseronlinetosetgroup");
                        } else { ?>

                            <form method="POST">
                                <input type="hidden" name="action" value="setpermgroup">
                                <?php
                                $json = $main->sendRequest("onlineplayers");
                                $playersonline = $json->response;
                                ?>

                                <p><?= $main->language_getMessage("player") ?><select name="player"></p>
                                <?php foreach ($playersonline as $element): ?>
                                    <option value="<?php echo $element->name; ?>"><span
                                                style="color: #40FF00"><?php echo $element->name; ?></span></option>
                                <?php endforeach; ?>
                                </select>

                                <?php
                                $json = $main->sendRequest("permissiongroups");
                                $permgroups = $json->response;
                                ?>
                                <p><?= $main->language_getMessage("group") ?><select name="group"></p>
                                <?php foreach ($permgroups as $element): ?>
                                    <option value="<?php echo $element->name; ?>"><span
                                                style="color: #40FF00"><?php echo $element->name; ?></span></option>
                                <?php endforeach; ?>
                                </select>

                                <p></p>
                                <input type="submit" value="Gruppe setzen"/>
                            </form>
                            <?php
                        }
                    }
                    ?>
                </section>

            </div>
            <div class="col-md-6 col-lg-4">
                <section class="box">
                    <h3>CloudNet - Webinterface</h3>
                    <h4><?= $main->language_getMessage("version") ?> <?= $main->getcurrentversion(); ?> <?= $main->language_getMessage("from") ?></h4>

                    <p></p>
                    <p><a href="https://discord.gg/CYHuDpx"
                          class="button"><?= $main->language_getMessage("supportdiscord") ?></a></p>
                    <p><a href="https://www.spigotmc.org/resources/cloudnet-webinterface.58905/"
                          class="button"><?= $main->language_getMessage("spigotpage") ?></a></p>
                    <?php
                    $json = $main->getversion();
                    $version = $main->getcurrentversion();
                    $newversion = $json->response->version;
                    if ($json == false) { ?>
                        <h1><span style="color: #FF0000">Der Kontrollserver ist zurzeit nicht erreichbar.</span>
                        </h1><?php
                    } elseif ($version != $newversion) { ?>
                        <h1><span style="color: #FF0000"> <?= $main->language_getMessage("oldversion1") ?></span></h1>
                        <h1><span style="color: #FF0000"> <?= $main->language_getMessage("oldversion2") ?></span>
                        </h1><?php
                    }
                    ?>
                </section>
            </div>
            <div class="col-md-6 col-lg-4">
                <section class="box">

                    <div class="icon big rounded color1"><i class="fas fa-microchip"></i></div>
                    <?php
                    $json = $main->sendRequest("cpucores");
                    ?>

                    <h3><?= $main->language_getMessage("cpu") ?></h3>
                    <h1><?= $main->language_getMessage("all") ?>: <?php echo $json->response; ?></h1>
                </section>
            </div>
            <div class="col-md-6 col-lg-4">
                <section class="box">
                    <div class="icon big rounded color1"><i class="fas fa-desktop"></i></div>
                    <?php
                    $json = $main->sendRequest("wrappers");
                    ?>
                    <h3><?= $main->language_getMessage("wrapper") ?></h3>
                    <h1><?= $main->language_getMessage("connect") ?>
                        : <?php echo $json->response->connected; ?></h1>
                    <h1><?= $main->language_getMessage("notconnect") ?>
                        : <?php echo $json->response->notConnected; ?></h1>
                </section>
            </div>
            <div class="col-md-6 col-lg-4">
                <section class="box">
                    <div class="icon big rounded color1"><i class="fas fa-memory"></i></div>
                    <?php
                    $json = $main->sendRequest("networkmemory");
                    $usedmemory = $json->response->usedMemory;
                    $maxmemory = $json->response->maxMemory;
                    ?>
                    <h3><?= $main->language_getMessage("ram") ?></h3>
                    <h1><?php echo strtr($main->language_getMessage("mbused"), ["@used" => $usedmemory, "@max" => $maxmemory]); ?></h1>
                </section>
            </div>
        </div>
    </div>
</section>
<section class="wrapper style special">
    <div class="container-fluid">
        <h3><?= $main->language_getMessage("stats") ?></h3>
        <div class="row">
            <?php
            $json = $main->sendRequest("statistics");
            ?>
            <div class="col-md-6 col-lg-2" name="test">
                <div class="box">
                    <div class="icon rounded color1"><i class="fas fa-cloud"></i></div>
                    <p></p>
                    <h5><?= $main->language_getMessage("statscloudstart") ?>:
                        <?php
                        if (strpos(json_encode($json), 'cloudStartup') === false){
                            echo $main->language_getMessage("nostatsexits");
                        } else {
                        echo $json->response->cloudStartup; ?></h5><?php
                    } ?>
                    <h5><?= $main->language_getMessage("statswrapperstart") ?>:
                        <?php
                        if (strpos(json_encode($json), 'wrapperConnections') === false){
                            echo $main->language_getMessage("nostatsexits");
                        } else {
                        echo $json->response->wrapperConnections; ?></h5><?php
                } ?>
                </div>
            </div>

            <div class="col-md-6 col-lg-2" name="test">
                <div class="box">
                    <div class="icon rounded color1">  <i class="fas fa-headset"></i> </div>
                    <p></p>
                    <h5><?= $main->language_getMessage("statsplayerlogin") ?>:
                        <?php
                        if (strpos(json_encode($json), 'playerLogin') === false){
                            echo $main->language_getMessage("nostatsexits");
                        } else {
                        echo $json->response->playerLogin; ?></h5><?php
                    } ?>
                </div>
            </div>
            <div class="col-md-6 col-lg-2" name="test">
                <div class="box">
                    <div class="icon rounded color1"> <i class="fas fa-headset"></i></div>
                    <p></p>
                    <h5><?= $main->language_getMessage("statsplayermaxon") ?>:
                        <?php
                        if (strpos(json_encode($json), 'highestPlayerOnline') === false){
                            echo $main->language_getMessage("nostatsexits");
                        } else {
                        echo $json->response->highestPlayerOnline; ?></h5><?php
                    } ?>
                </div>
            </div>
            <div class="col-md-6 col-lg-2" name="test">
                <div class="box">
                    <div class="icon rounded color1"><i class="fas fa-code"></i></div>
                    <p></p>
                    <h5><?= $main->language_getMessage("statssendcommands") ?>:
                        <?php
                        if (strpos(json_encode($json), 'playerCommandExecutions') === false){
                            echo $main->language_getMessage("nostatsexits");
                        } else {
                        echo $json->response->playerCommandExecutions; ?></h5><?php
                    } ?>
                </div>
            </div>
            <div class="col-md-6 col-lg-2" name="test">
                <div class="box">
                    <div class="icon rounded color1"><i class="fas fa-server"></i></div>
                    <p></p>
                    <h5><?= $main->language_getMessage("statsstartserver") ?>:
                        <?php
                        if (strpos(json_encode($json), 'startedServers') === false){
                            echo $main->language_getMessage("nostatsexits");
                        } else {
                        echo $json->response->startedServers; ?></h5><?php
                    } ?>
                    <h5><?= $main->language_getMessage("statsstartproxy") ?>:
                        <?php
                        if (strpos(json_encode($json), 'startedProxys') === false){
                            echo $main->language_getMessage("nostatsexits");
                        } else {
                        echo $json->response->startedProxys; ?></h5><?php
                } ?>
                </div>
            </div>

            <div class="col-md-6 col-lg-2" name="test">
                <div class="box">
                    <div class="icon rounded color1">  <i class="fas fa-server"></i></div>
                    <p></p>
                    <h5><?= $main->language_getMessage("statsmaxonlineserver") ?>:
                        <?php
                        if (strpos(json_encode($json), 'highestServerOnlineCount') === false){
                            echo $main->language_getMessage("nostatsexits");
                        } else {
                        echo $json->response->highestServerOnlineCount; ?></h5><?php
                    } ?>
                    <?php
                    $json = $main->sendRequest("proxygroups");
                    $proxygroups = $json->response;
                    ?>
                    <h5><?= $main->language_getMessage("statsproxygroups") ?>: <?php
                        $groupamount = 0;
                        foreach ($proxygroups as $element) {
                            $groupamount++;
                        }
                        echo $groupamount;
                        ?>
                        <h5><?= $main->language_getMessage("statsservergroups") ?>: <?php


                            $json = $main->sendRequest("servergroups");
                            $servergroups = $json->response;
                            $groupamount = 0;
                            foreach ($servergroups as $element) {
                                $groupamount++;
                            }
                            echo $groupamount;
                            ?>
                        </h5>
                </div>
            </div>
        </div>

        <div class="row">

            <?php
            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.sendcommandtoconsole");
            if ($json->response == true) {
                ?>
                <div class="6u 12u$(medium)">
                    <section class="box">
                        <h3><?= $main->language_getMessage("sendcommandtoconsole") ?></h3>
                        <p><?= $main->language_getMessage("sendcommandtoconsoleinfo") ?></p>
                        <form method="POST">
                            <input type="hidden" name="action" value="dispatchcommand">
                            <p><?= $main->language_getMessage("command") ?>: <input type="text" name="command"
                                                                                    class="form-control"
                                                                                    placeholder="<?= $main->language_getMessage("command") ?>"
                                                                                    required/></p>
                            <p></p>
                            <input type="submit" value="<?= $main->language_getMessage("sendcommand") ?>"/>
                        </form>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "dispatchcommand") {
                                    echo '<span style="color: #40FF00">' . $main->language_getMessage("successcommandsendconsole") . '</span>';
                                }
                            }

                            ?>    </p>
                    </section>
                </div>

                <?php
            }
            ?>

            <?php
            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.sendcommandtoserver");
            if ($json->response == true) {
                ?>
                <div class="6u 12u$(medium)">
                    <section class="box">
                        <h3><?= $main->language_getMessage("sendcommandtoserver") ?></h3>
                        <p><?= $main->language_getMessage("sendcommandtoserverinfo") ?></p>
                        <form method="POST">
                            <input type="hidden" name="action" value="sendcommandtoserver">
                            <p><?= $main->language_getMessage("sendcommandtoservername") ?>: <input type="text"
                                                                                                    name="server"
                                                                                                    class="form-control"
                                                                                                    placeholder="<?= $main->language_getMessage("sendcommandtoservername") ?>"
                                                                                                    required/></p>
                            <p><?= $main->language_getMessage("command") ?>: <input type="text" name="command"
                                                                                    class="form-control"
                                                                                    placeholder="<?= $main->language_getMessage("command") ?>"
                                                                                    required/></p>
                            <p></p>
                            <input type="submit" value="Befehl senden"/>
                        </form>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "sendcommandtoserver") {
                                    echo '<span style="color: #40FF00">' . $main->language_getMessage("successcommandsendserver") . '</span>';
                                }
                            }

                            ?>    </p>
                    </section>
                </div>

                <?php
            }
            ?>
        </div>

        <div class="row">

            <?php
            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.stopcloud");

            if ($json->response == true) {
                ?>
                <div class="6u 12u$(medium)">
                    <section class="box">
                        <h3><?= $main->language_getMessage("stopcloud") ?></h3>
                        <p><?= $main->language_getMessage("stopcloudinfo") ?></p>
                        <p></p>
                        <p>
                        <form method="POST">
                            <input type="hidden" name="action" value="stopcloud">
                            <input type="submit" value="<?= $main->language_getMessage("stopcloud") ?>"/>
                        </form>
                    </section>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
</section>
