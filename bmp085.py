#!/usr/bin/python

import Adafruit_BMP.BMP085 as BMP085 # Imports the BMP library
import MySQLdb
db=MySQLdb.connect(host="localhost",user="root",passwd="toor",db="raspberry",port=int(3306))
sql="Insert Into bmp180(temp2, pressure) Values(%s, %s);"
sensor = BMP085.BMP085()
temp2 = format(sensor.read_temperature()) # Temperature in Celcius
pressure = format(sensor.read_pressure()) # The local pressure
altitude = format(sensor.read_altitude()) # The current altitude
#sealevel pressure = format(sensor.read_sealevel_pressure()) #
cursor=db.cursor()
cursor.execute(sql, (temp2, pressure))
db.commit()
