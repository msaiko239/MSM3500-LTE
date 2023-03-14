# MSM3500-LTE
Multi System Messaging build for LTE Integration to Druid EPC
This system is built to integrate Ubuntu to Druid EPC for integtration to text messaging to an LTE device. The system uses asterisk agi to convert the incomming SIP message to an HTTP request to Druid which then send the message to your User Device. 

This program utilizes Asterisk for communication and application function, understanding of Asterisk is required for configuration.

# Prerequisites

Ubuntu 20.04 or better LTS server
4GB RAM | 100GB HD | 2 CPU

Git `apt install git`

# Installation 

    sudo apt-get update
    
    sudo apt upgrade
    
    git clone https://github.com/msaiko239/MSM3500-LTE.git /tmp/MSM3500-LTE

    cd /tmp/MSM3500-LTE
    
    sudo chmod 777 install.sh

    sudo ./install.sh

This will download Python Version 3 if you would like a different version please edit the install.sh file accordingly

This will install php and all necessary requirements. 

This will copy all the contents of the repo to your local server and create all directorys and change permissions needed.

During installation an Asterisk user 8888 with password 8888 is created for testing, you can use any softphone to test registration. A Trunk for the Nursecall system is also created and you will want to edit the file /etc/asterisk/pjsip.conf to match your needs.

Dial rules are also created in /etc/asterisk/extensions.conf for testing. From a softphone you can dial 7777 to test that the agi module and script are working properly. Nursecall dial plans are also created and may need to be adjusted to fit your current needs. 

# Testing Integration
To test the integration to your server navigate to http://"your server ip"/config.php

Enter the IP of your Druid Raemis server and hit update ini.

from the cli of your server enter the command

    python3 /var/lib/asterisk/agi-bin/send.py '<phone-you-want-to-send-to>' '<Message-Text>' '<from-number>' '0'
    
Example

    python3 /var/lib/asterisk/agi-bin/send.py '1234' 'Hello this is a test' '4321' '0'

The 0 at the end is the type of message 0 meaning text, Druid has more info in their API documentation

You can also run a load test to see how many messages each system can handle before a failure. 
    
    python3 /var/lib/asterisk/agi-bin/loadtest.py '1234' '4321' '0'

'1234' is reciever '4321' is the sender address and '0' is the message type

# Connecting to Raemis
on the configure interface you will have to enter you core

IP :

User : the user for acccessing the API

Password : This is the password set in Raemis for the API user. Make sure you have not used the charecters ?{}|&~![()^"
    
