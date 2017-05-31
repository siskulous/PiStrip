#!/usr/bin/python
from RPi import GPIO
import sys
import MySQLdb
import datetime
def left(s, amount):
	return s[:amount]

db=MySQLdb.connect(user='webhead', 
	passwd='MonkeyBoneIsATerribleMovie', 
	db='powerstrip',
	host="localhost")


GPIO.setmode(GPIO.BCM)
pins=[6,13,19,26]
for i in pins:
	GPIO.setup(i,GPIO.OUT)
q=db.cursor()
now=datetime.datetime.now()
fullDate=str(now.strftime("%Y-%m-%d %H:%M:00"))
curtime=str(now.strftime("%H:%M:00"))
curDay=left(str(now.strftime("%A")), 3)
query="SELECT outlet, state FROM schedule WHERE firstEvent=%s OR (TIME(firstEvent)=%s AND repeat"+curDay+"=1)"
print query
print fullDate
print curtime
q.execute(query, (fullDate, curtime))
for row in q.fetchall():
	print(row)
	pin=row[0]
	state=int(row[1])
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
	gpio.init();
	gpio.setcfg(relay, gpio.OUTPUT)
	gpio.output(relay, state)
	gpio.close()
	'''
	GPIO.output(relay,state)
	query="UPDATE outlets SET currentState=%s WHERE oid=%s"
	q.execute(query, (state, pin))
	db.commit()
db.close
