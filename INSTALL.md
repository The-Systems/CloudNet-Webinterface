[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://opensource.org/licenses/Apache-2.0)
<img src="https://cdn.the-systems.eu/icon-transparent-banner.png" width="300px" />

# <b>CloudNet-Webinterface</b>

## Installation

1. Load the webinterface.jar into the Modules folder of the CloudNet-Master
2. Reloade the CloudNet-Master with "rl all"
3. The setup should start automatically. If it does not start, type "wisetup"
4. Complete the setup
5. Copy the files from CloudNet-Master/Website (NOT CloudNet-Master/modules/webinterface!!!!) to your web server (
   default /var/www/html)
6. Type "composer install" in the SSH console
7. Have fun!

Info: The web interface also works on an external Webspace!

### Extended

Create Apache2 VHost

1. Go to /etc/apache2/sites-available
2. Create a file with the extension .conf
   (Example: webinterface.conf)
3. Add the following and customize it.

        <VirtualHost *:80>
            ServerName webinterface.domain.com
            DocumentRoot "/var/www/webinterface/"
        </VirtualHost>

4. Activate the page with

        a2ensite webinterface.com

5. Restart Apache2

        service apache2 restart

6. Install SSL Certificate with https://certbot.eff.org/

## Install Composer

### Debian 10

    curl -sS https://getcomposer.org/installer | php
    php composer.phar install --no-dev -o



   
