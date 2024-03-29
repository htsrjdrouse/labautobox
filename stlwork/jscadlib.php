<?


function writejscad($functionname,$contents){
 $myfile = fopen("uploads/".$functionname.".jscad", "w");
 fwrite($myfile, $contents); 
 fclose($myfile);
}


function displayjscad($stlobj){
  //$stlobj['functionname'];
  $contents = $stlobj['header'].PHP_EOL;
  $contents = $contents.$stlobj['polyhedronheader'].PHP_EOL;
  foreach($stlobj['polyheadrons'][0] as $pl){
   $contents = $contents.$pl.PHP_EOL;
  }
  $contents = $contents.$stlobj['polygonheader'].PHP_EOL;
  foreach($stlobj['polygons'][0] as $ppl){
   $contents = $contents.$ppl.PHP_EOL;
  } 
  $contents = $contents.$stlobj['functiontail'];
  writejscad($stlobj['functionname'],$contents);
}
function positionstats($polyhedron,$functionname){
  if (file_exists('uploads/'.$functionname.'.json')) {
   $movedata = json_decode(file_get_contents('uploads/'.$functionname.'.json'), true);
  } else {
   $movedata = array(
     "x"=>0,
     "y"=>0,
     "z"=>0,
     "rx"=>0,
     "ry"=>0,
     "rz"=>0,
     "sx"=>0,
     "sy"=>0,
     "sz"=>0,
     "mx"=>null,
     "my"=>null,
     "mz"=>null
    );
   file_put_contents('uploads/'.$functionname.'.json', json_encode($movedata));
  }
  // [61.7279,3,199],    
  $xpos = array();
  $ypos = array();
  $zpos = array();
  //var_dump($polyhedron);
  foreach($polyhedron[0] as $pp){
   //echo preg_replace("/\[/", "", $pp).'<br>';
   $ppp =  preg_replace("/\[/", "", $pp);
   $pppp =  preg_replace("/\]/", "", $ppp);
   $pppp =  preg_replace("/\],/", "", $pppp);
   $ar = preg_split("/,/", $pppp);
   array_push($xpos,$ar[0]);
   array_push($ypos,$ar[1]);
   array_push($zpos,$ar[2]);
  }
  $stats = array(
    "minx"=>min($xpos),
    "maxx"=>max($xpos),
    "miny"=>min($ypos),
    "maxy"=>max($ypos),
    "minz"=>min($zpos),
    "maxz"=>max($zpos),
    "movex"=>$movedata['x'],
    "movey"=>$movedata['y'],
    "movez"=>$movedata['z'],
    "rotatex"=>$movedata['rx'],
    "rotatey"=>$movedata['ry'],
    "rotatez"=>$movedata['rz'],
    "scalex"=>$movedata['sx'],
    "scaley"=>$movedata['sy'],
    "scalez"=>$movedata['sz'],
    "mirrorx"=>$movedata['mx'],
    "mirrory"=>$movedata['my'],
    "mirrorz"=>$movedata['mz']
  );
  return $stats;
}



function parser($ff){
$trimmed = file('uploads/'.$ff, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//var_dump($trimmed);
$fl = 0;
$polyhedrons = array();
$polygons = array();
foreach($trimmed as $tt){
	if (preg_match("/^.*polyhedron\({ points: \[/", $tt)){
		$fl = 1;
		$prepoly = array();
	}
  //polygons: [
	if (preg_match("/^.*polygons: \[/", $tt)){
		$fl = 2;
		$prepolygon = array();
	}

	if ((preg_match("/^.*\]\]/", $tt)) and ($fl == 1)){
		array_push($prepoly, $tt);
		array_shift($prepoly);
		array_push($polyhedrons, $prepoly);
		$fl = 0;
	}

	if ((preg_match("/^.*\]\]/", $tt))and ($fl == 2)){
		array_push($prepolygon, $tt);
		array_shift($prepolygon);
		array_push($polygons, $prepolygon);
		$fl = 0;
	}

	if ($fl == 1){
		array_push($prepoly, $tt);
        }
	if ($fl == 2){
		array_push($prepolygon, $tt);
        }
 }
   $objects = array("polyhedrons"=>$polyhedrons, "polygons"=>$polygons);
   return $objects;
}
?>
