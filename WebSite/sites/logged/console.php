<section id="one" class="wrapper style">
    <header class="major">
        <h2><?= $main->language_getMessage("console") ?></h2>
    </header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" style="max-height: 700px">
                <div class='box scrollTop' id="scroll">
                    <h5 style="color: #ffffff;"><?php
                        $json = $main->sendRequest("corelog");
                        $log = $json->log;
                        echo $log;
                        ?>
                    </h5>
                </div>
            </div>

            <div class="col-lg-12">
                <section id="1" class="box">
                    <form method="POST">
                        <input type="hidden" name="action" value="dispatchcommand">
                        <div class="input-group mb-3">
                            <input type="text" name="command" class="form-control" placeholder="<?= $main->language_getMessage("command") ?>" aria-describedby="button-addon2" required>
                            <input class="btn btn-outline-secondary" type="submit" id="button-addon2" placeholder="<?= $main->language_getMessage("command") ?>">
                        </div>
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
    <script type="text/javascript">
        function scrollDown() {
            var scrolldiv = document.getElementById( "scroll" );
            scrolldiv.scrollTop = scrolldiv.scrollHeight;
        }
        window.addEventListener('load', scrollDown, false);
    </script>
</section>




