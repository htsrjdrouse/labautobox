import paho.mqtt.client as mqtt 
import subprocess,re
import serial,usb
import time,datetime,os
import numpy as np
import json
import struct
import sys
import psutil



def openmonitorjson():
 nx = open('monitor.json')
 dat = json.load(nx)
 nx.close()
 return(dat)


def writemonitorjson(dat):
   #nx = open('monitor.json')
   #nxdata = json.load(nx)
   #nx.close()
   #print(dat)
   mjson = open('monitor.json','w')
   #print(mm)
   datar = json.dumps(dat, sort_keys=True)
   mjson.write(datar)
   mjson.close()
   return dat



#Establish a connection to MQTT
def establishconnection():
      ### mqtt ###
      broker_address="localhost" 
      print("creating new instance")
      client = mqtt.Client("P32") #create new instance
      client.on_message=on_message #attach function to callback
      print("connecting to broker")
      client.connect(broker_address) #connect to broker
      print("Subscribing to topic","labbot3d_track")
      client.subscribe("labbot3d_track")
      print("ok its subscribed")
      # Continue the network loop
      client.loop_forever()
      return client


## mqtt message handler ##
def on_message(client, userdata, message):
    #print("message received")
    cmd = str(message.payload.decode("utf-8"))
    cmd = re.sub(' --.*', '', cmd)
    if re.match("^sg.*",cmd):
     dat = openmonitorjson()
     #print("dat")
     #print(dat)
     #print("syringe section called")
     aa = re.match('^sg1e(.*)s(.*)a(.*)$', cmd)
     #print(aa.group(1))
     dat['syringe']['microliter'] = aa.group(1)
     dat['syringe']['syringespeed'] = aa.group(2)
     dat['syringe']['syringeacceleration'] = re.sub('_.*', '', aa.group(3))
     #print(dat)
     dat = writemonitorjson(dat)
    if re.match("^valve.*",cmd):
     dat = openmonitorjson()
     aa = re.match("^valve-(.*)-(.*)$", cmd)
     dat['valve']['tiplist'] =  re.split("_", aa.group(1))
     dat['valve']['valvepos'] = aa.group(2)
     dat = writemonitorjson(dat)
    if re.match("^dryreftrack.*",cmd):
     dat = openmonitorjson()
     aa = re.match('^dryreftrack (.*)$', cmd)
     dat['dryrefnum'] = aa.group(1)
     dat = writemonitorjson(dat)


'''
nx = open('monitor.json')
dat = json.load(nx)
nx.close()
print(dat['syringe']['microliter'])
print(dat)
'''
client = establishconnection()


