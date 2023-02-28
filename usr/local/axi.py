#!/usr/bin/env python3
#importing the requests library
import requests
from configparser import ConfigParser
import pika
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



def main():

    #TODO
    my_logger = get_logger()

    #Init config parser
    config, host, user, pwd = init_config_parser("/var/www/html/config.ini")

    #Defining the api endpoint
    api_endpoint = init_api_endpoint(user, pwd, host)

    connection = pika.BlockingConnection(pika.ConnectionParameters(host='localhost'))
    channel = connection.channel()

    channel.queue_declare(queue='hello')

    def callback(ch, method, properties, body):
        data2 = body.decode()
        res = json.loads(data2)
        print(" [x] Received %r" % data2)

        def build_data(msg_lifetime = '100', msg_type = '0'):
            # data to be sent to api
            data = {'to_msisdn':res['msisdn'],
                    'text':res['msg'],
                    'msg_lifetime':msg_lifetime,
                    'from_msisdn':res['frm'],
                    'msg_type':msg_type}
            return data

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

    channel.basic_consume(queue='hello', on_message_callback=callback, auto_ack=True)

    print(' [*] Waiting for messages. To exit press CTRL+C')
    channel.start_consuming()

if __name__ == '__main__':
    try:
        main()
    except KeyboardInterrupt:
        print('Interrupted')
        try:
            sys.exit(0)
        except SystemExit:
            os._exit(0)
