#!/usr/bin/env python3

import requests
from configparser import ConfigParser
import sys
import os
import json
#import logger_app
#from logger_app import get_logger

def init_config_parser(url):
    config = ConfigParser()
    config.read(url)
    host = config.get('Raemis_EPC_System', 'IP')
    user = config.get('Raemis_EPC_System', 'User')
    pwd = config.get('Raemis_EPC_System', 'Pass')
    return config, host, user, pwd

def init_api_endpoint(user, pwd, host, id_smsc=1):
    return f"https://{user}:{pwd}@{host}/api/smsc_message?id={id_smsc}"

def build_data(msg_lifetime='100'):
    data = {
        'to_msisdn': sys.argv[1],
        'text': sys.argv[2],
        'msg_lifetime': msg_lifetime,
        'from_msisdn': sys.argv[3],
        'msg_type': sys.argv[4],
    }
    return data

def main():
    #my_logger = get_logger()

    config, host, user, pwd = init_config_parser("/var/www/MSM3500/config.ini")
    api_endpoint = init_api_endpoint(user, pwd, host)
    data = build_data()

    try:
        r = requests.post(url=api_endpoint, data=data, verify=False)
        if '200' in str(r.status_code):
            print('%s Page Accepted By Raemis', data)
            print('Message ID %s', r.content.decode())
            print("SUCCESS")
        else:
            print('%s Page Not Accepted By Raemis', data)
            print(r.content.decode())
            print("FAILURE")
    except:
        print('Unable to connect to server %s', host)
        print("ERROR")

if __name__ == "__main__":
    main()

