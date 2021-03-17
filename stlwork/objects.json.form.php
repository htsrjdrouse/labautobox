<? session_start(); ?>
<? include('jscadlib.php') ?>
<? if(isset($_POST['position'])){
 $movedata = array(
  'x'=>$_POST['movex'],
  'y'=>$_POST['movey'],
  'z'=>$_POST['movez']
 ); 
 $jsonfile = preg_replace("/stl$|STL$/", "json", $_SESSION['objectsactive']);
 file_put_contents('uploads/'.$jsonfile, json_encode($movedata));
 $jsonr = openjscad();
 $_SESSION['stlobj'] = $jsonr;
 header("Location: objects.json.php");
}
?>
<? if(isset($_POST['select'])){
 //$_SESSION['jsonpositions'] = json_decode(file_get_contents('uploads/'.$_SESSION['objectsactive']), true);
 $dir = scandir("uploads/");
 $ddir = array(); 
 foreach($dir as $dd){ 
   if (preg_match("/^.*.stl$|.STL$/", $dd)){ 
    array_push($ddir, $dd); 
   }
  }
 $_SESSION['objectsactive'] = $ddir[$_POST['objectlist']];
 $jsonr = openjscad();
 $_SESSION['stlobj'] = $jsonr;
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
 $jsonr = array(
	 //"header"=>"function main() { return union( ".$functionname."().translate([".(-1*($stats['maxx']-($stats['maxx']-$stats['minx'])/2)).",".(-1*($stats['maxy']-($stats['maxy']-$stats['miny'])/2)).",".(-1*$stats['minz'])."])); }",
	 "header"=>"function main() { return union( ".$functionname."().translate([".((-1*(($stats['minx'])+($stats['maxx']-$stats['minx'])/2))+$stats['movex']).",".((-1*(($stats['maxy'])+($stats['maxy']-$stats['miny'])/2))+$stats['movey']).",".((-1*$stats['minz'])+$stats['movez'])."])); }",
	 //"header"=>"function main() { return union( ".$functionname."().translate([".(-1*(($stats['minx'])+($stats['maxx']-$stats['minx'])/2))+$stats['movex'].",".(-1*(($stats['maxy'])+($stats['maxy']-$stats['miny'])/2))+$stats['movey'].",".(-1*$stats['minz'])+$stats['movez']."])); }",
	 "functionname"=>$functionname,
	 "polyhedronheader"=>$functionpolyhedronheader,
	 "polygonheader"=>$functionpolygonheader,
	 "polyheadrons"=>$res['polyhedrons'],
	 "polygons"=>$res['polygons'],
	 "stats"=>$stats,
	 "functiontail"=>$functiontail
 );
 displayjscad($jsonr);
 return $jsonr;
}
?>

