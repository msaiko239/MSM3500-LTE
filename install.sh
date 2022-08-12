#!/bin/sh
set -x

sudo wget https://downloads.asterisk.org/pub/telephony/asterisk/asterisk-18-current.tar.gz
sudo cp asterisk-18-current.tar.gz /usr/local/src/asterisk-18-current.tar.gz
cd /usr/local/src/
sudo tar zxvf asterisk-18-current.tar.gz
sudo rm asterisk-18-current.tar.gz
cd asteri*
cd contrib/scripts/
sudo ./install_prereq install
sudo ./install_prereq install-unpackaged
cd ..
echo
cd ..
sudo ./configure
sudo make menuselect.makeopts
sudo make
sudo make install
sudo make samples
sudo make config
sudo make install-logrotate
sudo systemctl enable asterisk
sudo systemctl start asterisk

sudo apt-get -y install python3.10
sudo apt-get -y install python3-pip
sudo pip3 install pyst3

sudo apt install -y php libapache2-mod-php php-pear php-dev libmcrypt-dev php-mysql
sudo pecl install mcrypt -y

cd
cd /tmp/MSM3500-LTE

sudo cp *.php /var/www/html/
sudo cp *.ini /var/www/html/
sudo rm /var/www/html/index.html

sudo chmod 777 /var/www/html/*

sudo mkdir /var/www/html/images
sudo cp images/* /var/www/html/images/

sudo cp agi/*.py /var/lib/asterisk/agi-bin/
sudo chmod 777 /var/lib/asterisk/agi-bin/*.py

sudo mkdir /var/log/axi
sudo cp axi/input.csv /var/log/axi/
sudo chmod 777 /var/log/axi/input.csv

sudo cp -fr asterisk/pjsip.conf /etc/asterisk/pjsip.conf
sudo cp -fr asterisk/extensions.conf /etc/asterisk/extensions.conf
sudo cp -fr usr/local/lib/python3.8/dist-packages/asterisk/agi.py /usr/local/lib/python3.8/dist-packages/asterisk/agi.py
sudo asterisk -rx 'reload'

sudo echo 'www-data ALL=NOPASSWD: ALL' >> /etc/sudoers
