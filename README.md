# digital-schoolhouse

# LAMP Stack by Bitnami on AWS

LAMP with PHP 7.1 Certified by Bitnami

associate an elastic IP and visit to confirm

connect to the IP with ssh (PuTTY)

login as bitnami and sudo su

cat ./bitnami_credentials returns the default password (GqY7BtVcMrGZ in production)

upload web content to /home/bitnami/htdocs

chmod -R 777 /home/bitnami/htdocs/images

chown -R bitnami:daemon /home/bitnami/htdocs/admin

rm /home/bitnami/htdocs/config.php

rm /home/bitnami/htdocs/setup.md5

refresh site to start the AppGini setup routine

# Database Information

MySQL server (host): localhost

Database name: dsh

MySQL Username: root

MySQL password: [default password]

# Admin Information

Username: admin

Email Address: [email address]

Password / Confirm Password: admin

# Error: Unable to write to config file

create a replacement config.php and upload to /htdocs

replace the target config.php with the local php and edit as follows

SdbPassword = 'default pwd';

$dbDatabase='dsh';

chmod 777 config.php

refresh the site

sign in as admin / admin and change the password (could be admin /way2gopro if local config.php was copied and header edited)

update the Admin utilities for customisations per config.php - the header is the different part per local and prod

update the Member approval email message with the correct URL

re-create the * REGISTER SCHOOL group with no permissions and set to require approval

add FAQ, Role Types, Roles

# Customised Files

login.php

language.php

membership_signup.php

membership_thankyou.php

config.php (customised per install)

/resources/images/appgini-icon.png is the custom favicon (64x64)

# Let's Encrypt

 curl -s https://api.github.com/repos/xenolf/lego/releases/latest | grep browser_download_url | grep linux_amd64 | cut -d '"' -f 4 | wget -i - tar xf lego_v1.0.1_linux_amd64.tar.gz

 tar xf lego_vX.Y.Z_linux_amd64.tar.gz

mv lego /usr/local/bin/lego

/opt/bitnami/ctlscript.sh stop

lego --email="julian@edgeesports.gg" --domains="dsh.edgeesports.gg" --path="/etc/lego" run

Valid for 90 days then:

lego --email="julian@edgeesports.gg" --domains="dsh.edgeesports.gg" --path="/etc/lego" renew

# Force HTTPS Redirection

https://docs.bitnami.com/aws/infrastructure/lamp/administration/force-https-apache/
