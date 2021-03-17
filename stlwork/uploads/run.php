<?php
include('jscadlib.php');

$fnm = $argv[1];
$jscad = preg_replace("/.stl|.STL$/", "", $fnm);
exec('sudo openjscad '.$fnm.' -o '.$jscad.'.jscad');

echo "finished";

$ff= $jscad.".jscad";
$res = parser($ff);
echo "Number of objects: ".count($res['polyhedrons']);

?>
