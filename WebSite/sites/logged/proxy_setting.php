<section id="one" class="wrapper style">
    <div class="container">
        <div class="row">
            <div class="6u 12u$(medium)">
                <section class="box">
                    <h3><?= $main->language_getMessage("settingmotd") ?></h3>
                    <?php
                    $bungee = $_GET['bungee'];
                    $json = $main->sendRequest("proxygroup", $bungee);
                    $motd = $json->response->proxyConfig->motdsLayouts;
                    $motdmaintenance = $json->response->proxyConfig->maintenanceMotdLayout;
                    $maxplayer = $json->response->proxyConfig->maxPlayers;
                    $bungeeversion = $json->response->proxyVersion;
                    $tablist = $json->response->proxyConfig->tabList;
                    ?>

                    <form method="POST">
                        <input type="hidden" name="action" value="editbungeemotd">

                        <?php foreach ($motd as $element): ?>
                            <p><?= $main->language_getMessage("settingmotdfirstline") ?>: <input type="text"
                                                                                                 value="<?php echo $element->firstLine; ?>"
                                                                                                 name="firstline[]"
                                                                                                 class="form-control"
                                                                                                 placeholder="<?= $main->language_getMessage("settingmotdfirstline") ?>"/>
                            </p>
                            <p><?= $main->language_getMessage("settingmotdsecondline") ?>: <input type="text"
                                                                                                  value="<?php echo $element->secondLine; ?>"
                                                                                                  name="secondline[]"
                                                                                                  class="form-control"
                                                                                                  placeholder="<?= $main->language_getMessage("settingmotdsecondline") ?>"/>
                            </p>
                        <?php endforeach; ?>

                        <p><?= $main->language_getMessage("settingmotdfirstline") ?>: <input type="text"
                                                                                             name="firstline[]"
                                                                                             class="form-control"
                                                                                             placeholder="<?= $main->language_getMessage("settingmotdfirstline") ?>"/>
                        </p>
                        <p><?= $main->language_getMessage("settingmotdsecondline") ?>: <input type="text"
                                                                                              name="secondline[]"
                                                                                              class="form-control"
                                                                                              placeholder="<?= $main->language_getMessage("settingmotdsecondline") ?>"/>
                        </p>

                        <p></p>
                        <input type="submit" value="Speichern"/>
                    </form>
            </div>
            <div class="6u 12u$(medium)">
                <section class="box">
                    <h3><?= $main->language_getMessage("settingmaintenancemotd") ?></h3>

                    <form method="POST">
                        <input type="hidden" name="action" value="editbungeemaintenancemotd">

                        <p><?= $main->language_getMessage("settingmotdfirstline") ?>: <input type="text"
                                                                                             value="<?php echo $motdmaintenance->firstLine; ?>"
                                                                                             name="firstline"
                                                                                             class="form-control"
                                                                                             placeholder="<?= $main->language_getMessage("settingmotdfirstline") ?>"
                                                                                             required/></p>
                        <p><?= $main->language_getMessage("settingmotdsecondline") ?>: <input type="text"
                                                                                              value="<?php echo $motdmaintenance->secondLine; ?>"
                                                                                              name="secondline"
                                                                                              class="form-control"
                                                                                              placeholder="<?= $main->language_getMessage("settingmotdsecondline") ?>"
                                                                                              required/></p>

                        <p></p>
                        <input type="submit" value="Speichern"/>
                    </form>
            </div>
            <div class="4u 12u$(medium)">
                <section class="box">
                    <h3><?= $main->language_getMessage("settingmaxplayerchange") ?></h3>

                    <form method="POST">
                        <input type="hidden" name="action" value="editbungeemaxplayer">


                        <p><?= $main->language_getMessage("settingmaxplayer") ?>: <input type="text"
                                                                                         value="<?php echo $maxplayer; ?>"
                                                                                         name="maxplayer"
                                                                                         class="form-control"
                                                                                         placeholder="Maximale Spieler: "
                                                                                         required/></p>

                        <p></p>
                        <input type="submit" value="Speichern"/>
                    </form>
            </div>
            <div class="10u 12u$(medium)">
                <section class="box">
                    <h3><?= $main->language_getMessage("settingtablist") ?></h3>

                    <form method="POST">
                        <input type="hidden" name="action" value="editbungeetablist">

                        <p><?= $main->language_getMessage("settingtablistfirstline") ?>: <input type="text"
                                                                                                value="<?php echo $tablist->header; ?>"
                                                                                                name="firstline"
                                                                                                class="form-control"
                                                                                                placeholder="<?= $main->language_getMessage("settingtablistfirstline") ?>"
                                                                                                required/></p>
                        <p><?= $main->language_getMessage("settingtablistsecondline") ?>: <input type="text"
                                                                                                 value="<?php echo $tablist->footer; ?>"
                                                                                                 name="secondline"
                                                                                                 class="form-control"
                                                                                                 placeholder="<?= $main->language_getMessage("settingtablistsecondline") ?>"
                                                                                                 required/></p>

                        <p></p>
                        <input type="submit" value="Speichern"/>
                    </form>
            </div>
        </div>
    </div>
</section>




