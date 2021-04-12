[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://opensource.org/licenses/Apache-2.0)
[![Discord](https://img.shields.io/discord/340197684688453632.svg?label=&logo=discord&logoColor=ffffff&color=7389D8&labelColor=6A7EC2)](https://discord.gg/CYHuDpx)
<br>

<img src="https://cdn.the-systems.eu/icon-transparent-banner.png" width="300px" />

# <b>CloudNet-Webinterface</b>

## Requirement

- CloudNet 2.1.17+ (NOT v3!)

- Webserver (or Webspace)
    - PHP 7+ (PHP8 recommended)
    - PHP Extensions: Curl (apt-get install phpX-curl)
    - Apache2 Mods: rewrite (a2enmod rewrite)

## Download

You can download the latest version from https://project.the-systems.eu/resources/cloudnet-webinterface

## Installation

1. Load the webinterface.jar into the Modules folder of the CloudNet-Master
2. Reloade the CloudNet-Master with "rl all"
3. The setup should start automatically. If it does not start, type "wisetup"
4. Complete the setup
5. Copy the files from CloudNet-Master/Website (!!!! DONT COPY CloudNet-Master/modules/webinterface !!!! THESE ARE ONLY
   THE CONFIG FILES !!!!) to your web server (
   default /var/www/html)
6. Type "composer install" in the SSH console
7. Have fun!

Info: The web interface also works on an external Webspace!

### Webserver Configuration

#### Apache2

1. Go to /etc/apache2/sites-available
2. Create a file with the extension .conf
   (Example: webinterface.conf)
3. Add the following and customize it.

        <VirtualHost *:80>
            ServerName webinterface.domain.com
            DocumentRoot "/var/www/webinterface/public"

            <Directory /var/www/webinterface/public>
                    AllowOverride All
            </Directory>


        </VirtualHost>

4. Activate the page with

        a2ensite webinterface.conf

5. Restart Apache2

        service apache2 restart

7. Install SSL Certificate with https://certbot.eff.org/

### Install Composer

#### Debian 10

    curl -sS https://getcomposer.org/installer | php
    php composer.phar install --no-dev -o

# GERMAN

## Vorraussetzungen

- CloudNet 2.1.17+ (NICHT v3!)

- Webserver (oder Webspace)
    - PHP 7+ (PHP8 empfohlen)
    - PHP Erweiterungen: Curl (apt-get install phpX-curl)
    - Apache2 Mods: rewrite (a2enmod rewrite)

## Download

Du kannst die aktuelle Version von https://project.the-systems.eu/resources/cloudnet-webinterface herunterladen

## Installation

1. Lade die webinterface.jar in den Module Ordner vom CloudNet-Master
2. Lade den CloudNet-Master mit "rl all" neu
3. Das Setup sollte automatisch starten, wenn es nicht startet, gebe "wisetup" ein
4. Erledige das Setup
5. Kopiere die Dateien von CloudNet-Master/Website (!!!! KOPIERE NICHT CloudNet-Master/modules/webinterface !!!! DAS
   SIND NUR DIE CONFIG DATEIEN !!!!) auf deinen Webserver (
   Standard /var/www/html)
6. Gebe "composer install" in die SSH-Konsole ein
7. Hab Spaß!

Info: Das Webinterface funktioniert ebenfalls auf einem Externen Webserver/Webspace!

### Webserver Configuration

#### Apache2

1. Gehe zu /etc/apache2/sites-available
2. Erstelle eine Datei mit der Endung .conf
   (Beispiel: webinterface.conf)
3. Füge das folgende ein und füge deine Daten ein

        <VirtualHost *:80>
            ServerName webinterface.domain.com
            DocumentRoot "/var/www/webinterface/public"

            <Directory /var/www/webinterface/public>
                    AllowOverride All
            </Directory>


        </VirtualHost>

4. Aktiviere die Seite mit

        a2ensite webinterface.conf

5. Starte Apache2 neu

        service apache2 restart

7. Installier ein SSL-Zertifikat mit https://certbot.eff.org/

### Composer installieren

#### Debian 10

    curl -sS https://getcomposer.org/installer | php
    php composer.phar install --no-dev -o

