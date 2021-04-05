<? session_start(); ?>
<? include('jscadlib.php') ?>
<? if(isset($_POST['deletejscad'])){
 unlink("uploads/".$_SESSION['jscadlist'][$_POST['objectlist']]);
 header("Location: objects.json.php");
} ?>
<? if(isset($_POST['selectjscad'])){
 $_SESSION['jscadfilename'] = $_SESSION['jscadlist'][$_POST['objectlist']];
 $_SESSION['fromstl'] = 0;
 $f = fopen("uploads/".$_SESSION['jscadfilename'],"r");
 $_SESSION['jscadcontents'] = fread($f,filesize("uploads/".$_SESSION['jscadfilename']));
}
header("Location: objects.json.php");
?>
<? if(isset($_POST['savefile'])){
 //echo '<br>'.$_POST['filename'].'<br>';
 //echo preg_replace("/.jscad$/", ".stl", $_POST['filename']).'<bR>';
 //unlink("uploads/".$_SESSION['jscadfilename']);
 //$_SESSION['jscadfilename']= date('Ymds').'.jscad';
 $_SESSION['jscadcontents']= $_POST['macrofiledata'];
 $_SESSION['jscadfilename']= $_POST['filename'];
 $stlfile =  preg_replace("/.jscad$/", ".stl", $_POST['filename']);
 $dir = scandir("uploads/");
 $ddir = array(); 
 foreach($dir as $dd){ 
  if (preg_match("/^.*.stl$|.STL$/", $dd)){ 
    array_push($ddir, $dd); 
   }
 }
 //var_dump($ddir);
 if (in_array($stlfile, $ddir)){ $fl = 1; } else { $fl = 0; }
 //echo 'flag '.$fl.'<br>';
 //echo $_POST['macrofiledata'];
 //$_SESSION['jscadfilename']= $_POST['filename'];
 $_SESSION['fromstl'] = 0;
 writejscad(preg_replace("/.jscad$/", "", $_SESSION['jscadfilename']),$_POST['macrofiledata']);
 //system('sudo cp uploads/'.$_SESSION['jscadfilename'].' uploads/'.$_POST['filename']);
 }?>
<? if(isset($_POST['render'])){
$jscadfile = preg_replace("/stl$|STL$/", "jscad", $_SESSION['objectsactive']);
system("openjscad uploads/".$jscadfile." -o uploads/rendered_".$_SESSION['objectsactive']);
exec('sudo chown www-data:www-data uploads/mod.'.$_SESSiON['objectsactive']);
header("Location: objects.json.php?id=download");
}?>

