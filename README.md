# PiStrip
A Raspberry Pi based power strip.

# Setup
You will need:
- A Raspberry Pi 2 + wifi dongle, 3, Zero-W, or Zero + wifi dongle
- A 4 channel relay interface (these run about $5 on Amazon)
- A 5v 2a AC-DC adapter
- A power cable
- Wiring of sufficient gague to handle mains current
- 4 outlets
- Soldering supplies
- Wire nuts
- Electrical tape/liquid electrical tape
- Jump wires
- **Enough electrical knowledge to be confident that you're not going to start a fire messing with mains current**
  
  
# Building it
I'm actually going to forego a step by step tutorial on the grounds that if you can't figure out how to do the wiring on outlets and relays then you probably have no business messing with mains current. I don't want to be responsible for someone who shouldn't be screwing with the mains burning down their house, so I'm not gonna do it. I will, however, give a few tips:
  
- If you cut open a wall wart and add a pair of lines from the power cord to it, and then replace the output cable with a couple jump wires going to pins 2 (5v) and 6 (ground) on your pi, you can get away with only having one power cord instead of one to power the Pi and one for everything else.
- The GPIO pins used for the relay interface are:
   * 2 (5v in)
   * 6 (input ground)
   * 4 (5v out)
   * 9 (ground)
   * 31, 33, 35, 37 (relay channels)

# The Software

First, for convenience sake I suggest setting a static IP on your Pi (tutorials abound, not repeating here).

Log in, navigate to the directory where you've downloaded this. Run
  sudo apt-get install apache2 mariadb-server php5 php5-mysql python-mysqldb

Open web/dbconfig.php and set the database username and password. You can set them to whatever you want. You'll never have to remember them once you're done with this process. 

Open /web/session.php and alter lines 7, 8, 20, and 25 to reflect your own username and password. Either comment out lines 3-5 or, if you prefer not to login when you're at home, alter them to match your own network.

Run:
```
  mysql -u root -p
```
When prompted use the password you specified during the mysql install.
Once in MySql, run
```
  source *path*/db.sql;
  CREATE USER '*user*'@'localhost' IDENTIFIED BY '*password*';
  GRANT select, update, delete, insert ON powerstrip.* to '*user*'@'*localhost*';
  exit
```
Remember to replace *user* and *password* in the above with the values you specified in dbconfig.php. You should now have a copy of my personal database. Now run:

```
sudo rm /var/www/html/index.html
sudo cp -r web/\* /var/www/html/
sudo cp init.py /bin
sudo cp checkSched.py /bin
sudo cp setpin.py /bin
sudo chmod +x /bin/*.py
```
Add the following lines to your crontab:

- \* * * * * checkSched.py
- @reboot init.py

Point a browser at your Pi. You should see the control interface for your power strip.

# TODO:
- Improve the scheduling interface
- Get a real authentication system instead of this hard-coded BS I made when I was in a hurry.

# Changes:

- v0.1 Orange Pi One version, unreleased
- v0.2 Initial public release.
    Ported over to the Raspberry Pi
