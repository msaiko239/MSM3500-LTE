#importing the requests library
import requests
from configparser import ConfigParser
import sys

# getting config info from ini
config = ConfigParser()
config.read('/var/www/html/config.ini')
HOST = config.get('Raemis_EPC_System', 'IP')
USER = config.get('Raemis_EPC_System', 'User')
PASS = config.get('Raemis_EPC_System', 'Pass')

# defining the api-endpoint
API_ENDPOINT = "https://" + USER + ":" + PASS + "@" + HOST + "/api/smsc_message?id=1"

# data to be sent to api
data = {'to_msisdn':(sys.argv[1]),
        'text':(sys.argv[2]),
        'msg_lifetime':'100',
        'from_msisdn':(sys.argv[3]),
        'msg_type':(sys.argv[4])}

# sending post request and saving response as response object
r = requests.post(url = API_ENDPOINT, data = data, verify=False)

# extracting response text
pastebin_url = r.text
print (r.status_code)
if '200' in str(r.status_code):
    print('Page accepted by Raemis')
else:
    print('Page Not Accepted By Raemis')