<? if(isset($_POST['position'])){
 if ($_POST['mirrorx'] =="on"){$_SESSION['mirrorx'] = "checked";} else{ $_SESSION['mirrorx'] = "";}
 if ($_POST['mirrory'] =="on"){$_SESSION['mirrory'] = "checked";} else{ $_SESSION['mirrory'] = "";}
 if ($_POST['mirrorz'] =="on"){$_SESSION['mirrorz'] = "checked";} else{ $_SESSION['mirrorz'] = "";}
 $movedata = array(
  'x'=>$_POST['movex'],
  'y'=>$_POST['movey'],
  'z'=>$_POST['movez'],
  'rx'=>$_POST['rotatex'],
  'ry'=>$_POST['rotatey'],
  'rz'=>$_POST['rotatez'],
  'mx'=>$_POST['mirrorx'],
  'my'=>$_POST['mirrory'],
  'mz'=>$_POST['mirrorz'],
  'sx'=>$_POST['scalex'],
  'sy'=>$_POST['scaley'],
  'sz'=>$_POST['scalez']
 ); 
 $jsonfile = preg_replace("/.jscad$/", ".json", $_SESSION['jscadfilename']);
 file_put_contents('uploads/'.$jsonfile, json_encode($movedata));
 $_SESSION['fromstl'] = 0;
 //$jsonr = openjscad();
 $_SESSION['stlobj'] = $jsonr;
 echo "<br>this is called<br>";
 var_dump($_SESSION['stlobj']);
 echo "<br>";
 echo $_SESSION['jscadfilename'];
 echo "<br>";
 //$f = fopen("uploads/".$_SESSION['jscadfilename'],"r");
 //$_SESSION['jscadcontents'] = fread($f,filesize("uploads/".$_SESSION['jscadfilename']));
 echo $_SESSION['jscadcontents'];
 //header("Location: objects.json.php");
 echo "<br>";
}
?>
<? 
if(isset($_POST['renderfromjscad'])){
//$_SESSION['objectsactive'] = "rendered/rendered_".preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename']);
$jscadfile =  $_SESSION['jscadfilename'];
system("openjscad uploads/".$jscadfile." -o rendered/rendered_".preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename']));
echo ("openjscad uploads/".$jscadfile." -o rendered/rendered_".preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename']));
//$_SESSION['objectsactive'] = preg_replace("/.jscad$/", ".stl", "rendered_".$_SESSION['jscadfilename']);
$_SESSION['fromstl'] = 1;
//echo '<br>'.$jscadfile.'<br>';
header("Location: objects.json.php?id=download");
}
?>
<? if(isset($_POST['select'])){
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
  exec('sudo chmod 777 uploads/'.$jscad.'.jscad');
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
 header("Location: objects.json.php");
}
?>
<? if(isset($_POST['download'])){
 $ff = 'uploads/'.$_SESSION['objectsactive'];
 $myfile = fopen($ff, "r") or die("Unable to open file!");
 echo fread($myfile,filesize($ff));
 fclose($myfile);
} ?>
<? if(isset($_POST['delete'])){
 $_SESSION['fromstl'] = 1;
 $dir = scandir("uploads/");
 $ddir = array(); 
 foreach($dir as $dd){ 
   if (preg_match("/^.*.stl$|.STL$/", $dd)){ 
    array_push($ddir, $dd); 
   }
  }
 unlink("uploads/".$ddir[$_POST['objectlist']]);
 unset($_SESSION['objectsactive']);
 unset($_SESSION['stlobj']);
 $jscadv = preg_replace("/stl$|STL$/", "jscad", $ddir[$_POST['objectlist']]);
 unlink("uploads/".$jscadv);
 $jsonf = preg_replace("/jscad$/", "json", $ddir[$_POST['objectlist']]);
 unlink("uploads/".$jsonf);
 header("Location: objects.json.php");
} ?>
<?
function openjscad(){
 $functionname = preg_replace("/.stl$|.STL$/", "", $_SESSION['objectsactive']);
 $jscadv = preg_replace("/stl$|STL$/", "jscad", $_SESSION['objectsactive']);
 $res = parser($jscadv);
 //$functionname=preg_replace(".jscad", "", $jscadv);
 $functionpolyhedronheader = "function ".$functionname."() {return polyhedron({ points: [";
 $functionpolygonheader = " polygons: [";
 $functiontail = "}";
 $stats = positionstats($res['polyhedrons'],$functionname);
 $header = "function main() { return union( ";
 $header .= $functionname."().translate([".((-1*(($stats['minx'])+($stats['maxx']-$stats['minx'])/2))+$stats['movex']).",".((-1*(($stats['maxy'])+($stats['maxy']-$stats['miny'])/2))+$stats['movey']).",".((-1*$stats['minz'])+$stats['movez'])."]).rotateX(".$stats['rotatex'].").rotateY(".$stats['rotatey'].").rotateZ(".$stats['rotatez'].")";
 $header .= ".scale([".$stats['scalex'].",".$stats['scaley'].",".$stats['scalez']."])";
 if ($stats['mirrorx'] == "on"){ $header .= ".mirroredX()";}
 if ($stats['mirrory'] == "on"){ $header .= ".mirroredY()";}
 if ($stats['mirrorz'] == "on"){ $header .= ".mirroredZ()";}
 $header .= "); }";
 $_SESSION['headersyntax'] = $header;
 $_SESSION['jsonfiletrack'] = $stats;

 $jsonr = array(
	 //"header"=>"function main() { return union( ".$functionname."().translate([".((-1*(($stats['minx'])+($stats['maxx']-$stats['minx'])/2))+$stats['movex']).",".((-1*(($stats['maxy'])+($stats['maxy']-$stats['miny'])/2))+$stats['movey']).",".((-1*$stats['minz'])+$stats['movez'])."]).rotateX(".$stats['rotatex'].").rotateY(".$stats['rotatey'].").rotateZ(".$stats['rotatez'].")); }",
	 "header"=>$header,
	 "functionname"=>$functionname,
	 "polyhedronheader"=>$functionpolyhedronheader,
	 "polygonheader"=>$functionpolygonheader,
	 "polyheadrons"=>$res['polyhedrons'],
	 "polygons"=>$res['polygons'],
	 "stats"=>$stats,
	 "functiontail"=>$functiontail
 );
 sleep(2);
 displayjscad($jsonr);
 return $jsonr;
}
?>
