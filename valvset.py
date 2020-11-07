from adafruit_servokit import ServoKit
import serial,usb



def servoset():
 kit = ServoKit(channels=16)
 rg = [2650,2750,2650,2650,2650,2650,2650,2650]
 for i in range(0,8):
  #kit.servo[i].set_pulse_width_range(500, 2800) 
  kit.servo[i].set_pulse_width_range(800, rg[i]) 
 return kit


def servo(valves,pos,kit):
  ps ={}
  #ps['input'] = 0
  ps['input'] = [0,0,0,0,0,0,0,0]
  #ps['output'] = 75
  ps['output'] = [75,100,75,75,75,75,75,75]
  #ps['bypass'] = 30
  ps['bypass'] = [30,30,30,30,30,30,30,30]
  #ps['close'] = 160
  ps['close'] = [160,165,160,160,160,160,160,160]
  #print("just before loop")
  ct = 0
  for i in valves:
   if int(i)==1:
    #print("kit.servo["+str(ct)+"].angle = ps["+pos+"]")
    kit.servo[ct].angle = ps[pos][ct]
   ct = ct + 1


kit = servoset()
#valves = [0,1,0,0,0,0,0,0]
#servo(valves,pos,kit)

