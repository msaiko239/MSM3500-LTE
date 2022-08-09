#!/bin/sh

apt-get -y install python3.10
sudo apt-get -y install python3-pip
pip3 install --upgrade --force-reinstall pyst2


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
