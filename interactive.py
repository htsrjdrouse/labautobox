import paho.mqtt.client as mqtt 
import subprocess,re
import serial,usb
import time,datetime,os
import numpy as np
import json
import operator
from adafruit_servokit import ServoKit
import sys




#$prog = array("program"=>$vvr, "drypositions"=>$drypositions, "dryrefnum"=>$dryrefnum);
def touchdry(cmd,taskjob):
  #justdry Z9.5F3000ZT0
  a = re.match('touchdry Z(.*)F(.*)ZT(.*)T(.*)', cmd)
  z = a.group(1)
  f = a.group(2)
  ztrav= a.group(3)
  t = a.group(4)
  dryrefnum = int(taskjob['dryrefnum']) + 1
  if dryrefnum == (len(taskjob['drypositions'])-1): 
      dryrefnum = 0
  taskjob['dryrefnum'] = str(dryrefnum)
  pcvdatar = json.dumps(taskjob)
  pcv = open('labbot.programtorun.json','w')
  pcv.write(pcvdatar)
  pcv.close()
  mcmd = "G1Z"+ztrav+"F"+f
  x = str(taskjob['drypositions'][int(taskjob['dryrefnum'])]['x'])
  y = str(taskjob['drypositions'][int(taskjob['dryrefnum'])]['y'])
  dser.write(mcmd.encode()+"\n".encode())
  mcmd = "G1X"+x+"Y"+y+"F"+f
  #print(mcmd)
  dser.write(mcmd.encode()+"\n".encode())
  mcmd ="G1Z"+z+"F"+f
  #print(mcmd)
  dser.write(mcmd.encode()+"\n".encode())
  print(t)
  time.sleep(float(t))  
  mcmd = "G1Z"+ztrav+"F"+f
  #print(mcmd)
  dser.write(mcmd.encode()+"\n".encode())
  upublisher("dryreftrack " + str(dryrefnum))

def snap(cmd):
  d = datetime.datetime.today()
  checktm = str(d.year)+str(d.month)+str(f'{d.day:02}')
  timestamp = time.strftime('%H%M%S')
  #snap 192.168.1.89_400_50_09302020070456_htet
  cmd  = re.sub('^snap ', '', cmd)
  (cameraip,focus,exposure,location,fname) = re.split("_",cmd)
  time.sleep(1)
  #ccmd = "mosquitto_pub -h "+cameraip+" -t 'dcam2' -m 'snap "+focus+"_"+exposure+"_"+filename+checktm+timestamp+"'"
  ccmd = "mosquitto_pub -h "+cameraip+" -t 'dcam2' -m 'snap "+focus+"_"+exposure+"_"+location+"_"+fname+timestamp+"'"
  #print(ccmd)
  os.system(ccmd)




def servoset():
 kit = ServoKit(channels=16)
 rg = [2750,2750,2750,2650,2750,2650,2650,2650]
 for i in range(0,8):
  #kit.servo[i].set_pulse_width_range(500, 2800) 
  kit.servo[i].set_pulse_width_range(800, rg[i]) 
 return kit

def servo(valves,pos,kit):
  ps ={}
  #ps['input'] = 0
  ps['input'] = [0,0,0,0,0,0,0,0]
  #ps['output'] = 75
  ps['output'] = [100,100,100,75,100,75,75,75]
  #ps['bypass'] = 30
  ps['bypass'] = [30,30,30,30,30,30,30,30]
  #ps['close'] = 160
  ps['close'] = [180,180,180,160,180,160,160,160]
  #print("just before loop")
  ct = 0
  for i in valves:
   if int(i)==1:
    #print("kit.servo["+str(ct)+"].angle = ps["+pos+"]")
    kit.servo[ct].angle = ps[pos][ct]
   ct = ct + 1





def labbotrunning(pp):
 if pp == 1:
     cmd = "mosquitto_pub  -t 'controllabbot' -m 'kill positiondisplay'" 
     os.system(cmd)
 if pp == 0:
     cmd = "mosquitto_pub  -t 'controllabbot' -m 'run positiondisplay'" 
     os.system(cmd)


def justdryparser(cmdstr,dser):
  #justdry X235.5Y51Z9.5F3000ZT0I0 
  a =re.match('^justdry X(.*)Y(.*)Z(.*)F(.*)ZT(.*)I(.*)$', cmdstr) 
  gcodecmd = 'G1Z'+a.group(5)+'F'.a.group(4)
  dser.write(gcodecmd.encode()+"\n".encode())

