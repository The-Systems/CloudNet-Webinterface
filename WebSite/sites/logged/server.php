<section id="1" class="wrapper style">
    <div class="container">
        <div class="row">
            <?php
            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.creategroup");
            if ($json->response == true) {
                ?>
                <div class="4u 12u$(medium)">
                    <section class="box">
                        <h3><?= $main->language_getMessage("creategroup") ?></h3>
                        <p><?= $main->language_getMessage("createservergroupinfo") ?></p>
                        <form method="post">
                            <input type="hidden" name="action" value="createserver">
                            <p><?= $main->language_getMessage("creategroupname") ?>: <input type="text" name="groupname"
                                                                                            class="form-control"
                                                                                            placeholder="<?= $main->language_getMessage("creategroupname") ?>"
                                                                                            required/></p>
                            <p><?= $main->language_getMessage("creategroupram") ?> <input type="text" name="memory"
                                                                                          class="form-control"
                                                                                          placeholder="<?= $main->language_getMessage("creategroupram") ?>"
                                                                                          required/></p>
                            <p><?= $main->language_getMessage("creategroupalwaysonline") ?> <input type="text"
                                                                                                   name="minonline"
                                                                                                   class="form-control"
                                                                                                   placeholder="<?= $main->language_getMessage("creategroupalwaysonline") ?>"
                                                                                                   required/></p>
                            <p><?= $main->language_getMessage("creategrouphowmany") ?> <input type="text" name="percent"
                                                                                              class="form-control"
                                                                                              placeholder="<?= $main->language_getMessage("creategrouphowmany") ?>"
                                                                                              required/></p>
                            <p><?= $main->language_getMessage("creategroupmode") ?>:
                                <select name="groupmode">
                                    <option value="LOBBY">Lobby</span></option>
                                    <option value="DYNAMIC">Dynamic</span></option>
                                    <option value="STATIC">Static</span></option>
                                    <option value="STATIC_LOBBY">Static-Lobby</span></option>
                                </select>
                            </p>
                            <p><?= $main->language_getMessage("creategroupserverversion") ?>:
                                <select name="servertype">
                                    <option value="BUKKIT">Bukkit</span></option>
                                    <option value="CAULDRON">Cauldron</span></option>
                                    <option value="GLOWSTONE">Glowstone</span></option>
                                </select>
                            </p>
                            <p><?= $main->language_getMessage("creategrouptemplateplace") ?>:
                                <select name="speicherort">
                                    <option value="LOCAL">Local</span></option>
                                    <option value="MASTER">Master</span></option>
                                </select>
                            </p>
                            <p><?= $main->language_getMessage("creategrouphowmanyonlinegroup") ?> <input type="text"
                                                                                                         name="onlinegroup"
                                                                                                         class="form-control"
                                                                                                         placeholder="<?= $main->language_getMessage("creategrouphowmanyonlinegroup") ?>"
                                                                                                         required/></p>
                            <p><?= $main->language_getMessage("creategrouphowmanyonline") ?> <input type="text"
                                                                                                    name="onlineglobal"
                                                                                                    class="form-control"
                                                                                                    placeholder="<?= $main->language_getMessage("creategrouphowmanyonline") ?>"
                                                                                                    required/></p>
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
                            <input type="submit" value="<?= $main->language_getMessage("creategroup") ?>"/>
                        </form>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "createserver") {
                                    echo '<span style="color: #40FF00">' . $main->language_getMessage("successgroupcreate") . '</span>';
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
                <div class="4u 12u$(medium)">
                    <section class="box">
                        <h3><?= $main->language_getMessage("stopgroup") ?></h3>
                        <p><?= $main->language_getMessage("stopgroupinfo") ?></p>
                        <form method="post">
                            <input type="hidden" name="action" value="stopgroup">
                            <?php
                            $json = $main->sendRequest("cloudnetwork");
                            $servergroups = $json->response->serverGroups;
                            ?>
                            <p><?= $main->language_getMessage("group") ?>:
                                <select name="group">
                                    <?php foreach ($servergroups as $element): ?>
                                        <option value="<?php echo $element->name; ?>"><span
                                                    style="color: #40FF00"><?php echo $element->name; ?></span></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p></p>
                            <input type="submit" value="<?= $main->language_getMessage("stopgroup") ?>"/>
                        </form>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "stopgroup") {
                                    echo '<span style="color: #40FF00">' . $main->language_getMessage("successgroupstop") . '</span>';
                                }
                            }
                            ?>
                        </p>
                    </section>
                </div>
                <div class="4u 12u$(medium)">
                    <section class="box">
                        <h3><?= $main->language_getMessage("stopserver") ?></h3>
                        <p><?= $main->language_getMessage("stopserverinfo") ?></p>
                        <form method="post">
                            <input type="hidden" name="action" value="stopserver">
                            <p><?= $main->language_getMessage("server") ?>: <input type="text" name="group"
                                                                                   class="form-control"
                                                                                   placeholder="<?= $main->language_getMessage("server") ?>"
                                                                                   required/></p>
                            <p></p>
                            <input type="submit" value="<?= $main->language_getMessage("stopserver") ?>"/>
                        </form>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "stopserver") {
                                    echo '<span style="color: #40FF00"> ' . $main->language_getMessage("successserverstop") . '</span>';
                                }
                            }
                            ?>
                        </p>
                    </section>
                </div>
                <div class="4u 12u$(medium)">
                    <section id="2" class="box">
                        <h3><?= $main->language_getMessage("stopallserver") ?></h3>
                        <p><?= $main->language_getMessage("stopallserverinfo") ?></p>
                        <form method="POST">
                            <input type="hidden" name="action" value="stopallserver">
                            <input type="submit" value="<?= $main->language_getMessage("stopallserver") ?>"/>
                        </form>
                        <p></p>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "stopallserver") {
                                    echo '<span style="color: #40FF00"> ' . $main->language_getMessage("successallserverstop") . '</span>';
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
                <div class="4u 12u$(medium)">
                    <section class="box">
                        <h3><?= $main->language_getMessage("startserver") ?></h3>
                        <p><?= $main->language_getMessage("startserverinfo") ?></p>
                        <form method="post">
                            <input type="hidden" name="action" value="startserver">
                            <p><?= $main->language_getMessage("many") ?>: <input type="text" name="count"
                                                                                 class="form-control"
                                                                                 placeholder="<?= $main->language_getMessage("many") ?>"
                                                                                 required/></p>
                            <?php
                            $json = $main->sendRequest("cloudnetwork");
                            $servergroups = $json->response->serverGroups;
                            ?>
                            <p><?= $main->language_getMessage("group") ?>
                                <select name="group">
                                    <?php foreach ($servergroups as $element): ?>
                                        <option value="<?php echo $element->name; ?>"><span
                                                    style="color: #40FF00"><?php echo $element->name; ?></span></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p></p>
                            <input type="submit" value="Server starten"/>
                        </form>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "startserver") {
                                    echo '<span style="color: #40FF00"> ' . $main->language_getMessage("successserverstart") . '</span>';
                                }
                            }
                            ?>
                        </p>
                    </section>
                </div>

            <?php } ?>
            <?php
            $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.deletegroup");
            if ($json->response == true) { ?>
                <div class="4u 12u$(medium)">
                    <section class="box">
                        <h3><?= $main->language_getMessage("deleteservergroup") ?></h3>
                        <p><?= $main->language_getMessage("deleteservergroupinfo") ?></p>
                        <form method="post">
                            <input type="hidden" name="action" value="deletegroup">
                            <?php
                            $json = $main->sendRequest("cloudnetwork");
                            $servergroups = $json->response->serverGroups;
                            ?>
                            <p><?= $main->language_getMessage("group") ?>:
                                <select name="group">
                                    <?php foreach ($servergroups as $element): ?>
                                        <option value="<?php echo $element->name; ?>"><span
                                                    style="color: #40FF00"><?php echo $element->name; ?></span></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p></p>
                            <input type="submit" value="<?= $main->language_getMessage("deletegroup") ?>"/>
                        </form>
                        <p><?php
                            if (isset($_GET["action"])) {
                                if ($_GET["action"] == "deletegroup") {
                                    echo '<span style="color: #40FF00">' . $main->language_getMessage("successgroupdelete") . '</span>';
                                }
                            }
                            ?>
                        </p>
                    </section>
                </div>

            <?php } ?>
        </div>
    </div>
</section>