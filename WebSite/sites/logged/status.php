<?php
$json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.status");
if ($json->response == true) { ?>
    <?php
    $json = $main->sendRequest("servergroups");
    $servergroups = $json->response;
    ?>
    <section id="2" class="wrapper style">
        <header class="major">
            <h2><?= $main->language_getMessage("statusserver") ?></h2>
        </header>
        <div class="container-fluid">
            <div class="row">
                <h3><?= $main->language_getMessage("server") ?></h3>
                <div class="table-scrollable">
                    <table>
                        <tr>
                            <th><?= $main->language_getMessage("group") ?></th>
                            <th><?= $main->language_getMessage("typ") ?></th>
                            <th><?= $main->language_getMessage("online") ?></th>
                            <th><?= $main->language_getMessage("server") ?></th>
                            <th><?= $main->language_getMessage("wrapper") ?></th>
                            <th><?= $main->language_getMessage("port") ?></th>
                            <th><?= $main->language_getMessage("player") ?></th>
                            <th><?= $main->language_getMessage("template") ?></th>
                            <th><?= $main->language_getMessage("state") ?></th>
                            <th><?= $main->language_getMessage("motd") ?></th>
                            <th><?= $main->language_getMessage("ram") ?></th>
                            <th><?= $main->language_getMessage("stopserver") ?></th>
                        </tr>

                        <!-- Alle gruppen auflisten -->
                        <?php foreach ($servergroups as $element):

                            $json = $main->sendRequest("serverinfos", $element->name);
                            $serverinfos = $json->response;
                            ?>

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
                                <td>

                                    <form method="POST">
                                        <input type="hidden" name="action" value="infostopgroup">
                                        <input type="hidden" name="id" value="<?php echo $element->name; ?>">
                                        <input type="submit" value="<?= $main->language_getMessage("stop") ?>"/>
                                    </form>
                                </td>
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
                                <td>

                                    <form method="POST">
                                        <input type="hidden" name="action" value="infostopserver">
                                        <input type="hidden" name="id"
                                               value="<?php echo $element->serviceId->serverId; ?>">
                                        <input type="submit" value="<?= $main->language_getMessage("stop") ?>"/>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
                <form method="POST" class="align-content-center">
                    <input type="hidden" name="action" value="infostopallserver">
                    <input type="submit" value="<?= $main->language_getMessage("allstop") ?>"/>
                </form>
            </div>
            <div class="row">


                <?php
                $json = $main->sendRequest("proxygroups");

                $proxygroups = $json->response;
                ?>

                <h3><?= $main->language_getMessage("proxy") ?></h3>
                <br>
                <div class="table-scrollable">
                    <table>
                        <tr>
                            <th><?= $main->language_getMessage("group") ?></th>
                            <th><?= $main->language_getMessage("typ") ?></th>
                            <th><?= $main->language_getMessage("online") ?></th>
                            <th><?= $main->language_getMessage("server") ?></th>
                            <th><?= $main->language_getMessage("wrapper") ?></th>
                            <th><?= $main->language_getMessage("port") ?></th>
                            <th><?= $main->language_getMessage("player") ?></th>
                            <th><?= $main->language_getMessage("ram") ?></th>
                            <th><?= $main->language_getMessage("stopproxy") ?></th>
                        </tr>

                        <?php foreach ($proxygroups as $element):

                            $json = $main->sendRequest("proxyinfos", $element->name);

                            $proxyinfos = $json->response;
                            ?>

                            <tr>
                                <td><?php echo $element->name; ?></td>
                                <td><?php echo $element->proxyGroupMode; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="action" value="infostopgroup">
                                        <input type="hidden" name="id" value="<?php echo $element->name; ?>">
                                        <input type="submit" value="<?= $main->language_getMessage("stop") ?>"/>
                                    </form>
                                </td>
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
                                <td>

                                    <form method="POST">
                                        <input type="hidden" name="action" value="infostopproxy">
                                        <input type="hidden" name="id"
                                               value="<?php echo $element->serviceId->serverId; ?>">
                                        <input type="submit" value="<?= $main->language_getMessage("stop") ?>"/>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="infostopallproxy">
                    <input type="submit" value="<?= $main->language_getMessage("allstop") ?>"/>
                </form>
            </div>
            <div class="row">
                <?php

                $json = $main->sendRequest("wrapper");
                $wrapper = $json->response;
                ?>
                <h3><?= $main->language_getMessage("wrapper") ?></h3>

                <br>
                <div class="table-scrollable">
                    <table>
                        <tr>
                            <th><?= $main->language_getMessage("wrapper") ?></th>
                            <th><?= $main->language_getMessage("ip") ?></th>
                            <th><?= $main->language_getMessage("startport") ?></th>
                            <th><?= $main->language_getMessage("ram") ?></th>
                            <th><?= $main->language_getMessage("cpucores") ?></th>
                            <th><?= $main->language_getMessage("cpuload") ?></th>
                            <th><?= $main->language_getMessage("queuesize") ?></th>
                            <th><?= $main->language_getMessage("stopwrapper") ?></th>
                        </tr>

                        <?php
                        $json = $main->sendRequest("wrapperinfos", $element->id);
                        $wrapperinfos = $json->response;
                        ?>
                        <?php foreach ($wrapperinfos as $element): ?>
                            <tr>
                                <td><?php echo $element->serverId; ?></td>
                                <td><?php echo $element->hostName; ?></td>
                                <td><?php echo $element->startPort; ?></td>
                                <td><?php echo $element->usedMemory; ?>mb / <?php echo $element->memory; ?>mb</td>
                                <td><?php echo $element->availableProcessors; ?></td>
                                <td><?php echo round($element->cpuUsage, 2); ?>%</td>
                                <td><?php echo $element->process_queue_size; ?></td>
                                <td>

                                    <form method="POST">
                                        <input type="hidden" name="action" value="infostopwrapper">
                                        <input type="hidden" name="id" value="<?php echo $element->serverId; ?>">
                                        <input type="submit" value="<?= $main->language_getMessage("stop") ?>"/>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="infostopallwrapper">
                    <input type="submit" value="<?= $main->language_getMessage("allstop") ?>"/>
                </form>
            </div>
        </div>
    </section>
    <?php
}
?>