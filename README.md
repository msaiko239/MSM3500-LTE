# 📡 MSM3500 – Unified Messaging & System Management Interface

## MSM3500 is a modernized web interface that integrates:

A Node.js backend API

A responsive HTML/Bootstrap/JS frontend

Asterisk (non-root service)

RabbitMQ message queuing

The AXI Python message processor

A complete installation and deployment script

System status dashboards (Asterisk / AXI / RabbitMQ)

Configuration editing via API (config.ini)

Real-time subscriber lookup + paging system

This project replaces the legacy PHP interface with a modern, component-based, service-oriented architecture.

## ✨ Features
✔ Modern Web UI

Fully redesigned with Bootstrap 5

Persistent sidebar with icons

Mobile-friendly, clean layout

Hub-and-spoke style home page

✔ Node.js Backend API

/api/config — read/write config.ini

/api/subscribers — pull live subscriber list

/api/page — send messages via Asterisk & RabbitMQ

/api/service/:name — query systemd service status

/api/logs — AXI & Asterisk logs

✔ Python AXI Worker

Reads from RabbitMQ (queue: hello)

Parses messages & forwards to Raemis SMSC API

Structured logging to /var/log/axi.log

✔ Asterisk Integration

Installed from source

Runs as non-root (asterisk:asterisk)

AGI scripts installed under /var/lib/asterisk/agi-bin/

Systemd service enabled automatically

✔ One-Command Installer

The provided install.sh script:

Installs all OS dependencies

Installs Node.js

Installs & compiles Asterisk 22

Installs RabbitMQ

Installs Python workers

Deploys MSM3500 app

Configures NGINX reverse proxy

Sets up systemd services (msm3500.service, axi.service)

## 🗂 Project Structure
```
MSM3500/
│
├── public/               # Frontend HTML/CSS/JS
│   ├── index.html
│   ├── config.html
│   ├── service.html
│   ├── sendpage.html
│   ├── css/style.css
│   ├── js/
│   │   ├── sidebar.js
│   │   ├── config.js
│   │   ├── service.js
│   │   └── sendpage.js
│   └── images/
│
├── routes/               # Node API routes
│   ├── config.js
│   ├── subscribers.js
│   ├── page.js
│   ├── service.js
│   └── logs.js
│
├── scripts/
│   └── send_message.py   # Paging script
│
├── server.js             # Node backend
├── config.ini            # System configuration
├── axi.py                # AXI RabbitMQ worker
├── logger_app.py         # Rotating logging utility
├── axi.service           # Systemd service (AXI)
│
├── install.sh            # Full installer script
└── README.md
```

## 🚀 Installation

```
git clone https://github.com/msaiko239/MSM3500-LTE.git

cd MSM3500

sudo bash install.sh
```

This will install:

Node.js + backend service

Asterisk 22 (source-compiled)

RabbitMQ server

Python dependencies + AXI worker

NGINX reverse proxy

MSM3500 web UI

All systemd services

33 🌐 Access the UI

Once installation completes:

`http://<server-ip>/`

🛠 API Endpoints
Endpoint	Description
GET /api/status	Health check
GET /api/config	Read config.ini
POST /api/config	Update config.ini
GET /api/subscribers	Pull staff list from Raemis EPC
POST /api/page	Send message
GET /api/service/:name	Check systemd service status
GET /api/logs	Retrieve logs

## 📧 Sending Messages (Paging)

The Node API posts messages to the Python AXI worker, which:

Reads config from config.ini

Connects to Raemis EPC

Logs results to /var/log/axi.log

Runs continuously as a systemd service

## 🔧 Systemd Services
Service	Purpose
msm3500.service	Node.js backend
axi.service	Python AXI worker
asterisk.service	PJSIP + AGI paging
rabbitmq-server.service	Message queue

To check status:
```
systemctl status msm3500
systemctl status axi
systemctl status asterisk
systemctl status rabbitmq-server
```

## 📨 Sending a Test Page (Manual CLI Test)

To verify the system can communicate with your Raemis core, run:

`python3 /var/lib/asterisk/agi-bin/send.py '<to-number>' '<message-text>' '<from-number>' '0'`

Example:
`python3 /var/lib/asterisk/agi-bin/send.py '1234' 'Hello this is a test' '4321' '0'`


1234 → MSISDN receiving the message

Hello this is a test → Message text

4321 → From-address

0 → Message type

0 means text.
Raemis supports more message types — see their API documentation.

## 📈 Load Testing Messaging Throughput

A load test script is included:

`python3 /var/lib/asterisk/agi-bin/loadtest.py '1234' '4321' '0'`


This sends repeated messages to measure Raemis paging performance.

## 🔌 Connecting to Raemis

Inside the web UI at Configure Interface, enter:

Field	Description
IP	IP address of your Raemis core
User	API username configured in Raemis
Password	API password for the Raemis API user

After saving, MSM3500 will automatically use this information for:

Subscriber lookup

Paging messages

AXI processing

UI configuration

## 🔐 Security Notes

Asterisk runs as its own non-root user

Node backend runs as the asterisk user

All AGI scripts are restricted to Asterisk operations

NGINX handles public access; Node is private on port 3000

Config file permissions are limited

## 🧩 Future Enhancements

Docker deployment option

Metrics dashboard (Prometheus/Grafana)

Authentication for the UI

Live WebSocket service status

## 🤝 Contributing

Pull requests are welcome.
Please open an issue before submitting major architecture changes.

## 📜 License

MIT License
© 2024–2025 MSM3500
