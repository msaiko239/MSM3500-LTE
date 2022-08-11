#!/bin/sh

apt-get -y install python3.10
sudo apt-get -y install python3-pip
pip3 install pyst3

sudo apt install -y php libapache2-mod-php php-pear php-dev libmcrypt-dev php-mysql
sudo pecl install mcrypt -y

cp *.php /var/www/html/
cp *.ini /var/www/html/

chmod 777 /var/www/html/*

mkdir /var/www/html/images
cp images/* /var/www/html/images/

cp agi/*.py /var/lib/asterisk/agi-bin/
chmod 777 /var/lib/asterisk/agi-bin/*.py

mkdir /var/log/axi
cp axi/input.csv /var/log/axi/
chmod 777 /var/log/axi/input.csv

echo 'www-data ALL=NOPASSWD: ALL' >> /etc/sudoers
