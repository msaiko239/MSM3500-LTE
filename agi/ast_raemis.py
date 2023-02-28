#!/usr/bin/env python3

import pika
import sys
import os
import asterisk
import asterisk.agi
from asterisk.agi import *
import re


def get_ast_agi():
    agi = AGI()
    pin = agi.env['agi_extension']
    msg = agi.env['agi_calleridname']
    frm = agi.env['agi_callerid']
    return pin, msg, frm

def main():

    #Defining variables from Asterisk AGI
    pin, msg, frm = get_ast_agi()

    #creating the body to be sent for MQ
    bdy = '{"msisdn":%s, "msg":"%s", "frm":%s}' % (pin, msg, frm)

    connection = pika.BlockingConnection(
        pika.ConnectionParameters(host='localhost'))
    channel = connection.channel()

    channel.queue_declare(queue='hello')

    channel.basic_publish(exchange='', routing_key='hello', body=bdy)
    connection.close()

if __name__ == "__main__":
    main()
