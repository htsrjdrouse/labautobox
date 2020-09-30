<? 
if(isset($_POST['cameraipsub'])){ 
  $_SESSION['cameraip'] = $_POST['cameraip'];
  $jsonimg = openjson('nx.imgdataset.json'); 
  $jsonimg['cameraip'] = $_POST['cameraip'];
  closejson($jsonimg,'nx.imgdataset.json'); 
}
if(isset($_POST['openpic'])){ 
  $_SESSION['labbot3d']['img'] = $_POST['imglist'];
}
if(isset($_POST['opendir'])){ 
  unset($_SESSION['labbot3d']['img']);
  $_SESSION['labbot3d']['imgdir'] = $_POST['imgdirlist'];
 }
if(isset($_POST['createdir'])){ 
  unset($_SESSION['labbot3d']['img']);
  $date = date('mdYHis');
  $_SESSION['labbot3d']['imgdir'] = $date;
  $cmd = 'mosquitto_pub -h '.$_SESSION['cameraip'].' -t "dcam2" -m "createdir '.$_SESSION['labbot3d']['imgdir'].'"';
  exec($cmd);
 }
if(isset($_POST['removedir'])){ 
  if (isset($_SESSION['labbot3d']['imgdir'])){
   $cmd = 'mosquitto_pub -h '.$_SESSION['cameraip'].' -t "dcam2" -m "rmdir '.$_SESSION['labbot3d']['imgdir'].'"';
   exec($cmd);
  }
  unset($_SESSION['labbot3d']['imgdir']);
 }
if(isset($_POST['snap'])){ 
  if (isset($_SESSION['labbot3d']['imgdir'])){
    $_SESSION['labbot3d']['camfocus'] = $_POST['camfocus'];
    $_SESSION['labbot3d']['camexposure'] = $_POST['camexposure'];
    $_SESSION['labbot3d']['filename'] = $_POST['fname'];
    $date = date('His');
    $cmd = 'mosquitto_pub -h '.$_SESSION['cameraip'].' -t "dcam2" -m "snap '.$_SESSION['labbot3d']['camfocus'].'_'.$_SESSION['labbot3d']['camexposure'].'_'.$_SESSION['labbot3d']['imgdir'].'_'.$_SESSION['labbot3d']['filename'].$date.'"';
    echo($cmd);
    echo "<br>";
    exec($cmd);
    sleep(1);
  }
 }
?>
<hr>
<div class="row"><h3>&nbsp;&nbsp;Camera Settings</h3></div>

<? 
if(!isset($_SESSION['cameraip'])){ 
 $jsonimg = openjson('nx.imgdataset.json'); 
 closejson($jsonimg,'nx.imgdataset.json'); 
 $_SESSION['cameraip'] = $jsonimg['cameraip'];
}
?>
<div class="row">
<form action=<?=$_SERVER['PHP_SELF']?> method=post>
<div class="col-sm-12">
<input type=text name=cameraip value="<?=$_SESSION['cameraip']?>" size=10>
<button type="submit" name=cameraipsub value="cameraipsub"  class="btn btn-primary btn-sm">Set Camera IP</button><br> <br>
</div>
</form>
</div>
<div class="row">
<form action=<?=$_SERVER['PHP_SELF']?> method=post>
<div class="col-sm-4">
<button type="submit" name=createdir value="createdir"  class="btn btn-primary btn-sm">Create directory</button><br>
</div>
<div class="col-sm-4">
<button type="submit" name=removedir value="removedir"  class="btn btn-danger btn-sm">Remove directory</button><br>
</div>
</div>
<div class="row">
<div class="col-sm-5"><br>
<button type="submit" name=opendir value="opendir"  class="btn btn-success btn-sm">Open directory</button><br>
</div>
<div class="col-sm-5"><br>
<? if (isset($_SESSION['labbot3d']['imgdir'])){ ?>
<? if(!isset($_SESSION['labbot3d']['camfocus'])){ $_SESSION['labbot3d']['camfocus'] = 400;}
   if(!isset($_SESSION['labbot3d']['camexposure'])){ $_SESSION['labbot3d']['camexposure'] = 50;} ?>
Focus <input type=text name=camfocus value=<?=$_SESSION['labbot3d']['camfocus']?> size=3> <br>
Exposure <input type=text name=camexposure value=<?=$_SESSION['labbot3d']['camexposure']?> size=3><br>
Filename <input type=text name=fname value="<?=$_SESSION['labbot3d']['filename']?>" size=3><br>



<button type="submit" name=snap value="snap"  class="btn btn-warning btn-sm">Snap pic</button>&nbsp;&nbsp;
<button type="submit" name=openpic value="openpic"  class="btn btn-success btn-sm">Open pic</button>
<? } ?>
</div>


</div>
<div class="row">
<div class="col-sm-5">
<?  $output = shell_exec("sudo ssh pi@".$_SESSION['cameraip']." ls /var/www/html/imaging"); ?>
<? $ff = (preg_split("/\n/", $output));?><br>
<? $size = count($ff); ?>
<? if($size > 11) {$size = 10;} ?>
 <select class="form-control form-control-sm" name="imgdirlist" size=3>
 <?for($i=0;$i<count($ff);$i++){?>
 <? if ($_SESSION['labbot3d']['imgdir'] == $ff[$i]) {?>
   <option value=<?=$ff[$i]?> selected><?=$ff[$i]?></option>
  <? } else { ?>
   <option value=<?=$ff[$i]?>><?=$ff[$i]?></option>
<? } ?>
<? } ?>
 </select>
</div>


<div class="col-sm-5">
<? if (isset($_SESSION['labbot3d']['imgdir'])){ ?>
<?  $output = shell_exec("sudo ssh pi@".$_SESSION['cameraip']." ls /var/www/html/imaging/".$_SESSION['labbot3d']['imgdir']); ?>
<? $fff = (preg_split("/\n/", $output));?><br>
 <select class="form-control form-control-sm" name="imglist" size=3>
 <?for($i=0;$i<count($fff);$i++){?>
 <? if($_SESSION['labbot3d']['img'] == $fff[$i]) {?>
   <option value=<?=$fff[$i]?> selected><?=$fff[$i]?></option>
  <? } else { ?>
   <option value=<?=$fff[$i]?>><?=$fff[$i]?></option>
 <? } ?> 
<? } ?> 
 </select>

<? } ?> 
</form>
</div>
</div>
<div class="row"><br></div>
<div class="row">
<div class="col-sm-1">&nbsp;</div>
<div class="col-sm-10"></div>
 <? if(isset($_SESSION['labbot3d']['img'])) {?>
 <img src=http://<?=$_SESSION['cameraip']?>/imaging/<?=$_SESSION['labbot3d']['imgdir']?>/<?=$_SESSION['labbot3d']['img']?> width=320 height=240>
 <? }?>
</div>
</div>
