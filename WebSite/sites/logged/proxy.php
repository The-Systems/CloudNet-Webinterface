<section id="1" class="wrapper style">
    <div class="container-fluid">
        <div class="row">
            <?php
            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.creategroup");
            if ($json->response == true) { ?>
                <div class="col-4">
                    <section class="box">
                        <h3><?= $main->language_getMessage("createproxygroup") ?></h3>
                        <p><?= $main->language_getMessage("createproxygroupinfo") ?></p>
                        <form method="post">
                            <input type="hidden" name="action" value="createproxy">

                            <p><?= $main->language_getMessage("creategroupname") ?>: <input type="text" name="groupname"
                                                                                            class="form-control"
                                                                                            placeholder="<?= $main->language_getMessage("creategroupname") ?>"
                                                                                            required/></p>
                            <p><?= $main->language_getMessage("creategroupram") ?>: <input type="text" name="memory"
                                                                                           class="form-control"
                                                                                           placeholder="<?= $main->language_getMessage("creategroupram") ?>"
                                                                                           required/></p>
                            <p><?= $main->language_getMessage("creategroupstartport") ?>: <input type="text"
                                                                                                 name="startport"
                                                                                                 class="form-control"
                                                                                                 placeholder="<?= $main->language_getMessage("creategroupstartport") ?>"
                                                                                                 required/></p>
                            <p><?= $main->language_getMessage("creategroupalwaysonline") ?>: <input type="text"
                                                                                                    name="minonline"
                                                                                                    class="form-control"
                                                                                                    placeholder="<?= $main->language_getMessage("creategroupalwaysonline") ?>"
                                                                                                    required/></p>
                            <p><?= $main->language_getMessage("creategroupmode") ?>:
                                <select name="groupmode"></p>
                            <option value="DYNAMIC">Dynamic</span></option>
                            <option value="STATIC">Static</span></option>
                            </select>
                            <p><?= $main->language_getMessage("creategrouptemplateplace") ?>:
                                <select name="speicherort"></p>
                            <option value="LOCAL">Local</span></option>
                            <option value="MASTER">Master</span></option>
                            </select>
                            <?php
                            $json = $main->sendRequest("wrapper");
                            $wrapper = $json->response;
                            ?>
                            <p><?= $main->language_getMessage("wrapper") ?>:
                                <select name="wrapper"></p>
                            <?php foreach ($wrapper as $element): ?>
                                <option value="<?php echo $element->id; ?>"><?php echo $element->id; ?></option>
                            <?php endforeach; ?>
                            </select>
                            <p></p>
                            <input type="submit" value="Gruppe erstellen"/>
                        </form>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "createproxy") {
                                    echo '<span style="color: #40FF00">' . $main->language_getMessage("successcreategroup") . '</span>';
                                }
                            }
                            ?>
                        </p>
                    </section>
                </div>
            <?php } ?>
            <?php
            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.startserver");
            if ($json->response == true) {
                ?>
                <div class="col-4">
                    <section class="box">
                        <h3><?= $main->language_getMessage("startproxy") ?></h3>
                        <p><?= $main->language_getMessage("startproxyinfo") ?></p>
                        <form method="POST">
                            <input type="hidden" name="action" value="startproxy">

                            <p><?= $main->language_getMessage("many") ?>: <input type="text" name="count"
                                                                                 class="form-control"
                                                                                 placeholder="<?= $main->language_getMessage("many") ?>"
                                                                                 required/></p>
                            <?php

                            $json = $main->sendRequest("cloudnetwork");
                            $proxygroups = $json->response->proxyGroups;
                            ?>

                            <p><?= $main->language_getMessage("group") ?>
                                <select name="group"></p>
                            <?php foreach ($proxygroups as $element): ?>
                                <option value="<?php echo $element->name; ?>"><span
                                            style="color: #40FF00"><?php echo $element->name; ?></span></option>
                            <?php endforeach; ?>
                            </select>
                            <p></p>
                            <input type="submit" value="Proxy starten"/>
                        </form>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "startproxy") {
                                    echo '<span style="color: #40FF00"> ' . $main->language_getMessage("successproxystart") . '</span>';
                                }
                            }
                            ?>
                        </p>
                    </section>
                </div>
                <?php
            }
            ?>
            <?php

            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.editproxy");
            if ($json->response == true) {
                ?>
                <div class="col-4">
                    <section class="box">
                        <h3><?= $main->language_getMessage("changeproxy") ?></h3>
                        <p><?= $main->language_getMessage("changeproxyinfo") ?></p>

                        <?php
                        $json = $main->sendRequest("proxygroups");
                        $proxygroups = $json->response;
                        ?>
                        <?php
                        $groupamount = 0;
                        foreach ($proxygroups as $element) {
                            $groupamount++;
                        }

                        if ($groupamount != 0) { ?>
                            <form action="<?= $main->getconfig("domainurl"); ?>/logged/proxy/setting" method="GET">

                                <?php
                                $json = $main->sendRequest("cloudnetwork");
                                $proxygroups = $json->response->proxyGroups;
                                ?>
                                <p><?= $main->language_getMessage("group") ?> <select name="bungee"></p>
                                <!-- Alle gruppen auflisten -->
                                <?php foreach ($proxygroups as $element): ?>
                                    <option value="<?php echo $element->name; ?>"><span
                                                style="color: #40FF00"><?php echo $element->name; ?></span></option>
                                <?php endforeach; ?>


                                </select>
                                <p></p>
                                <input type="submit" value="<?= $main->language_getMessage("changesettings") ?>"/>
                            </form>
                        <?php } else {
                            echo $main->language_getMessage("noproxygroupsexits");
                        } ?>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "serverstart") {
                                    echo '<span style="color: #40FF00">' . $main->language_getMessage("successsettingsave") . '</span>';
                                }
                            }

                            ?>    </p>

                    </section>
                </div>
            <?php } ?>
            <?php
            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.deletegroup");
            if ($json->response == true) {
                ?>
                <div class="col-4">
                    <section class="box">
                        <h3><?= $main->language_getMessage("deleteproxygroup") ?></h3>
                        <p><?= $main->language_getMessage("deleteproxygroup") ?></p>
                        <form method="POST">
                            <input type="hidden" name="action" value="deleteproxygroup">
                            <?php

                            $json = $main->sendRequest("cloudnetwork");
                            $servergroups = $json->response->proxyGroups;
                            ?>
                            <p><?= $main->language_getMessage("group") ?>: <select name="group"></p>
                            <!-- Alle gruppen auflisten -->
                            <?php foreach ($proxygroups as $element): ?>
                                <option value="<?php echo $element->name; ?>"><span
                                            style="color: #40FF00"><?php echo $element->name; ?></span></option>
                            <?php endforeach; ?>


                            </select>
                            <p></p>
                            <input type="submit" value="<?= $main->language_getMessage("deletegroup") ?>"/>
                        </form>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "deleteproxygroup") {
                                    echo '<span style="color: #40FF00">' . $main->language_getMessage("successgroupdelete") . '</span>';
                                }
                            }

                            ?>    </p>

                    </section>
                </div>
            <?php } ?>
            <?php
            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.stopserver");
            if ($json->response == true) {
                ?>
                <div class="col-4">
                    <section id="2" class="box">
                        <h3><?= $main->language_getMessage("stopproxy") ?></h3>
                        <p><?= $main->language_getMessage("stopproxyinfo") ?></p>
                        <form method="POST">
                            <input type="hidden" name="action" value="stopproxy">
                            <p><?= $main->language_getMessage("proxy") ?>: <input type="text" name="group"
                                                                                  class="form-control"
                                                                                  placeholder="<?= $main->language_getMessage("proxy") ?>"
                                                                                  required/></p>
                            <p></p>
                            <input type="submit" value="<?= $main->language_getMessage("stopproxy") ?>"/>
                        </form>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "stopproxy") {
                                    echo '<span style="color: #40FF00"> ' . $main->language_getMessage("successproxystop") . '</span>';
                                }
                            }

                            ?>    </p>

                    </section>
                </div>
            <?php } ?>
            <?php
            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.stopserver");
            if ($json->response == true) {
                ?>
                <div class="col-4">
                    <section id="2" class="box">
                        <h3><?= $main->language_getMessage("stopallproxy") ?></h3>
                        <p><?= $main->language_getMessage("stopallproxyinfo") ?></p>
                        <p>
                        <form method="POST">
                            <input type="hidden" name="action" value="stopallproxy">
                            <button class="button"
                                    type="submit"><?= $main->language_getMessage("stopallproxy") ?></button>
                        </form>
                        </p>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "stopallproxy") {
                                    echo '<span style="color: #40FF00"> ' . $main->language_getMessage("successallproxystop") . '</span>';
                                }
                            }

                            ?>    </p>

                    </section>
                </div>
            <?php } ?>
        </div>
    </div>
</section>