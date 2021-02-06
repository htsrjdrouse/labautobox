<? session_start(); ?>
<?
if ($_GET['id'] == "stop"){
 $cmd = 'mosquitto_pub -t "controllabbot" -m "kill runmacro"';
 exec($cmd);
 sleep(5);
 header('Location: index.php');
} 
/*
if ($_GET['id'] == "pause"){
 $cmd = 'mosquitto_pub -t "controllabbot" -m "pause runmacro"';
 exec($cmd);
 sleep(5);
 header('Location: logger.php?id=1');
} 
if ($_GET['id'] == "resume"){
 $cmd = 'mosquitto_pub -t "controllabbot" -m "resume runmacro"';
 exec($cmd);
 sleep(5);
 header('Location: logger.php?id=1');
} 
 */

?>
