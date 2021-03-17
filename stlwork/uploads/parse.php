<?php

//$a = fopen("Lower_Lattice_Cube.jscad");
$ff= "Lower_Lattice_Cube.jscad";

$objects = parser($ff);
//var_dump($objects);
echo count($objects['polyhedrons']);
echo count($objects['polygons']);


function parser($ff){
$trimmed = file($ff, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
