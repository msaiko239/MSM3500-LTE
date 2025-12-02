#!/usr/bin/env python3

import pika
import sys
import os
import asterisk
import asterisk.agi
from asterisk.agi import *
import json

def get_ast_agi():
    agi = AGI()
    pin = agi.env['agi_extension']
    msg = agi.env['agi_calleridname']
    frm = agi.env['agi_callerid']
    return pin, msg, frm

def main():

    pin, msg, frm = get_ast_agi()

    # Build a safe JSON dictionary
    payload = {
        "msisdn": pin,
        "msg": msg,
        "frm": frm   # this will be a string safely encoded
    }

    # Convert to JSON safely
    bdy = json.dumps(payload)

    connection = pika.BlockingConnection(
        pika.ConnectionParameters(host='localhost'))
    channel = connection.channel()

    channel.queue_declare(queue='hello')

    channel.basic_publish(exchange='', routing_key='hello', body=bdy)
    connection.close()

if __name__ == "__main__":
    main()
