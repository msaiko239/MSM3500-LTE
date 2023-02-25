#importing the requests library
import requests
from configparser import ConfigParser
import sys
import re
import sys
import os
import json
import logger_app
from logger_app import get_logger
import logging

def init_config_parser(url):
    # getting config info from ini
    config = ConfigParser()
    config.read(url)
    host = config.get('Raemis_EPC_System', 'IP')
    user = config.get('Raemis_EPC_System', 'User')
    pwd = config.get('Raemis_EPC_System', 'Pass')
    return config, host, user, pwd


def init_api_endpoint(user, pwd, host, id_smsc=1):
    return "https://" + user + ":" + pwd + "@" + host + "/api/smsc_message?id=%d" % (id_smsc)


def build_data(msg_lifetime = '100'):
    # data to be sent to api
    data = {'to_msisdn':(sys.argv[1]),
            'text':(sys.argv[2]),
            'msg_lifetime':msg_lifetime,
            'from_msisdn':(sys.argv[3]),
            'msg_type':(sys.argv[4])}
    return data


def main():

    #TODO
    my_logger = get_logger()

    #Init config parser
    config, host, user, pwd = init_config_parser("/var/www/html/config.ini")

    #Defining the api endpoint
    api_endpoint = init_api_endpoint(user, pwd, host)

    #Build data
    data = build_data()

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
