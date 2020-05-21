#importing the requests library
import requests
import sys

# defining the api-endpoint
API_ENDPOINT = "http://raemis:password@192.168.100.2/api/smsc_message?id=1"

# data to be sent to api
data = {'to_msisdn':(sys.argv[1]),
        'text':(sys.argv[2]),
        'msg_lifetime':'100',
        'from_msisdn':(sys.argv[3]),
        'msg_type':(sys.argv[4])}

# sending post request and saving response as response object
r = requests.post(url = API_ENDPOINT, data = data)

# extracting response text
pastebin_url = r.text
if '200' in str(r.status_code):
    print('Page accepted by Raemis')
