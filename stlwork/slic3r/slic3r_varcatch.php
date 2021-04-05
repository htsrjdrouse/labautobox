<? session_start(); ?>
<?
if (isset($_POST['slice'])){
 if($_SESSION['fromstl'] == 0){
	 $cmd = "slic3r -g uploads/".$_SESSION['objectsactive']." --output gcodes/";
 } else if ($_SESSION['fromstl'] == 1){
	 $cmd = "slic3r -g rendered/rendered_".preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename'])." --output gcodes/";
 }
 echo $cmd.'<br>';
}
if (isset($_POST['saveconfig'])){
    $jsonfile = $_POST['slic3rconfig'];
    $_SESSION['configactive'] = $_POST['slic3rconfig'];
    $pcnt = collectvar();
    $a = fopen($jsonfile.'.json', 'w');
    fclose($a);
    file_put_contents($jsonfile.'.json', json_encode($pcnt));
    if (file_exists('slic3rconfigfiles.json')){
	    $configjson = json_decode(file_get_contents('slic3rconfigfiles.json'), true);
	    if (!in_array($jsonfile,$configjson['file'])){
	     array_push($configjson['file'], $jsonfile);
	     file_put_contents('slic3rconfigfiles.json', json_encode($configjson));
	    }
    } else {
	    $configjson = array('file'=>array());
	    array_push($configjson['file'], $jsonfile);
       	    file_put_contents('slic3rconfigfiles.json', json_encode($configjson));
    }
    $cmd = "slic3r";
    foreach($pcnt as $key => $value){
      if($value == "y"){ $cmd .= " --".$key; } else if($value != "n"){ $cmd .= " --".$key." ".$value; }
    }
    $cmd .= " --save ".$jsonfile."txt";
    system("sudo ".$cmd);
    //echo $cmd.'<br>';
    header("Location: slic3rconfig_management.php");
}
if (isset($_POST['saveconfigtext'])){
    $jsonfile = $_POST['slic3rconfigtext'];
    $_SESSION['configactive'] = $_POST['slic3rconfigtext'];
    $a = fopen($jsonfile.'.json', 'w');
    fwrite($a, $_POST['configfiledata']); 
    fclose($a);
    $configjson = json_decode(file_get_contents('slic3rconfigfiles.json'), true);
    if (!in_array($jsonfile,$configjson['file'])){
	     array_push($configjson['file'], $jsonfile);
	     file_put_contents('slic3rconfigfiles.json', json_encode($configjson));
    }
header("Location: slic3rconfig_management.php");
}
if (isset($_POST['selectconfig'])){
$configjson = json_decode(file_get_contents('slic3rconfigfiles.json'), true);
$_SESSION['configactive'] = $configjson['file'][$_POST['configlist']]; 
header("Location: slic3rconfig_management.php");
}
if (isset($_POST['selectconfigfront'])){
$configjson = json_decode(file_get_contents('slic3rconfigfiles.json'), true);
$_SESSION['configactive'] = $configjson['file'][$_POST['configlist']]; 
header("Location: ../objects.json.php");
}
if (isset($_POST['deleteconfig'])){
 $configjson = json_decode(file_get_contents('slic3rconfigfiles.json'), true);
 session_unset($_SESSION['configactive']);
 unset($configjson['file'][$_POST['configlist']]); 
 unlink($configjson['file'][$_POST['configlist']]."json"); 
 unlink($configjson['file'][$_POST['configlist']]."txt"); 
 file_put_contents('slic3rconfigfiles.json', json_encode($configjson));
 header("Location: slic3rconfig_management.php");
}


