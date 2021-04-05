<? //$myfile = fopen("uploads/".$jscadfile, "r");
//$contents = fread($myfile, filesize("uploads/".$jscadfile));
//fclose($myfile);
?>

<? //if (preg_match("/.*main\(\){ return.*/",$_SESSION['stlobj']['header'])){?>
<form action=objects.json.form.php method=post>
<? 
$contents =  $_SESSION['jscadcontents'];
$jscadfile = $_SESSION['jscadfilename'];
?>
<textarea name="macrofiledata" rows="14" cols="40">
<?=$contents;?>
</textarea>
<input type=text name="filename" value="<?=$jscadfile?>" size=30><br>
<button type="submit" name="savefile" class="btn-sm btn-success">Save file</button><br>
</form>

<br>

<? include('ref.openjscad.inc.php') ?>