def tmecalc(gcodebatch):	
        #mesg = readnxjson()
        nx = open('nx.imgdataset.json')
        mesg = json.load(nx)
        nx.close()
        coordlog = readschedularjson()
        try: 
         X = coordlog['X'][len(coordlog['X'])-1]
        except:
         X = mesg['currcoord']['X']
        try:
         Y = coordlog['Y'][len(coordlog['Y'])-1]
        except:
         Y = mesg['currcoord']['Y']
        try:
         Z = coordlog['Z'][len(coordlog['Z'])-1]
        except:
         Z = mesg['currcoord']['Z']
        try:
         E = coordlog['E'][len(coordlog['E'])-1]
        except:
         E = mesg['currcoord']['E']
        tmln = []
        b = []
        tim = 0
        poscmds = []
        ct = 0
        for i in gcodebatch:
            i = re.sub("\n|\r", "", i)
            dt = {}
	    #G1 F1800.000 E1.00000
	    #here I need to have a conditional if to separate non gcodes from gcodes
            if re.match('^G1', i):
             if re.match("^.*_", i):
              cc = re.split("_", i)
              ci = cc[0]
              tt = float(cc[1])
             else:
              ci = i
              tt = 0
             i = ci
             if re.match('^.*F.*', i):
              df = re.match('^.*F(.*)$', i)
              abf = re.sub('[ |X|x|Y|y|Z|z|E|e].*', '', df.group(1))
              pf = float(abf)
              if pf > 0:
               F = pf
             if re.match('^.*[Z|X|Y|E]', i):
                dt['F'] = F
                ct = ct + 1
                dt['ct'] = ct
                pe = 0
                px = 0
                py = 0
                pz = 0
                if re.match('^.*E', i):
                  d = re.match('^.*E(.*)', i)
                  abe = re.sub('[ |X|x|Y|y|Z|z|F|f].*', '', d.group(1))
                  pe = float(abe)
                  dt['diffe'] = abs(E-pe)
                  E = pe
                  dt['E'] = pe
                if re.match('^.*X', i):
                  dx = re.match('^.*X(.*)', i)
                  abx = re.sub('[ |E|e|Y|y|Z|z|F|f].*', '', dx.group(1))
                  px = float(abx)
                  dt['diffx'] = abs(X-px)
                  X = px
                  dt['X'] = px
                if re.match('^.*Y', i):
                  dy = re.match('^.*Y(.*)', i)
                  aby = re.sub('[ |E|e|X|x|Z|z|F|f].*', '', dy.group(1))
                  py = float(aby)
                  dt['diffy'] = abs(Y-py)
                  Y = py
                  dt['Y'] = py
                if re.match('^.*Z', i):
                  dz = re.match('^.*Z(.*)', i)
                  abz = re.sub('[ |E|e|X|x|Y|y|F|f].*', '', dz.group(1))
                  pz = float(abz)
                  dt['diffz'] = abs(Z-pz)
                  Z = pz
                  dt['Z'] = pz
                dt['cmd'] = i
                comp = {}
                try: 
                  comp['diffx'] = dt['diffx']
                except:
                  pass
                try: 
                  comp['diffy'] = dt['diffy']
                except:
                  pass
                try: 
                  comp['diffz'] = dt['diffz']
                except:
                  pass
                try: 
                  comp['diffe'] = dt['diffe']
                except:
                  pass
                sorted_comp = sorted(comp.items(), key=operator.itemgetter(1))
                dt['maxdiff'] = sorted_comp[int(len(comp)-1)][1]
                if dt['F'] > 0:
                  dt['time'] = (dt['maxdiff'] / dt['F']) * 60
                else: 
                  dt['time'] = 0
                if tt > 0:
                 dt['time'] = float(tt)
                tmln.append(i+"_"+str(dt['time']))
                tim = tim + dt['time']
                poscmds.append(dt)
            else:
                tmln.append(i)
        delaytme = int(tim)+1
        return tmln



