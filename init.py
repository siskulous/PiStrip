#!/usr/bin/python
from RPi import GPIO
import MySQLdb

db=MySQLdb.connect(user='webhead', 
	passwd='MonkeyBoneIsATerribleMovie', 
	db='powerstrip',
	host="localhost")
q=db.cursor()
GPIO.setmode(GPIO.BCM)
query="SELECT pin, currentstate FROM outlets";
q.execute(query)
for row in q.fetchall():
	pin=int(row[0])
	GPIO.setup(pin,GPIO.OUT)
	GPIO.output(pin,int(row[1]))
