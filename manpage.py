#!/usr/bin/env python3

import re
import logging
import logging.handlers
import configparser
import sys
import asterisk
import asterisk.agi
from asterisk.agi import *
import os
import sys
import requests

config = configparser.ConfigParser()
config.read('/var/www/html/config.ini')
LOG_LEVEL = logging.info('LOGGING', 'level')

# Initialize logging
LOGGER = logging.getLogger('axi')
LOGGER.setLevel(logging.INFO)
formatter = logging.Formatter('|%(asctime)s|%(levelname)-8s|%(name)s|%(message)s')
log_file = logging.handlers.TimedRotatingFileHandler('/var/log/axi/input.csv', when='midnight', backupCount=7)
log_file.setLevel(logging.INFO)
log_file.setFormatter(formatter)
LOGGER.addHandler(log_file)

# Only print to console if at DEBUG level
if LOG_LEVEL == 'DEBUG':
    log_console = logging.StreamHandler()
    log_console.setLevel(logging.INFO)
    log_console.formatter(formatter)
    LOGGER.addHandler(log_console)

HOST = config['Raemis_EPC_System']['IP']
USER = config['Raemis_EPC_System']['User']
PASS = config['Raemis_EPC_System']['Pass']

# defining the api-endpoint
API_ENDPOINT = "https://" + USER + ":" + PASS + "@" + HOST + "/api/smsc_message?id=1"

# data to be sent to api
data = {'to_msisdn':(sys.argv[1]),
        'text':(sys.argv[2]),
        'from_msisdn':(sys.argv[3]),
        'msg_lifetime':'10'}


data2 = {'to_msisdn':(sys.argv[1]),
        'text':(sys.argv[2]),
        'from':'manual page',
        'msg_lifetime':'10'}

# sending post request and saving response as response object
r = requests.post(url = API_ENDPOINT, data = data, verify=False)

# extracting response text
#pastebin_url = r.text
if '200' in str(r.status_code):
    LOGGER.info('%s Page Accepted By Raemis', data2)
else:
   LOGGER.info('%s Page Not Accepted By Raemis', data2)
