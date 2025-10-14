#!/bin/bash

CHAT_ID=-1001247003855
TOKEN=765334888:AAFylkPALh8G5vquKnBXuuDf0Z6VjOvTWO8

curl -s "https://api.telegram.org/bot$TOKEN/sendMessage?chat_id=$CHAT_ID" --data-urlencode "text=[pkl.if.unram.ac.id] $1"
