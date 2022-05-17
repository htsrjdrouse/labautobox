Labautobox - laboratory automation scheduling software

This is the repo for the control software for the labautobox but can be used as a general purpose lab automation schedular for 3-D printers. The idea is to integrate the control of devices with the 3-D printer using g-code. More details about the software can be used posted at <a href=https://www.htsresources.com/internet-of-thing_robotic_scheduling_software_for_3-D_printers.php>https://www.htsresources.com/internet-of-thing_robotic_scheduling_software_for_3-D_printers.php</a>

There is also some features of a multichannel pipetting example posted at <a href=https://www.htsresources.com/labautobox/index.php>https://www.htsresources.com/labautobox/index.php</a> and there is another example that demonstrates how a 3-D printer can be configured to do circuit printing posted at <a href=https://www.htsresources.com/lbcircuitprinter/index.php>https://www.htsresources.com/lbcircuitprinter/index.php</a>. 

The system makes it possible to create and edit macros for integrating devices with 3-D printers. This is made possible using MQTT pub/sub messaging. Where in this case, the server (subscriber) is written in Python and the clients (publishers) are written mostly in PHP and Javacript. 


