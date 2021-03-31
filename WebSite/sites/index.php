<section id="one" class="wrapper style">
    <header class="major">
        <h2><?= $main->getconfig("name") ?></h2>
    </header>
    <div class="container">
        <div class="row">
            <div class="6u 12u$(medium)">
                <section class="box">
                    <h3><?= $main->language_getMessage("webinterface") ?></h3>
                    <p><?= $main->language_getMessage("loginacc") ?></p>
                    <p></p>
                    <p><?= $main->language_getMessage("data") ?></p>
                    <p></p>
                    <?php
                    $json = $main->getversion();
                    $version = $main->getcurrentversion();
                    $newversion = $json->response->version;
                    if ($version != $newversion) { ?>
                        <h1><span style="color: #FF0000"> <?= $main->language_getMessage("oldversion1") ?></span></h1>
                        <h1><span style="color: #FF0000"> <?= $main->language_getMessage("oldversion2") ?></span>
                        </h1><?php
                    }
                    ?>
                </section>
            </div>
            <div class="6u 12u$(medium)">
                <section id="2" class="box">
                    <h3><?= $main->language_getMessage("login") ?></h3>
                    <?php
                    if ($main->getconfig("google_recaptcha_type") == "2") {
                        echo $main->language_getMessage("recaptchaloginon");
                    } ?>
                    <br>
                    <form id="login" method="post">
                        <input type="hidden" name="action" value="login">
                        <p><?= $main->language_getMessage("username") ?>:
                            <input type="text" name="email" class="form-control"
                                   placeholder="<?= $main->language_getMessage("username") ?>" required/>
                        </p>
                        <p><?= $main->language_getMessage("password") ?>:
                            <input type="password" name="password" class="form-control"
                                   placeholder="<?= $main->language_getMessage("password") ?>" autocomplete="off"
                                   required/></p>
                        <p></p>
                        <?php
                        if ($main->getconfig("google_recaptcha_enabled") == "true") {
                        if ($main->getconfig("google_recaptcha_type") == 1) { ?>
                        <div class="g-recaptcha" data-sitekey="<?= $main->getconfig("google_recaptcha_public") ?>"
                             required/>
            </div>
            <br>
            <button type="submit"><?= $main->language_getMessage("loginin") ?></button><?php
            }
            if ($main->getconfig("google_recaptcha_type") == 2) { ?>
                <input
                class="g-recaptcha"
                type="submit"
                value="<?= $main->language_getMessage("loginin") ?>"
                data-sitekey="<?= $main->getconfig("google_recaptcha_public") ?>"
                data-callback="onSubmit"
                ><?php
            }
            if ($main->getconfig("google_recaptcha_type") == 3) { ?>
                <input
                class="g-recaptcha"
                type="submit"
                value="<?= $main->language_getMessage("loginin") ?>"
                data-sitekey="<?= $main->getconfig("google_recaptcha_public") ?>"
                data-callback="onSubmit"
                ><?php
            }
            } else { ?>
                <input type="submit" value="<?= $main->language_getMessage("loginin") ?>"/>
            <?php } ?>
            <br>
            </form>

            <p><?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "401") {
                        echo '<span style="color: #FF0000"> ' . $main->language_getMessage("error1") . '</span>';
                    }
                    if ($_GET["error"] == "403") {
                        echo '<span style="color: #FF0000"> ' . $main->language_getMessage("error2") . '</span>';
                    }
                    if ($_GET["error"] == "logout") {
                        echo '<span style="color: #40FF00"> ' . $main->language_getMessage("error3") . '</span>';
                    }
                    if ($_GET["error"] == "expires") {
                        echo '<span style="color: #FF0000"> ' . $main->language_getMessage("error4") . '</span>';
                    }
                    if ($_GET["error"] == "shutdown") {
                        echo '<span style="color: #40FF00"> ' . $main->language_getMessage("error5") . '</span>';
                    }
                    if ($_GET["error"] == "bot") {
                        echo '<span style="color: #FF0000"> ' . $main->language_getMessage("error6") . ' (' . $_GET['errorcode'] . ')</span>';
                    }
                    if ($_GET["error"] == "versionerror") {
                        echo '<span style="color: #FF0000"> ' . $main->language_getMessage("error7") . '</span>';
                    }
                }
                ?></p>
        </div>
    </div>
</section>


