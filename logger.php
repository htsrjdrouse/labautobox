<? session_start(); ?>
<? //header("Refresh:0");?>
<!DOCTYPE html>
<html lang="en">
<head>
<? include('functionslib.php');?>
<? error_reporting(E_ALL & ~E_NOTICE);?>
<title>HTS LabBot</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
  <script src="/jquery.min.js" type="text/javascript"></script>
  <script src="/mqttws31.js" type="text/javascript"></script>


</head>
<body>
<ul>
<br>
<h2><a href=index.php>Interactive/Design</a></h2>
<br>
<a href=killrun.php?id=stop><font color=red><i class="fa fa-stop" aria-hidden="true"> STOP</font></i></a>
<br>
<br>
<? if (isset($_GET['id'])and($_GET['id'] == 1)){ 
?>
<a href=killrun.php?id=stop><font color=red><i class="fa fa-play" aria-hidden="true"> RESUME</font></i></a>
<?
} else {
?>
<a href=killrun.php?id=stop><font color=red><i class="fa fa-pause" aria-hidden="true"> PAUSE</font></i></a>
<? } ?>
<br>
<br>




<h2>Logger</h2><br>
  <? $mqttset = array("divmsg"=>"logger","topic"=>"labbot3d_track","client"=>"client4")?>
  <? include('mqtt.log.js.inc.php'); ?> 
<ul>
<b><font size=1><div style="font-weight:bold" id="logger"></b></div><font>
</ul>
</ul>

</body>
</html>