def gcodesplitter(gcr):
 coordlog = readschedularjson()
 gtba = []
 ba = []
 bba = []
 tba = []
 fl = 0
 for i in gcr:
  i = i.rstrip()
  if re.match('^G', i):
   #print(i.rstrip())
   try:
    cc = re.split('_', i)
    ci = cc[0]
    ti = cc[1]
   except:
    ti = 0
   coord = jogcoordparser(ci)
   if 'X' in coord:
    coordlog['X'].append(coord['X']) 
   if 'Y' in coord:
    coordlog['Y'].append(coord['Y']) 
   if 'Z' in coord:
    coordlog['Z'].append(coord['Z']) 
   if 'E' in coord:
    coordlog['E'].append(coord['E']) 
   writeschedularjson(coordlog)
   gtba.append(i)
   fl = 1
  else:
   fl = 0
  if fl == 1:
   bba.append(i)
  if fl == 0:
   if len(bba)>0:
    tmln = tmecalc(bba)	
    bba = []
    tba.append(tmln)
   tba.append(i)
  if i == gcr[len(gcr)-1]:
   if len(bba)>0 and re.match('^G', i):
    tmln = tmecalc(bba)	
    tba.append(tmln)
 reformatmacro = tba
 return reformatmacro

def readtaskjobjson():
  pcv = open('labbot.programtorun.json')
  pcvdata = json.load(pcv)
  pcv.close()
  return pcvdata


def writeschedularjson(dat):
  pcvdatar = json.dumps(dat)
  pcv = open('schedular.json','w')
  pcv.write(pcvdatar)
  pcv.close()

def readschedularjson():
  pcv = open('schedular.json')
  pcvdata = json.load(pcv)
  pcv.close()
  return pcvdata




def upublisher(mesg):
  aa = {}
  ts = time.gmtime()
  tts = time.strftime("%Y-%m-%d %H:%M:%S", ts)
  aa['mesg'] = mesg + ' -- ' +tts
  #cmd = "mosquitto_pub  -t 'labbot3d_1_control_track' -u smoothie -P labbot3d -d -m '"+aa['mesg']+"'" 
  cmd = "mosquitto_pub  -t 'labbot3d_track' -m '"+aa['mesg']+"'" 
  os.system(cmd) 
  '''
  if re.match('^G1.*X.*Y.*', mesg):
     ppos = coordparser(cmd)
     yy = 'X'+str(ppos['X'])+'_Y'+str(ppos['Y'])
     cmd = "mosquitto_pub  -t 'logger' -m '"+yy+"'" 
     os.system(cmd) 
  '''


def jogcoordparser(strr):
 coord = {}
 E = 0
 X = 0
 Y = 0
 Z = 0
 if re.match('^.*X|x',strr):
  px = re.match('^.*[X|x](.*)', strr)
  x = re.sub('[ |Y|y|Z|z|F|f|E|e].*', '', px.group(1))
  coord['X'] = float(x)
 if re.match('^.*Y|y',strr):
  py = re.match('^.*[Y|y](.*)', strr)
  y = re.sub('[ |X|x|Z|z|F|f|E|e].*', '', py.group(1))
  coord['Y'] = float(y)
 if re.match('^.*Z|z',strr):
  pz = re.match('^.*[Z|z](.*)', strr)
  z = re.sub('[ |X|x|Y|y|F|f|E|e].*', '', pz.group(1))
  coord['Z'] = float(z)
 if re.match('^.*E|e',strr):
  pe = re.match('^.*[E|e](.*)', strr)
  e = re.sub('[ |X|x|Y|y|F|f|].*', '', pe.group(1))
  coord['E'] = float(e)
 if re.match('^.*F|f',strr):
  pf = re.match('^.*[F|f](.*)', strr)
  f = re.sub('[ |X|x|Y|y|Z|z|].*', '', pf.group(1))
  coord['F'] = int(f)
 return coord




def coordparser(strr):
 coord = {}
 X = 0
 Y = 0
 Z = 0
 if re.match('^.*X|x',strr):
  px = re.match('^.*[X|x](.*)', strr)
  x = re.sub('[ |Y|y|Z|z|F|f|E|e].*', '', px.group(1))
  coord['X'] = float(x)
 if re.match('^.*Y|y',strr):
  py = re.match('^.*[Y|y](.*)', strr)
  y = re.sub('[ |X|x|Z|z|F|f|E|e].*', '', py.group(1))
  coord['Y'] = float(y)
 if re.match('^.*Z|z',strr):
  pz = re.match('^.*[Z|z](.*)', strr)
  z = re.sub('[ |X|x|Y|y|F|f|E|e].*', '', pz.group(1))
  coord['Z'] = float(z)
 return coord




def xyzgetposition(dser):
 dser.write(str.encode("M114\n"))
 pos = dser.readlines()
 pos = re.sub(" E.*", "", pos[0].decode().rstrip()) 
 aa = (re.split(" ", pos))
 pos = {}
 for i in aa:
  aaa = re.split(":", i)
  pos[aaa[0]] = float(aaa[1])
 return pos




