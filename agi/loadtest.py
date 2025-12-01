import time
import sys
import os
import pika

# number of seconds to run the loop
num = input("# of seconds you want to run the test for: ")
x = int(num)

start_time = time.time()

def sys_args():
    msd = (sys.argv[1])
    msg = 'message - '
    frm = (sys.argv[2])
    typ = (sys.argv[3])
    return msd, msg, frm, typ

# run the loop
for i in range(100000000000):
    print(i)
    int = i
#    os.system("sudo python3 /var/lib/asterisk/agi-bin/send.py '284836' 'message -%s' '4321' '0'"%(int))
    msd, msg, frm, typ = sys_args()


    bdy = '{"msisdn":%s, "msg":"%s %s", "frm":%s, "msg_type":%s}' % (msd, msg, int, frm, typ)

    connection = pika.BlockingConnection(
        pika.ConnectionParameters(host='localhost'))
    channel = connection.channel()

    channel.queue_declare(queue='hello')

    channel.basic_publish(exchange='', routing_key='hello', body=bdy)
    connection.close()

    if time.time() - start_time > x:
        break

print("Loop finished after", time.time() - start_time, "seconds")
