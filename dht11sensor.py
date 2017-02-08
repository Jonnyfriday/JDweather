#!/usr/bin/python
import sys 
import Adafruit_DHT 
import time 
import MySQLdb 

db = MySQLdb.connect(host="localhost",    # your host, usually localhost 
                     user="root",         # your username 
                     passwd="toor",  # your password 
                     db="raspberry")        # name of the data base 
cur = db.cursor() 

sensor_args = { '11': Adafruit_DHT.DHT11, 
                '22': Adafruit_DHT.DHT22, 
                '2302': Adafruit_DHT.AM2302 } 

if len(sys.argv) == 3 and sys.argv[1] in sensor_args: 
        sensor = sensor_args[sys.argv[1]] 
        pin = sys.argv[2] 
else: 
        print 'usage: sudo python dht11.py [11|22|2302] GPIOpin#' 
        print 'example: sudo python dht11.py 11 4 - Read from an AM2302 connected to GPIO #4' 
        sys.exit(1) 

humidity, temperature = Adafruit_DHT.read_retry(sensor, pin) 


while 1: 

    if humidity is not None and temperature is not None: 
        print 'Temp={0:0.1f}*  Humidity={1:0.1f}%'.format(temperature, humidity) 
        cur.execute("INSERT INTO roomTemp (temp, humidity) VALUES (%s, %s)" % temperature, humidity) 
        db.commit() 
        time.sleep(2) 
    else: 
        print 'Failed to get reading. Try again!' 
        sys.exit(1) 
