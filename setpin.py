#!/usr/bin/env python
from RPi import GPIO
import sys
import MySQLdb
db=MySQLdb.connect(user='webhead', 
	passwd='MonkeyBoneIsATerribleMovie', 
	db='powerstrip',
	host="localhost")

GPIO.setmode(GPIO.BCM)
state=int(sys.argv[2])
pin= int(sys.argv[1])
if pin == 1:
	relay=6
elif pin == 2:
	relay=13
elif pin == 3:
	relay=19
elif pin == 4:
	relay=26
else:
	print "Invalid relay"
	sys.exit()
'''
gpio.init()
gpio.setcfg(relay, gpio.OUTPUT)
gpio.output(relay, state)
'''
GPIO.setup(relay,GPIO.OUT)
GPIO.output(relay,state)
q=db.cursor()
query="UPDATE outlets SET currentState=%s WHERE oid=%s"
q.execute(query, (state, pin))
db.commit()
db.close