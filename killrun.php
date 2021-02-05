<? session_start(); ?>
<?
if ($_GET['id'] == "stop"){
 $cmd = 'mosquitto_pub -t "controllabbot" -m "kill runmacro"';
 exec($cmd);
 sleep(5);
 header('Location: index.php');
} 

?>
