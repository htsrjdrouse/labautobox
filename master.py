import paho.mqtt.client as mqtt 
import subprocess,re
import serial,usb
import time,datetime,os
import numpy as np
import json
import struct
import sys
import psutil



def whatstheports():
 output = str(subprocess.check_output("python3 -m serial.tools.list_ports -v", shell=True))
 oo = re.split('/dev', output)
 ports = {}
 for i in oo:
    if re.match('^.*Smoothie.*', i):
        port = re.match('^.*tty(.*) .*', i)
        ports['smoothie'] = re.split(' ', port.group(1))[0]
    if re.match('^.*Arduino Micro.*', i):
        port = re.match('^.*tty(.*) .*', i)
        #ports['microfluidics'] = re.split(' ',port.group(1))[0]
        pport = re.split(' ', port.group(1))[0]
        #print(pport)
        ser = openport(pport)
        ser.write(b"info\n")
        time.sleep(1)
        a = ser.readlines()
        b = str((a[0].decode()))
        #print(b)
        if re.match("multisteppe.*",b):
            ports['syringe'] = pport
        if re.match("wash_dry_pcv_electrocaloric_kill_stepper_valv.*", b):
            ports['microfluidics'] = pport
        ser.close()
 return ports


def openport(prt):
  try:
   ser = serial.Serial("/dev/tty"+prt, 115200, timeout=0.2)
   time.sleep(0.5)
  except:
   print("its not connecting")
  return ser





def killproc(script):
 process = subprocess.Popen("ps aux | grep "+script,shell=True,stdout=subprocess.PIPE)
 stdout_list = process.communicate()[0].decode()
 aa =(stdout_list.split('\n'))
 for i in aa:
  try: 
   pid = int(re.split("\s+", i)[1])
   process = psutil.Process(int(pid))
   process.kill()
  except:
   pass



#Establish a connection to MQTT
def establishconnection():
      ### mqtt ###
      broker_address="localhost" 
      print("creating new instance")
      client = mqtt.Client("P2") #create new instance
      client.on_message=on_message #attach function to callback
      print("connecting to broker")
      client.connect(broker_address) #connect to broker
      print("Subscribing to topic","controllabbot")
      client.subscribe("controllabbot")
      print("ok its subscribed")
      # Continue the network loop
      client.loop_forever()
      return client



## mqtt message handler ##
def on_message(client, userdata, message):
    print("message received")
    cmd = str(message.payload.decode("utf-8"))
    if cmd == "turnon":
      print("turning on ... ")
      #subprocess.Popen(["sudo","python3", "/home/pi/labbot/microflsubscriber.py"]).pid
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/microflsub.py"]).pid
      time.sleep(0.5)
      #subprocess.Popen(["sudo","python3", "/home/pi/labbot/subscriber.py"]).pid
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/interactive.py",ports['smoothie'],ports['syringe']]).pid
      time.sleep(0.5)
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/monitor.py"]).pid
      time.sleep(0.5)
      #subprocess.Popen(["sudo","python3", "/home/pi/labbot/positiondisplay.py"]).pid
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/positiondisplay.py"]).pid
      time.sleep(0.5)
      #subprocess.Popen(["sudo","python3", "/home/pi/labbot/leveldisplay.py"]).pid
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/leveldisplay.py"]).pid
      time.sleep(0.5)
      #subprocess.Popen(["sudo","python3", "/home/pi/labbot/temperaturedisplay.py"]).pid
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/temperaturedisplay.py"]).pid
    if re.match("^turnoff.*", cmd):
      try:
       killproc('runmacro.py')
      except:
       pass
      killproc('interactive.py')
      print("turning off ... ")
      time.sleep(0.5)
      killproc('microflsub.py')
      time.sleep(0.5)
      killproc('monitor.py')
      time.sleep(0.5)
      killproc('positiondisplay.py')
      time.sleep(0.5)
      killproc('leveldisplay.py')
      time.sleep(0.5)
      killproc('temperaturedisplay.py')
    if cmd == "restart":
      killproc('interactive.py')
      time.sleep(1)
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/interactive.py",ports['smoothie'],ports['syringe']]).pid
    if cmd == "kill positiondisplay":
      killproc('positiondisplay.py')
    if cmd == "run positiondisplay":
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/positiondisplay.py"]).pid
    if cmd == "kill leveldisplay":
      killproc('leveldisplay.py')
    if cmd == "run leveldisplay":
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/leveldisplay.py"]).pid
    if cmd == "kill temperaturedisplay":
      killproc('temperaturedisplay.py')
    if cmd == "run temperaturedisplay":
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/temperaturedisplay.py"]).pid
    if cmd == "run interactive":
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/interactive.py",ports['smoothie'],ports['syringe']]).pid
    if cmd == "run runmacro":
      print("run macro")
      killproc('interactive.py')
      time.sleep(1)
      print("sudo python3 /var/www/html/labautobox/runmacro.py "+ports['smoothie']+" "+ports['syringe'])
      subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/runmacro.py",ports['smoothie'],ports['syringe']]).pid



ports = whatstheports()
client = establishconnection()



