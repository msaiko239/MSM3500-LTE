#!/bin/bash
set -e

WORKING_DIR=$(pwd)

echo "========================================="
echo "   Installing MSM3500 System (Option A)"
echo "========================================="

# ------------------------------
# 1. UPDATE SYSTEM
# ------------------------------
apt-get update -y
apt-get upgrade -y

# ------------------------------
# 2. INSTALL REQUIRED PACKAGES
# ------------------------------
apt-get install -y \
  curl wget git build-essential python3 python3-pip python3-venv \
  nginx ufw jq tar sudo

# ------------------------------
# 3. INSTALL NODE.JS 20 LTS
# ------------------------------
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs

echo "Node installed: $(node -v)"

# ------------------------------
# 4. INSTALL ASTERISK 22 (NON-ROOT USER)
# ------------------------------
echo "Installing Asterisk..."

ASTERISK_USER="asterisk"
ASTERISK_GROUP="asterisk"

adduser --system --group --home /var/lib/asterisk $ASTERISK_USER || true

apt-get install -y \
  libedit-dev uuid-dev libjansson-dev libxml2-dev libsqlite3-dev \
  pkg-config subversion libssl-dev

cd /usr/src
wget https://downloads.asterisk.org/pub/telephony/asterisk/asterisk-22-current.tar.gz
tar xvf asterisk-22-current.tar.gz
cd asterisk-22*/

contrib/scripts/install_prereq install
contrib/scripts/install_prereq install-unpackaged

./configure --with-pjproject-bundled

make menuselect.makeopts
make
make install
make samples
make config
make install-logrotate

# Run Asterisk as non-root
sed -i 's/^AST_USER=.*/AST_USER="asterisk"/' /etc/default/asterisk
sed -i 's/^AST_GROUP=.*/AST_GROUP="asterisk"/' /etc/default/asterisk

chown -R asterisk:asterisk /var/{lib,log,spool}/asterisk
chown -R asterisk:asterisk /etc/asterisk
chmod -R 750 /var/{lib,log,spool}/asterisk

systemctl enable asterisk
systemctl restart asterisk

# ------------------------------
# 5. INSTALL RABBITMQ + PYTHON MQ CLIENTS
# ------------------------------
apt-get install rabbitmq-server -y
systemctl enable rabbitmq-server
systemctl start rabbitmq-server

pip3 install pika requests pyst3 pycurl --break-system-packages

# ------------------------------
# 6. INSTALL MSM3500 APPLICATION
# ------------------------------
cd $WORKING_DIR
INSTALL_DIR="/var/www/MSM3500"
mkdir -p $INSTALL_DIR

echo "Copying MSM3500 files..."
cp -r public $INSTALL_DIR/
cp -r routes $INSTALL_DIR/
cp -r lib $INSTALL_DIR/
cp server.js $INSTALL_DIR/
cp package.json package-lock.json $INSTALL_DIR/
cp config.ini $INSTALL_DIR/
cp -r images $INSTALL_DIR/

# Python AXI / Logger utilities
#mkdir -p /usr/local/lib/python3.*/dist-packages/asterisk/
cp -fr agi.py /usr/local/lib/python3.*/dist-packages/asterisk/
cp axi.py /usr/local/
cp logger_app.py /usr/local/

# AGI scripts
cp agi/*.py /var/lib/asterisk/agi-bin/
chmod -R 777 /var/lib/asterisk/
chmod +x /var/lib/asterisk/agi-bin/*.py

# Log file
cp axi.log /var/log/
chmod 777 /var/log/axi.log

# AXI systemd service
cp axi.service /etc/systemd/system/
systemctl daemon-reload
systemctl enable axi.service
systemctl restart axi.service

# ------------------------------
# 7. INSTALL MSM3500 PYTHON SENDER SCRIPT
# ------------------------------
mkdir -p $INSTALL_DIR/scripts
cp scripts/send_message.py $INSTALL_DIR/scripts/
chmod +x $INSTALL_DIR/scripts/send_message.py

# ------------------------------
# 8. CONFIGURE NGINX
# ------------------------------
cat >/etc/nginx/sites-available/MSM3500.conf <<EOF
server {
    listen 80;
    server_name _;

    root /var/www/MSM3500/public;
    index index.html;

    location /api/ {
        proxy_pass http://localhost:3000/api/;
    }
}
EOF

ln -sf /etc/nginx/sites-available/MSM3500.conf /etc/nginx/sites-enabled/MSM3500.conf
rm -f /etc/nginx/sites-enabled/default

nginx -t && systemctl restart nginx

# ------------------------------
# 9. INSTALL NODE DEPENDENCIES & START SERVICE
# ------------------------------
cd $INSTALL_DIR
npm install

# Create service
cat >/etc/systemd/system/msm3500.service <<EOF
[Unit]
Description=MSM3500 Web Backend
After=network.target rabbitmq-server.service

[Service]
WorkingDirectory=$INSTALL_DIR
ExecStart=/usr/bin/node server.js
Restart=always
User=$ASTERISK_USER
Group=$ASTERISK_GROUP
Environment=NODE_ENV=production

[Install]
WantedBy=multi-user.target
EOF

systemctl daemon-reload
systemctl enable msm3500.service
systemctl restart msm3500.service

echo "========================================="
echo " INSTALLATION COMPLETE! Visit:"
echo "     http://<server-ip>/"
echo "========================================="

