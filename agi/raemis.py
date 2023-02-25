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
import logger_app
from logger_app import get_logger

def init_config_parser(url):
    # getting config info from ini
    config = ConfigParser()
    config.read(url)
    host = config.get('Raemis_EPC_System', 'IP')
    user = config.get('Raemis_EPC_System', 'User')
    pwd = config.get('Raemis_EPC_System', 'Pass')
    return config, host, user, pwd


def get_ast_agi ():
    agi = AGI()
    pin = agi.env['agi_extension']
    msg = agi.env['agi_calleridname']
    frm = agi.env['agi_callerid']
    data = {'to_msisdn':pin,
            'text':msg,
            'from_msisdn':frm,
            'msg_lifetime':'100'}
    return data

def init_api_endpoint(user, pwd, host, id_smsc=1):
    return "https://" + user + ":" + pwd + "@" + host + "/api/smsc_message?id=%d" % (id_smsc)

#def build_data(pin, msg, frm, msg_lifetime = '100'):
#    data = {'to_msisdn':pin,
#            'text':msg,
#            'from_msisdn':frm,
#            'msg_lifetime':msg_lifetime}
#    return data

def main():

    #TODO
    my_logger = get_logger(logger_app)

    #Init config parser
    config, host, user, pwd = init_config_parser("/var/www/html/config.ini")

    #Defining the api endpoint
    api_endpoint = init_api_endpoint(user, pwd, host)

    #Build data
    data = get_ast_agi()

    # sending post request and saving response as response object
    try:
        r = requests.post(url = api_endpoint, data = data, verify=False)
        if '200' in str(r.status_code):
            disp = '%s Page Accepted By Raemis'
            my_logger.info(disp, data)
            msg_id = 'Message ID %s'
            my_logger.info(msg_id, r.content.decode())
        else:
            disp = '%s Page Not Accepted By Raemis'
            my_logger.warning(disp, data)
            my_logger.warning(r.content.decode())

    except:
        con = 'Unable to connect to server %s'
        my_logger.warning(con, host)

if __name__ == "__main__":
    main()
