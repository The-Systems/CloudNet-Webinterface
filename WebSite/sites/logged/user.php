<?php
$json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.showuser");
if ($json->response == true) {
    $json = $main->sendRequest("servergroups");
    $servergroups = $json->response;
    ?>
    <section id="2" class="wrapper style">
        <header class="major">
            <h2><?= $main->language_getMessage("usertitle") ?></h2>
        </header>
        <div class="container-fluid">
            <div class="row">
                <?php
                $json1 = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.createuser");
                if ($json1->response == true) {
                    ?>
                    <div class="col-12 mb-3">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal"><i
                                    class="fas fa-plus"></i> <?= $main->language_getMessage("createtheuser") ?>
                        </button>
                    </div>
                    <?php
                }
                $json = $main->sendRequest("users");
                $users = $json->response;
                ?>
                <div class="table-scrollable">
                    <table>
                        <tr>
                            <th><?= $main->language_getMessage("name") ?></th>
                            <th><?= $main->language_getMessage("permissions") ?></th>
                            <th><?= $main->language_getMessage("action") ?></th>
                        </tr>
                        <?php foreach ($users as $element):
                            if ($element->name != $main->getConfig("cloudnet_user")) { ?>
                                <?php
                                $permission = "";
                                foreach ($element->permissions as $permissions):
                                    if ($permission === "") {
                                        $permission = $permissions;
                                    } else {
                                        $permission = $permission . ", " . $permissions;
                                    }
                                endforeach; ?>
                                <tr>
                                    <td><?php echo $element->name ?></td>
                                    <td><?php echo $permission ?></td>
                                    <td>
                                        <?php
                                        $json = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.deleteuser");
                                        if ($json->response == true) {
                                            ?>
                                            <form method="post">
                                                <input type="hidden" name="action" value="deleteuser">
                                                <input type="hidden" name="user" value="<?php echo $element->name; ?>">
                                                <button class="button-red noselect"><span
                                                            class='text'><?= $main->language_getMessage("deleteuser") ?></span><span
                                                            class="icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                              width="24"
                                                                              height="24" viewBox="0 0 24 24"><path
                                                                    d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"/></svg></span>
                                                </button>
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        endforeach; ?>
                    </table>
                </div>
                <?php
                $design = "";
                if ($main->getconfig("discord-theme") === "true") {
                    $design = "white";
                } else {
                    $design = "black";
                } ?>
                <?php
                $json1 = $main->sendRequest("permission", $_SESSION['cn_webinterface-name'], "web.createuser");
                if ($json1->response == true) {
                    ?>
                    ?>
                    <div class="modal fade dark" id="exampleModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="do3ument">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="color: <?= $design ?>" id="exampleModalLabel"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <section class="box">
                                        <h3><?= $main->language_getMessage("createuser") ?></h3>
                                        <p><?= $main->language_getMessage("createuserinfo") ?></p>
                                        <form method="post">
                                            <input type="hidden" name="action" value="createuser">

                                            <p><?= $main->language_getMessage("createusername") ?>: <input type="text"
                                                                                                           name="user"
                                                                                                           class="form-control"
                                                                                                           placeholder="<?= $main->language_getMessage("createusername") ?>"
                                                                                                           required/>
                                            </p>
                                            <p><?= $main->language_getMessage("createuserpassword") ?>: <input
                                                        type="password"
                                                        name="password"
                                                        class="form-control"
                                                        placeholder="<?= $main->language_getMessage("createuserpassword") ?>"
                                                        required/></p>
                                            <p></p>
                                            <input type="submit"
                                                   value="<?= $main->language_getMessage("createtheuser") ?>"/>
                                        </form>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
                integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
                crossorigin="anonymous"></script>

    </section>
<?php } else {
    header('Location:' . $main->getconfig("domainurl") . '/logged');
} ?>