function collectvar(){
    $cnt = array( 
    'nozzle-diameter'=> $_POST['nozzle-diameter'],
    'print-center'=> $_POST['print-center'],
    'z-offset'=> $_POST['z-offset'],
    'use-relative-e-distances'=> $_POST['use-relative-e-distances'],
    'use-firmware-retraction'=> $_POST['use-firmware-retraction'],
    'use-volumetric-e'=> $_POST['use-volumetric-e'],
    'filament-diameter'=> $_POST['filament-diameter'],
    'extrusion-multiplier'=> $_POST['extrusion-multiplier'],
    'temperature'=> $_POST['temperature'],
    'bed-temperature'=> $_POST['bed-temperature'],
    'first-layer-bed-temperature'=> $_POST['first-layer-bed-temperature'],
    'travel-speed'=> $_POST['travel-speed'],
    'perimeter-speed'=> $_POST['perimeter-speed'],
    'small-perimeter-speed'=> $_POST['small-perimeter-speed'],
    'external-perimeter-speed'=> $_POST['external-perimeter-speed'],
    'infill-speed'=> $_POST['infill-speed'],
    'solid-infill-speed'=> $_POST['solid-infill-speed'],
    'top-solid-infill-speed'=> $_POST['top-solid-infill-speed'],
    'support-material-speed'=> $_POST['support-material-speed'],
    'support-material-interface-speed'=> $_POST['support-material-interface-speed'],
    'bridge-speed'=> $_POST['bridge-speed'],
    'gap-fill-speed'=> $_POST['gap-fill-speed'],
    'first-layer-speed'=> $_POST['first-layer-speed'],
    'perimeter-acceleration'=> $_POST['perimeter-acceleration'],
    'infill-acceleration'=> $_POST['infill-acceleration'],
    'bridge-acceleration'=> $_POST['bridge-acceleration'],
    'first-layer-acceleration'=> $_POST['first-layer-acceleration'],
    'default-acceleration'=> $_POST['default-acceleration'],
    'layer-height'=> $_POST['layer-height'],
    'first-layer-height' => $_POST['first-layer-height' ],
    'infill-every-layers'=> $_POST['infill-every-layers'],
    'solid-infill-every-layers'=> $_POST['solid-infill-every-layers'],
    'perimeters'=> $_POST['perimeters'],
    'top-solid-layers'=> $_POST['top-solid-layers'],
    'bottom-solid-layers'=> $_POST['bottom-solid-layers'],
    'solid-layers'=> $_POST['solid-layers'],
    'fill-density'=> $_POST['fill-density'],
    'fill-angle'=> $_POST['fill-angle'],
    'fill-pattern'=> $_POST['fill-pattern'],
    'fill-gaps'=> $_POST['fill-gaps'],
    'top-infill-pattern'=> $_POST['top-infill-pattern'],
    'bottom-infill-pattern'=> $_POST['bottom-infill-pattern'],
    'seam-position'=> $_POST['seam-position'],
    'external-perimeters-first'=> $_POST['external-perimeters-first' ],
    'spiral-vase'=> $_POST['spiral-vase'],
    'only-retract-when-crossing-perimeters'=> $_POST['only-retract-when-crossing-perimeters'],
    'solid-infill-below-area'=> $_POST['solid-infill-below-area'],
    'infill-only-where-needed'=> $_POST['infill-only-where-needed'],
    'infill-first'=> $_POST['infill-first'],
    'extra-perimeters'=> $_POST['extra-perimeters'],
    'avoid-crossing-perimeters'=> $_POST['avoid-crossing-perimeters'],
    'thin-walls'=> $_POST['thin-walls'],
    'detect-bridging-perimeters'=> $_POST['detect-bridging-perimeters'],
    'support-material'=> $_POST['support-material'],
    'support-material-threshold'=> $_POST['support-material-threshold'],
    'support-material-pattern'=> $_POST['support-material-pattern'],
    'support-material-spacing'=> $_POST['support-material-spacing'],
    'support-material-angle'=> $_POST['support-material-angle'],
    'support-material-contact-distance'=> $_POST['support-material-contact-distance'],
    'support-material-interface-layers'=> $_POST['support-material-interface-layers'],
    'support-material-interface-spacing'=> $_POST['support-material-interface-spacing'],
    'raft-layers'=> $_POST['raft-layers'],
    'support-material-enforce-layers'=> $_POST['support-material-enforce-layers'],
    'support-material-buildplate-only'=> $_POST['support-material-buildplate-only'],
    'dont-support-bridges'=> $_POST['dont-support-bridges'],
    'retract-length'=> $_POST['retract-length'],
    'retract-speed'=> $_POST['retract-speed'],
    'retract-restart-extra'=> $_POST['retract-restart-extra'],
    'retract-before-travel'=> $_POST['retract-before-travel'],
    'retract-lift'=> $_POST['retract-lift'],
    'retract-lift-above'=> $_POST['retract-lift-above'],
    'retract-lift-below'=> $_POST['retract-lift-below'],
    'retract-layer-change'=> $_POST['retract-layer-change'],
    'wipe'=> $_POST['wipe'],
    'retract-length-toolchange'=> $_POST['retract-length-toolchange'],
    'retract-restart-extra-toolchange'=> $_POST['retract-restart-extra-toolchange'],
    'cooling'=> $_POST['cooling'],
    'min-fan-speed'=> $_POST['min-fan-speed'],
    'max-fan-speed'=> $_POST['max-fan-speed'],
    'bridge-fan-speed'=> $_POST['bridge-fan-speed'],
    'fan-below-layer-time'=> $_POST['fan-below-layer-time'],
    'slowdown-below-layer-time'=> $_POST['slowdown-below-layer-time'],
    'min-print-speed'=> $_POST['min-print-speed'],
    'disable-fan-first-layers'=> $_POST['disable-fan-first-layers'],
    'fan-always-on'=> $_POST['fan-always-on'],
    'skirts'=> $_POST['skirts'],
    'skirt-distance'=> $_POST['skirt-distance'],
    'skirt-height'=> $_POST['skirt-height'],
    'min-skirt-length'=> $_POST['min-skirt-length'],
    'brim-width'=> $_POST['brim-width'],
    'interior-brim-width'=> $_POST['interior-brim-width'],
    'scale'=> $_POST['scale'],
    'rotate'=> $_POST['rotate'],
    'duplicate'=> $_POST['duplicate'],
    'duplicate-grid'=> $_POST['duplicate-grid'],
    'duplicate-distance'=> $_POST['duplicate-distance'],
    'xy-size-compensation'=> $_POST['xy-size-compensation'],
    'complete-objects'=> $_POST['complete-objects'],
    'extruder-clearance-radius'=> $_POST['extruder-clearance-radius'],
    'extruder-clearance-height'=> $_POST['extruder-clearance-height'],
    'resolution'=> $_POST['resolution'],
    'extrusion-width' => $_POST['extrusion-width' ],
    'first-layer-extrusion-width'=> $_POST['first-layer-extrusion-width'],
    'perimeter-extrusion-width'=> $_POST['perimeter-extrusion-width'],
    'external-perimeter-extrusion-width'=> $_POST['external-perimeter-extrusion-width'],
    'infill-extrusion-width'=> $_POST['infill-extrusion-width'],
    'solid-infill-extrusion-width'=> $_POST['solid-infill-extrusion-width'],
    'top-infill-extrusion-width'=> $_POST['top-infill-extrusion-width'],
    'support-material-extrusion-width'=> $_POST['support-material-extrusion-width'],
    'infill-overlap'=> $_POST['infill-overlap'],
    'bridge-flow-ratio'=> $_POST['bridge-flow-ratio'],
    'perimeter-extruder'=> $_POST['perimeter-extruder'],
    'infill-extruder'=> $_POST['infill-extruder'],
    'solid-infill-extruder'=> $_POST['solid-infill-extruder'],
    'support-material-extruder'=> $_POST['support-material-extruder'],
    'support-material-interface-extruder'=> $_POST['support-material-interface-extruder'],
    'ooze-prevention'=> $_POST['ooze-prevention'],
    'standby-temperature-delta'=> $_POST['standby-temperature-delta']
    );
    return $cnt;
}
?>