def verifypos(dser,cmd):
 pos = xyzgetposition(dser)
 ppos = coordparser(cmd)
 if ppos['X'] == pos['X'] and ppos['Y'] == pos['Y'] and ppos['Z'] == pos['Z']:
     moving = 0
 else:
     moving = 1
 #print(moving)
 return moving


def gettemperature(dser):
 dser.write(b'M105\n')
 temp = dser.readlines()
 aa = (temp[len(temp)-1]).decode().rstrip()
 cc = (re.sub("ok ", "", aa))
 cmd = 'mosquitto_pub -t "blocktemp" -m "'+cc+'"'
 os.system(cmd)



# This one is for the smoothie
def getposition(dser):
 dser.write(b'M114\n')
 pos = dser.readlines()
 #[b'ok C: X:0.0000 Y:0.0000 Z:0.0000 E:0.000 \r\n']
 #pos = dser.readlines().decode()
 #['X:0.000 Y:0.000 Z:0.000 E:0.000 E0:0.0 E1:0.0 E2:0.0 E3:0.0 E4:0.0 E5:0.0 E6:0.0 E7:0.0 E8:0.0 Count 0 0 0 Machine 0.000 0.000 0.000 Bed comp 0.000\n', b'ok\n']
 lbpos = {}
 for i in pos:
     i = i.decode()
     if re.match('^.*X:.*Y:.*Z:.*E.*', i):
         bb = re.match('^.*X:(.*) Y:(.*) Z:(.*) E:(.*) .*', i)
         lbpos['X'] = float(bb.group(1))
         lbpos['Y'] = float(bb.group(2))
         lbpos['Z'] = float(bb.group(3))
         lbpos['E'] = float(bb.group(4))
 lbposdatar = json.dumps(lbpos)
 pcmd = 'X'+str(lbpos['X'])+' Y'+str(lbpos['Y'])+' Z'+str(lbpos['Z'])+' E'+str(lbpos['E'])
 cmd = 'mosquitto_pub -t "testtopic" -m "'+pcmd+'"'
 os.system(cmd)
 nx = open('nx.imgdataset.json')
 nxdata = json.load(nx)
 nx.close()
 if re.match('^.*F', nxdata['smoothielastcommand']):
     ff = re.match('^.*F(.*)', nxdata['smoothielastcommand'])
     feed = ff.group(1)
 else:
     feed = nxdata['xyjogfeed']
 nxdata['smoothielastcommand'] = 'G1X'+str(lbpos['X'])+'Y'+str(lbpos['Y'])+'Z'+str(lbpos['Z'])+'F'+feed
 nxdata['currcoord']['X'] = lbpos['X'];
 nxdata['currcoord']['Y'] = lbpos['Y'];
 nxdata['currcoord']['Z'] = lbpos['Z'];
 nxdata['currcoord']['E'] = lbpos['E'];
 nxdatar = json.dumps(nxdata)
 nx = open('nx.imgdataset.json','w')
 nx.write(nxdatar)
 nx.close()
 return pos




#Establish a connection to MQTT
def establishconnection():
      ### mqtt ###
      broker_address="localhost" 
      print("creating new instance")
      client = mqtt.Client("P1") #create new instance
      client.on_message=on_message #attach function to callback
      print("connecting to broker")
      client.connect(broker_address) #connect to broker
      print("Subscribing to topic","labbot")
      client.subscribe("labbot")
      print("ok its subscribed")
      # Continue the network loop
      client.loop_forever()
      return client





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


def getipaddr(dser):
   #print("this is called")
   resp = dser.readlines()
   dser.write(b'M587\n')
   resp = dser.readlines()
   rr = {'resp':str(resp[1])}
   #print(resp)
   duetip = open('duet.ip.json','w')
   datar = json.dumps(rr, sort_keys=True)
   duetip.write(datar)
   duetip.close()


