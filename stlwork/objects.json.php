<? session_start(); ?>
<? include('jscadlib.php') ?>


<? if(isset($_POST['upload'])){
$target_dir = "uploads/";
$target_file =  $target_dir . basename($_FILES["fileToUpload"]["name"]);
if (preg_match("/\.stl$|\.STL$/",basename($_FILES["fileToUpload"]["name"]))){ $uploadOk = 1; } else { $uploadOk = 0; }
//$uploadOk = 1;
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if($check == false) {
  $uploadOk = 1;
} else {
  echo "File is an image.";
  $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

  if ($uploadOk == 1){
   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	   //$msg = 'target file '.$target_file.' uploaded<br>';
     $fnm = basename($_FILES["fileToUpload"]["name"]);
     $jscad = preg_replace("/.stl|.STL$/", "", $fnm);
      exec('sudo openjscad uploads/'.$fnm.' -o uploads/'.$jscad.'.jscad');
     $ff= $jscad.".jscad";
     $res = parser($ff);
   } else {
      $msg = "Sorry, there was an error uploading your file.<br>";
  }
  }
}
?>


<? //header("Refresh:0");?>
<!DOCTYPE html>
<html lang="en">
<head>
<? //include('functionslib.php');?>
<? error_reporting(E_ALL & ~E_NOTICE);?>
<title>HTS LabBot</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/bootstrap.min.css">
  <script src="/jquery.min.js"></script>
  <script src="/bootstrap.min.js"></script>

</head>

<div class="row">
 <div class="col-md-1"></div>
 <div class="col-md-4"><br><br>
  <h3>STL development tool</h3>


  </div>
 <div class="col-md-6"><br><br>
 </div>
</div>
<div class="row">
 <div class="col-md-1"></div>
 <div class="col-md-2"><br> 

<? if (isset($_SESSION['objectsactive'])){ echo $_SESSION['objectsactive']; } ?><br>

<h4>Select object list file:</h4><br>
 <?$dir = scandir("uploads/"); ?>
<? $ddir = array(); foreach($dir as $dd){ ?>
<? if (preg_match("/^.*.stl$|.STL$/", $dd)){ array_push($ddir, $dd); }?>
<? } ?>
 <? $size = count($ddir);
  if (count($ddir) > 10){ $size=10; }
 ?>

<form action=objects.json.form.php method=post>
 <select class="form-control form-control-sm" name="objectlist" size=<?=$size?>>
  <? foreach($ddir as $key => &$val){ ?>
  <? if ($val == $_SESSION['objectsactive']) { ?> 
   <option value=<?=$key?> selected><?=$val?></option>
  <? } else { ?>
   <option value=<?=$key?>><?=$val?></option>
  <? } ?>
  <? } ?>
 </select>
<br>
  <button type="submit" name="select" class="btn-sm btn-primary">Select file</button><br><br>
  <a href="uploads/<?=$_SESSION['objectsactive']?>" class="btn btn-sm btn-success" role="button" aria-pressed="true">Download STL</a><br><br>
  <button type="submit" name="delete" class="btn-sm btn-danger">Delete file</button><br><br>
</form>

<br>

<form action="objects.json.php" method="post" enctype="multipart/form-data">
 <style>

.fileContainer {
    overflow: hidden;
    position: relative;
}

.fileContainer [type=file] {
    cursor: inherit;
    display: block;
    font-size: 999px;
    filter: alpha(opacity=0);
    min-height: 100%;
    min-width: 100%;
    opacity: 0;
    position: absolute;
    right: 0;
    text-align: right;
    top: 0;
}
 </style>



<script>
/*
    updateList = function() {
    var input = document.getElementById('fileToUpload');
    var output = document.getElementById('fileList');
    var children = "";
    for (var i = 0; i < input.files.length; ++i) {
        children += '<li>' + input.files.item(i).name + '</li>';
    }
    output.innerHTML = '<ul>'+children+'</ul>';
}
 */
</script>
 <script type ="text/javascript" >
function showButton(){
 document.getElementById ("uploadbutton").style.visibility ="visible";
}

function getFile() {
  showButton();
  document.getElementById("upfile").click();
}

function sub(obj) {
  var file = obj.value;
  var fileName = file.split("\\");
  document.getElementById("yourBtn").innerHTML = fileName[fileName.length - 1];
  document.myForm.submit();
  event.preventDefault();
}
</script>
<style>
#yourBtn {
  position: relative;
  /*top: 50px;*/
  font-family: calibri;
  width: 150px;
  padding: 10px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border: 1px dashed #BBB;
  text-align: center;
  background-color: #FF8C00;
  color: white;
  cursor: pointer;
}
</style>

<h4>Upload STL file</h4>
<br>
  <div id="yourBtn" onclick="getFile()">Click to upload STL</div>
  <!-- this is your file input tag, so i hide it!-->
  <!-- i used the onchange event to fire the form submission-->
  <div style='height: 0px;width: 0px; overflow:hidden;'><input id="upfile" type="file" name="fileToUpload" value="upload" onchange="sub(this)" /></div>

  <br><div id="myDIV"><button type="submit" name=upload value="Upload file" id="uploadbutton" class="btn btn-primary" style="visibility:hidden">Upload file</button></div>
<br>
</form>
 </div>
 <div class="col-md-1"></div><br><br>
 <div class="col-md-5">

<br> 

<? if (isset($_SESSION['objectsactive'])){ 
echo $_SESSION['objectsactive'].'<br>';
?>
 MinX: <?=$_SESSION['stlobj']['stats']['minx']?> --
 MaxX: <?=$_SESSION['stlobj']['stats']['maxx']?> <br>
 MinY: <?=$_SESSION['stlobj']['stats']['miny']?> --
 MaxY: <?=$_SESSION['stlobj']['stats']['maxy']?> <br>
 MinZ: <?=$_SESSION['stlobj']['stats']['minz']?> --
 MaxZ: <?=$_SESSION['stlobj']['stats']['maxz']?> <br>
<? 
 echo '<br>';
 include('3dviewer.inc.php');
} ?>
<? $jsonfile = preg_replace("/stl$|STL$/", "json", $_SESSION['objectsactive']); ?>
<? $movedata = json_decode(file_get_contents('uploads/'.$jsonfile), true);?>
<form action=objects.json.form.php method=post>
Move X: <input name="movex" type="text" size=6 value="<?=$movedata['x']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
 Y: <input name="movey" type="text" size=6 value="<?=$movedata['y']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
 Z: <input name="movez" type="text" size=6 value="<?=$movedata['z']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
<button type="submit" name="position" class="btn-sm btn-primary">Move</button><br><br>
<form action=objects.json.form.php method=post>
Rotate X: <input name="rotatex" type="text" size=6 value="<?=$movedata['x']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
 Y: <input name="rotatey" type="text" size=6 value="<?=$movedata['y']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
 Z: <input name="rotatez" type="text" size=6 value="<?=$movedata['z']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
<button type="submit" name="rotate" class="btn-sm btn-primary">Rotate</button><br><br>


</form>
</div>
<div class="col-md-2">
</div>
<div class="col-md-2">
</div>
</div> <!--end  row-->
<div class="row">
 <div class="col-md-1"><br><br></div>
 <div class="col-md-4">
</div>
 <div class="col-md-7">

 </div>
</body>
</html>
