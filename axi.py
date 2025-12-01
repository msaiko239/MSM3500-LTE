#!/usr/bin/env python3
import pika
import json
import io
import pycurl
import logging
import sys
import os
from configparser import ConfigParser
import time

# ----------------------
# Logger setup
# ----------------------
LOG_FILE = "/var/log/axi.log"
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s [%(levelname)s] %(message)s',
    handlers=[
        logging.FileHandler(LOG_FILE),
        logging.StreamHandler(sys.stdout)
    ]
)
logger = logging.getLogger("RaemisConsumer")

# ----------------------
# INI Config functions
# ----------------------
def load_config(path="/var/www/MSM3500/config.ini"):
    config = ConfigParser()
    if not os.path.exists(path):
        logger.error(f"Config file not found: {path}")
        sys.exit(1)
    config.read(path)
    try:
        host = config.get('Raemis_EPC_System', 'IP')
        user = config.get('Raemis_EPC_System', 'User')
        pwd  = config.get('Raemis_EPC_System', 'Pass')
    except Exception as e:
        logger.error(f"Failed to read config: {e}")
        sys.exit(1)
    return user, pwd, host

# ----------------------
# Send to Raemis via pycurl
# ----------------------
def send_to_raemis(user, pwd, host, input_data, msg_lifetime='100', msg_type='0', id_smsc=1):
    try:
        data_dict = {
            'to_msisdn': input_data['msisdn'],
            'text': input_data['msg'],
            'msg_lifetime': msg_lifetime,
            'from_msisdn': input_data['frm'],
            'msg_type': msg_type
        }
    except KeyError as e:
        logger.warning(f"Invalid message data, missing key: {e}")
        return False

    url = f"https://{user}:{pwd}@{host}/api/smsc_message?id={id_smsc}"
    post_fields = '&'.join(f"{k}={v}" for k, v in data_dict.items())

    buffer = io.BytesIO()
    c = pycurl.Curl()
    c.setopt(c.URL, url)
    c.setopt(c.POST, 1)
    c.setopt(c.POSTFIELDS, post_fields)
    c.setopt(c.WRITEDATA, buffer)
    c.setopt(c.SSL_VERIFYPEER, 0)
    c.setopt(c.SSL_VERIFYHOST, 0)

    try:
        c.perform()
        status_code = c.getinfo(pycurl.RESPONSE_CODE)
        response = buffer.getvalue().decode('utf-8')
        c.close()
    except pycurl.error as e:
        logger.error(f"Failed to send API request: {e}")
        return False

    if status_code == 200:
        logger.info(f"Message sent successfully to Raemis: {input_data}")
        return True
    else:
        logger.warning(f"Failed to send message. HTTP {status_code}: {response}")
        return False

# ----------------------
# RabbitMQ Consumer
# ----------------------
def main():
    user, pwd, host = load_config()

    while True:
        try:
            connection = pika.BlockingConnection(pika.ConnectionParameters(host='localhost'))
            channel = connection.channel()
            channel.queue_declare(queue='hello', durable=False)

            def callback(ch, method, properties, body):
                try:
                    msg_data = json.loads(body.decode())
                except json.JSONDecodeError:
                    logger.warning(f"Invalid JSON received: {body}")
                    return

                success = send_to_raemis(user, pwd, host, msg_data)
                if success:
                    ch.basic_ack(delivery_tag=method.delivery_tag)

            channel.basic_consume(queue='hello', on_message_callback=callback, auto_ack=False)

            logger.info("Waiting for messages. To exit press CTRL+C")
            channel.start_consuming()
        except pika.exceptions.AMQPConnectionError as e:
            logger.error(f"RabbitMQ connection failed: {e}, retrying in 5s")
            time.sleep(5)
        except Exception as e:
            logger.error(f"Unexpected exception: {e}, retrying in 5s")
            time.sleep(5)

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        logger.info("Consumer interrupted and stopped.")
        sys.exit(0)