## mqtt message handler ##
def on_message(client, userdata, message):
    cmd = str(message.payload.decode("utf-8"))
    if re.match("^G[1|28].*", cmd):
      coord = jogcoordparser(cmd)
      labbotrunning(1)
      dser.write(cmd.encode()+"\n".encode())
      labbotrunning(0)
      time.sleep(1)
      try: 
       nx = open('nx.imgdataset.json')
       nxdata = json.load(nx)
       nx.close()
       nxdata['smoothielastcommand'] = cmd
       nxdata['currcoord']['X'] = coord['X']
       nxdata['currcoord']['Y'] = coord['Y']
       nxdata['currcoord']['Z'] = coord['Z']
       nxdata['currcoord']['E'] = coord['E']
       nxdatar = json.dumps(nxdata)
       nx = open('nx.imgdataset.json','w')
       nx.write(nxdatar)
       nx.close()
      except:
       pass
    if cmd == "M114":
      getposition(dser)
    if cmd == "getduetip":
      getipaddr(dser)
    if cmd == "blueledon":
      dser.write(b'M106 P0 I1 F25000 \n')
    if cmd == "blueledoff":
      dser.write(b'M106 P0 I0 F25000 \n')
    if cmd == "M105":
      gettemperature(dser)
    if re.match('flashon.*',cmd):
      (mm, cameraip) = re.split("_", cmd)
      ccmd = "mosquitto_pub -h "+cameraip+" -t 'dcam2' -m 'flashon'"
      os.system(ccmd)
    if re.match('flashoff.*',cmd):
      (mm, cameraip) = re.split("_", cmd)
      ccmd = "mosquitto_pub -h "+cameraip+" -t 'dcam2' -m 'flashoff'"
      os.system(ccmd)
    if re.match('sg[1|2].*',cmd):
      sser.write(re.sub('^s', '', cmd).encode()+"\n".encode())
      upublisher(cmd)
    if re.match('touch.*',cmd):
      #print("touchdry called")
      #print(cmd)
      taskjob = readtaskjobjson()
      touchdry(cmd,taskjob)
    if re.match('TG1.*',cmd):
      print("calling the timed position move")
      #movetopos(dser,cmd)
      verifypos(dser,cmd)
    if cmd == "runmacro":
     try: 
      #upublisher(mesg)
      print("runmacro called")
      print("print ports")
      print(ports)
      print(ports['smoothie'])
      print(ports['syringe'])
      #dser.close()
      #sser.close()
      #runmacro(dser,kit,sser)
      #subprocess.Popen(["sudo","python3", "/var/www/html/labautobox/runmacro.py",ports['smoothie'],ports['syringe']]).pid
     except:
      pass
      #print("can not send a mqtt")
    #if cmd == "deviceconnect":
    #  dser = openport(ports['smoothie'])
    #  sser = openport(ports['syringe'])
    if re.match("valve.*", cmd):
      (v,pvalves,pos) = re.split('-', cmd)
      valves = re.split('_',pvalves) 
      servo(valves,pos,kit)
      upublisher(cmd)
    if re.match("snap.*", cmd):
      print("snap called here")
      d = datetime.datetime.today()
      checktm = str(d.year)+str(d.month)+str(f'{d.day:02}')
      timestamp = time.strftime('%H%M%S')
      print(checktm)
      (snap,location,focus,exposure) = re.split(" ",cmd)
      print(location)
      nx = open('nx.imgdataset.json')
      mesg = json.load(nx)
      nx.close()
      #ccmd = "ssh pi@192.168.1.85 raspistill -w 320 -h 240 -ex sports --nopreview --timeout 1 -o \/home\/pi\/"+checktm+timestamp+".jpg"
      ccmd = "mosquitto_pub -h "+mesg['cameraip']+" -t 'dcam2' -m 'snap "+focus+"_"+exposure+"_"+checktm+timestamp+"'"
      print(ccmd)
      os.system(ccmd)
      time.sleep(1)
      #cccmd = "scp pi@"+mesg['cameraip']+":\/home\/pi\/"+focus+"_"+exposure+"_"+checktm+timestamp+".jpg \/var\/www\/html\/labbot\/imaging\/"+location
      #print(cccmd)
      #os.system(cccmd)

#ports = whatstheports()
#dser = openport(ports['smoothie'])
#sser = openport(ports['syringe'])
#smoothie = "ACM2"
#syringe = "ACM1"

#python3 interactive.py ACM2 ACM1

smoothie = sys.argv[1]
syringe = sys.argv[2]
dser = openport(smoothie)
sser = openport(syringe)
kit = servoset()
getposition(dser)

'''
time.sleep(1)
dser.write(b'M563 P1 D1 H2\n')
time.sleep(0.5)
dser.write(b'M305 P2 R4700 T100000 B4388\n')
time.sleep(0.5)
dser.write(b'M307 H1 A240 C640 D5.5 V12\n')
time.sleep(1)
dser.write(b'M307 H2 A240 C640 D5.5 V12\n')
time.sleep(1)
'''
#runmacro(dser,aser)

client = establishconnection()


