<section id="one" class="wrapper style">
    <div class="container">
        <div class="row">
            <div class="20u 12u$(medium)">
                <section class="box">
                    <h5><?php
                        $json = $main->sendRequest("corelog");
                        $log = $json->log;
                        echo $log;
                        ?>
                    </h5>
                </section>
            </div>

            <div class="6u 12u$(medium)">
                <section id="1" class="box">
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
                        ?>
                    </p>
                </section>
            </div>
        </div>
    </div>
</section>




