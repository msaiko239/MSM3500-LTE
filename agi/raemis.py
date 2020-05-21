#!/usr/bin/env python3

import re
import logging
import logging.handlers
from configparser import ConfigParser
import sys
import asterisk
import asterisk.agi
from asterisk.agi import *
import os
import sys
import requests

config = ConfigParser()
config.read('/var/www/html/configraemis.ini')
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

HOST = config.get('Raemis_EPC_System', 'IP')
agi = AGI()

pin = agi.env['agi_extension']
msg = agi.env['agi_calleridname']
frm = agi.env['agi_callerid']

# defining the api-endpoint
API_ENDPOINT = "http://raemis:password@" + HOST + "/api/smsc_message?id=1"

# data to be sent to api
data = {'to_msisdn':pin,
        'text':msg,
        'from_msisdn':frm,
        'msg_lifetime':'10'}

# sending post request and saving response as response object
r = requests.post(url = API_ENDPOINT, data = data)

# extracting response text
#pastebin_url = r.text
if '200' in str(r.status_code):
    LOGGER.info('Page Accepted By Raemis')
else:
   LOGGER.info('Page Not Accepted By Raemis')
