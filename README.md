# MSM3500-LTE
Multi System Messaging build for LTE Integration to Druid EPC
This system is built to integrate Ubuntu to Druid EPC for integtration to text messaging to an LTE device. The system uses asterisk agi to convert the incomming SIP message to an HTTP request to Druid which then send the message to your User Device. 

Prerequisites
  Asterisk Version 14 or higher
  PHP 7.X or higher
  Python3
  Asterisk Pyst2

# Installation 

cd to MSM3500-LTE

run the install.sh file 

This should copy all the contents of the repo to your local server and create all directorys and change permissions needed.

# Testing Integration
To test the integration to your server navigate to http://<your server ip>/configraemis.php

Enter the IP of your Druid Raemis server and hit update ini.

from the cli of your server enter the command

    python3 /var/lib/asterisk/agi-bin/test_raemis.py '<phone-you-want-to-send-to>' '<Message-Text>' 'from-number' '0'
    
    
