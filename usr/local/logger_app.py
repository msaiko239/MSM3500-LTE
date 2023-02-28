#!/usr/bin/env python3

import sys
import logging
from logging.handlers import TimedRotatingFileHandler

FORMATTER = logging.Formatter('%(asctime)s - %(name)s(%(levelname)-1s) - %(message)s')
LOG_FILE = '/var/log/axi.log'

def get_console_handler():
    console_handler = logging.StreamHandler(sys.stdout)
    console_handler.setFormatter(FORMATTER)
    return console_handler

def get_file_handler():
    file_handler = TimedRotatingFileHandler(LOG_FILE, when='midnight')
    file_handler.setFormatter(FORMATTER)
    return file_handler

def get_logger():
    logger = logging.getLogger('axi')
    logger.setLevel(logging.DEBUG) # better to have too much log than not enough
    logger.addHandler(get_console_handler())
    logger.addHandler(get_file_handler())
    # with this pattern, it's rarely necessary to propagate the error up to parent
    logger.propagate = False
    return logger
