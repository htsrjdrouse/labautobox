<? session_start(); ?>
<? include('jscadlib.php') ?>
<? 
if(isset($_POST['renderfromjscad'])){
$jscadfile =  $_SESSION['jscadfilename'];
system("openjscad uploads/".$jscadfile." -o rendered/rendered_".preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename']));
$_SESSION['objectsactive'] = preg_replace("/.jscad$/", ".stl", "rendered_".$_SESSION['jscadfilename']);
$_SESSION['fromstl'] = 0;
echo '<br>'.$jscadfile.'<br>';
header("Location: objects.json.php?id=download");
}
 if(isset($_POST['select'])){
 $_SESSION['fromstl'] = 0;
 //$_SESSION['jsonpositions'] = json_decode(file_get_contents('uploads/'.$_SESSION['objectsactive']), true);
 $dir = scandir("uploads/");
 $ddir = array(); 
 $jdir = array();
 foreach($dir as $dd){ 
   if (preg_match("/^.*.stl$|.STL$/", $dd)){ 
    array_push($ddir, $dd); 
   }
   if (preg_match("/^.*.jscad$/", $dd)){ 
    array_push($jdir, $dd); 
   }
  }
 $_SESSION['objectsactive'] = $ddir[$_POST['objectlist']];
 $stlfile = $_SESSION['objectsactive'];
 $jscad = preg_replace("/.stl$|.STL$/", "", $ddir[$_POST['objectlist']]);
 $ff= $jscad.".jscad";
 if (!in_array($stlfile, $jdir)){ 
  exec('sudo openjscad uploads/'.$stlfile.' -o uploads/'.$jscad.'.jscad');
  exec('sudo chown www-data:www-data uploads/'.$jscad.'.jscad');
  sleep(2);
  //$trimmed = file('uploads/'.$ff, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  //$res = parser($ff);
 }
 $_SESSION['jscadfilename'] =  $ff;
 $f = fopen("uploads/".$_SESSION['jscadfilename'],"r");
 $_SESSION['jscadcontents'] = fread($f,filesize("uploads/".$ff));
 echo $_SESSION['jscadcontents'];
 //$jsonr = openjscad();
 //$_SESSION['stlobj'] = $jsonr;
 //header("Location: objects.json.php");
}
?>
<? if(isset($_POST['position'])){
 if (isset($_POST['mirrorx'])){$_SESSION['mirrorx'] = "checked";} else{ $_SESSION['mirrorx'] = "";}
 if (isset($_POST['mirrory'])){$_SESSION['mirrory'] = "checked";} else{ $_SESSION['mirrory'] = "";}
 if (isset($_POST['mirrorz'])){$_SESSION['mirrorz'] = "checked";} else{ $_SESSION['mirrorz'] = "";}
 if (isset($_POST['lieflat'])){$_SESSION['lieflat'] = "checked";} else{ $_SESSION['lieflat'] = "";}
 $movedata = array(
  'x'=>$_POST['movex'],
  'y'=>$_POST['movey'],
  'z'=>$_POST['movez'],
  'rx'=>$_POST['rotatex'],
  'ry'=>$_POST['rotatey'],
  'rz'=>$_POST['rotatez'],
  'mx'=>$_SESSION['mirrorx'],
  'my'=>$_SESSION['mirrory'],
  'mz'=>$_SESSION['mirrorz'],
  'lieflat'=>$_SESSION['lieflat'],
  'sx'=>$_POST['scalex'],
  'sy'=>$_POST['scaley'],
  'sz'=>$_POST['scalez']
 ); 
 //$jsonfile = preg_replace("/stl$|STL$/", "json", $_SESSION['objectsactive']);
 $jsonfile = preg_replace("/.jscad$/", ".json", $_SESSION['jscadfilename']);
 file_put_contents('uploads/'.$jsonfile, json_encode($movedata));
 $_SESSION['fromstl'] = 0;
 //$jsonr = openjscad();
 $_SESSION['stlobj'] = $movedata;
 /*
 print_r($_SESSION['stlobj']);
 echo "<br>";
 echo $_SESSION['jscadfilename'];
 echo "<br>";
  */
 //echo "<pre>";
 //echo $_SESSION['jscadcontents'];
 //echo "parse is called<br>";
 $dat = pparse($_SESSION['jscadcontents'],$_SESSION['jscadfilename'],$movedata);
 $_SESSION['jscadcontents'] = $dat;
 header("Location: objects.json.php");
 //echo "</pre>";
 //header("Location: objects.json.php");
 //echo "<br>";
}
function pparse($jscadfilecontents,$functionname,$movedata){ 
 echo "in parser now<br>";
 $justcode = array();
 $ppray = preg_split("/\n/", $jscadfilecontents);
 foreach($ppray as $pp){
   if (strlen($pp) > 3){
    array_push($justcode, $pp);
   }
 }
 $stub = preg_replace("/\)\..*/", ")", $justcode[count($justcode)-2]);
 $stub .= ".translate([".$movedata['x'].",".$movedata['y'].",".$movedata['z']."])";
 $stub .= ".scale([".$movedata['sx'].",".$movedata['sy'].",".$movedata['sz']."])";
 $stub .= ".rotateX(".$movedata['rx'].").rotateY(".$movedata['ry'].").rotateZ(".$movedata['rz'].")";
 if($movedata['mx'] == "checked"){$stub .= ".mirroredX()";}
 if($movedata['my'] == "checked"){$stub .= ".mirroredY()";}
 if($movedata['mz'] == "checked"){$stub .= ".mirroredZ()";}
 if($movedata['lieflat'] == "checked"){$stub .= ".lieFlat()";}
 $modjustcode=array();
 for($x=0;$x<(count($justcode)-2);$x++){
	 array_push($modjustcode,$justcode[$x]);
 }
 array_push($modjustcode,$stub);
 array_push($modjustcode,"); }");
 $cstr = "";
 foreach($modjustcode as $mm){
   $cstr .=$mm.PHP_EOL;
 }
 $myfile = fopen("uploads/".$functionname, "w");
 fwrite($myfile, $cstr); 
 fclose($myfile);
 return $cstr;
}
?>
