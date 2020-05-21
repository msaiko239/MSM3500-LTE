# MSM3500-LTE
Multi System Messaging build for LTE Integration to Druid EPC
This system is built to integrate Ubuntu to Druid EPC for integtration to text messaging to an LTE device. The system uses asterisk agi to convert the incomming SIP message to an HTTP request to Druid which then send the message to your User Device. 

# Prerequisites

  Asterisk Version 14 or higher

# Installation 

This document assumes you have knowledge of install the prerequsites.

Install Asterisk - https://wiki.asterisk.org/wiki/display/AST/Installing+Asterisk
  Please see installing Asterisk from source or any other installtion you would like.

    sudo apt-get update
    
    git clone https://github.com/msaiko239/MSM3500-LTE.git

    cd MSM3500-LTE

    sudo ./install.sh

This will download Python Version 3.6 if you would like a newer version please edit the install.sh file accordingly

This will install php and all necessary requirements. 

This will copy all the contents of the repo to your local server and create all directorys and change permissions needed.

# Testing Integration
To test the integration to your server navigate to http://"your server ip"/config.php

Enter the IP of your Druid Raemis server and hit update ini.

from the cli of your server enter the command

    python3 /var/lib/asterisk/agi-bin/test_raemis.py '<phone-you-want-to-send-to>' '<Message-Text>' '<from-number>' '0'
    
Example

    python3 /var/lib/asterisk/agi-bin/test_raemis.py '1234' 'Hello this is a test' '4321' '0'

The 0 at the end is the type of message 0 meaning text, Druid has more info in their API documentation
    
