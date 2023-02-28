#!/usr/bin/env python3
import pika
import sys
import os

def sys_args():
    msd = (sys.argv[1])
    msg = (sys.argv[2])
    frm = (sys.argv[3])
    typ = (sys.argv[4])
    return msd, msg, frm, typ

def main():

    msd, msg, frm, typ = sys_args()

    bdy = '{"msisdn":%s, "msg":"%s", "frm":%s, "msg_type":%s}' % (msd, msg, frm, typ)

    connection = pika.BlockingConnection(
        pika.ConnectionParameters(host='localhost'))
    channel = connection.channel()

    channel.queue_declare(queue='hello')

    channel.basic_publish(exchange='', routing_key='hello', body=bdy)
    connection.close()
if __name__ == "__main__":
    main()
