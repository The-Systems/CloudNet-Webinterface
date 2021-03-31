<!DOCTYPE HTML>
<html>
<head>
    <title><?= $main->getconfig("name") ?></title>
    <meta name="description" content="CloudNet Webinterface for <?= $main->getconfig("name") ?>">
    <meta name="theme-color" content="#424242">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="<?= $main->getconfig("domainurl") ?>/assets/css/skel.css"/>
    <link rel="stylesheet" href="<?= $main->getconfig("domainurl") ?>/assets/css/style.css"/>
    <link rel="stylesheet" href="<?= $main->getconfig("domainurl") ?>/assets/css/style-xlarge.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"
          integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ"
          crossorigin="anonymous">

    <script src="<?= $main->getconfig("domainurl") ?>/assets/js/jquery.min.js"></script>
    <script src="<?= $main->getconfig("domainurl") ?>/assets/js/skel.min.js"></script>
    <script src="<?= $main->getconfig("domainurl") ?>/assets/js/skel-layers.min.js"></script>
    <script>

        (function ($) {

            skel.init({
                reset: 'full',
                breakpoints: {
                    global: {
                        href: '<?= $main->getconfig("domainurl") ?>/assets/css/style.css',
                        containers: 1400,
                        grid: {gutters: ['2em', 0]}
                    },
                    xlarge: {
                        media: '(max-width: 1680px)',
                        href: '<?= $main->getconfig("domainurl") ?>/assets/css/style-xlarge.css',
                        containers: 1200
                    },
                    large: {
                        media: '(max-width: 1280px)',
                        href: '<?= $main->getconfig("domainurl") ?>/assets/css/style-large.css',
                        containers: 960,
                        grid: {gutters: ['1.5em', 0]},
                        viewport: {scalable: false}
                    },
                    medium: {
                        media: '(max-width: 980px)',
                        href: '<?= $main->getconfig("domainurl") ?>/assets/css/style-medium.css',
                        containers: '90%!'
                    },
                    small: {
                        media: '(max-width: 736px)',
                        href: '<?= $main->getconfig("domainurl") ?>/assets/css/style-small.css',
                        containers: '90%!',
                        grid: {gutters: ['1.25em', 0]}
                    },
                    xsmall: {
                        media: '(max-width: 480px)',
                        href: '<?= $main->getconfig("domainurl") ?>/assets/css/style-xsmall.css'
                    }
                },
                plugins: {
                    layers: {
                        config: {
                            mode: 'transform'
                        },
                        navButton: {
                            breakpoints: 'medium',
                            height: '4em',
                            html: '<span class="toggle" data-action="toggleLayer" data-args="navPanel"></span>',
                            position: 'top-left',
                            side: 'top',
                            width: '6em'
                        },
                        navPanel: {
                            animation: 'overlayX',
                            breakpoints: 'medium',
                            clickToHide: true,
                            height: '100%',
                            hidden: true,
                            html: '<div data-action="moveElement" data-args="nav"></div>',
                            orientation: 'vertical',
                            position: 'top-left',
                            side: 'left',
                            width: 250
                        }
                    }
                }
            });

            $(function () {

                var $window = $(window),
                    $body = $('body');

                $body.addClass('is-loading');

                $window.on('load', function () {
                    $body.removeClass('is-loading');
                });

            });

        })(jQuery);
    </script>

    <?php
    if ($main->getconfig("google_recaptcha_enabled") == "true") {
    if ($main->getconfig("google_recaptcha_type") == 1) { ?>
        <script src='https://www.google.com/recaptcha/api.js'></script><?php
    }
    if ($main->getconfig("google_recaptcha_type") == 2) { ?>
        <script src='https://www.google.com/recaptcha/api.js'></script><?php
    }
    if ($main->getconfig("google_recaptcha_type") == 3) { ?>
        <script src='https://www.google.com/recaptcha/api.js?<?= $main->getconfig("google_recaptcha_public") ?>'></script><?php
    }
    } ?>
    <script>
        function onSubmit(token) {
            document.getElementById("login").submit();
        }
    </script>

    <style>

        table {
            width: 100%;
            margin: 2em 0;
            border-collapse: collapse;
            word-break: normal;
        }

        td {
            padding: .5em;
            vertical-align: top;
            border: 1px solid #bbbbbb;
        }

        th {
            padding: .5em;
            text-align: left;
            border: 1px solid #bbbbbb;
            border-bottom: 3px solid #bbbbbb;
            background: #f4f7fa;
        }


        .table-scrollable {
            width: 100%;
            overflow-y: auto;
            margin: 0 0 1em;
        }

        .table-scrollable::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 14px;
            height: 14px;
        }

        .table-scrollable::-webkit-scrollbar-thumb {
            border-radius: 8px;
            border: 3px solid #fff;
            background-color: rgba(0, 0, 0, .3);
        }
    </style>

</head>

<body id="landing">
<header id="header">

    <h1><a href="<?= $main->getconfig("domainurl") ?>"><?= $main->getconfig("name") ?></a></h1>
    <nav id="nav">
        <ul>
            <?php if (isset($_SESSION['cn_webinterface-logged'])) { ?>
                <li>
                    <a href="<?= $main->getconfig("domainurl") ?>/logged"><?= $main->language_getMessage("startpage") ?></a>
                </li>
                <li>
                    <a href="<?= $main->getconfig("domainurl") ?>/logged/server"><?= $main->language_getMessage("serverpage") ?></a>
                </li>
                <li>
                    <a href="<?= $main->getconfig("domainurl") ?>/logged/proxy"><?= $main->language_getMessage("proxypage") ?></a>
                </li>
            <?php } ?>
            <li>
                <a>
                    <?= $main->language_getMessage("cloudstatus") ?>
                    <?php
                    $json = $main->sendRequest("testonline");
                    if ($json->success == true) {
                        echo '<span style="color: #40FF00"> ' . $main->language_getMessage("online") . '</span>';
                    } else {
                        echo '<span style="color: #FF0000"> ' . $main->language_getMessage("offline") . '</span>';
                    }

                    ?>
                </a>
            </li>
        </ul>
    </nav>
</header>