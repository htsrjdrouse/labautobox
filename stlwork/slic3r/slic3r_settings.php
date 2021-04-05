<? session_start(); ?>

<?	$slic3rconfig= array(
    	    "printer_options"=>array(
		"nozzle-diameter"=>"0.5",
		"print-center"=>"100,100",
		"z-offset"=>"0",
		"use-relative-e-distances"=>"",
		"use-firmware-retraction"=>"",
		"use-volumetric-e"=>""
	     ),
	     "filament_options"=>array(
		"filament-diameter"=>"1.75",
		"extrusion-multiplier"=>"1",
		"temperature"=>"200",
		"first-layer-temperature"=>"200",
		"bed-temperature"=>"60",
		"first-layer-bed-temperature"=>"60"
	     ),
	     "speed_options"=>array(
		"travel-speed"=>"130",
		"perimeter-speed"=>"60",
		"small-perimeter-speed"=>"15",
		"external-perimeter-speed"=>"50%",
		"infill-speed"=>"80",
		"solid-infill-speed"=>"20",
		"top-solid-infill-speed"=>"15",
		"support-material-speed"=>"60",
		"support-material-interface-speed"=>"100",
		"bridge-speed"=>"60",
		"gap-fill-speed"=>"20",
		"first-layer-speed"=>"30"
	      ),
	     "acceleration_options"=>array(
		"perimeter-acceleration"=>"0",
		"infill-acceleration"=>"0",
		"bridge-acceleration"=>"0",
		"first-layer-acceleration"=>"0",
		"default-acceleration"=>"0"
	     ),
	     "print_options"=>array(
		"layer-height"=>"3",      
		"first-layer-height"=>"0.35", 
		"infill-every-layers"=>"1",
		"solid-infill-every-layers"=>"0",
		"perimeters"=>"3",
		"top-solid-layers"=>"3",
		"bottom-solid-layers"=>"3",
		"solid-layers"=>"3",
		"fill-density"=>"20%",
		"fill-angle"=>"45",
		"fill-pattern"=>"stars",
		"fill-gaps"=>"yes",
		"top-infill-pattern"=>"rectilinear",
		"bottom-infill-pattern"=>"rectilinear",
		"before-layer-gcode"=>"",
		"layer-gcode"=>"",
		"toolchange-gcode"=>"",
		"seam-position"=>"aligned",
		"external-perimeters-first"=>"no", 
		"spiral-vase"=>"no",       
		"only-retract-when-crossing-perimeters"=>"no",
		"solid-infill-below-area"=>"70",
		"infill-only-where-needed"=>"no",
		"infill-first"=>"no"
	     ),
	     "quality_options"=>array(
		"extra-perimeters"=>"yes",
		"avoid-crossing-perimeters"=>"no",
		"thin-walls"=>"yes",
		"detect-bridging-perimeters"=>"yes"
	     ),
	     "support_material_options"=>array(
		"support-material"=>"",
		"supportmaterialthreshold"=>"60",
		"support-material-pattern"=>"pillars",
		"support-material-spacing"=>"2.5",
		"support-material-angle"=>"0",
		"support-material-contact-distance"=>"0.2",
		"support-material-interface-layers"=>"3",
		"support-material-interface-spacing"=>"0",
		"raft-layers"=>"0",
		"support-material-enforce-layers"=>"0",
		"support-material-and-threshold"=>"0",
		"support-material-buildplate-only"=>"no",
		"dont-support-bridges"=>"yes"
	     ),
	     "retraction_options"=>array(
		"retract-length"=>"2",
		"retract-speed"=>"40",
		"retract-restart-extra"=>"0",
		"retract-before-travel"=>"2",
		"retract-lift"=>"0",
		"retract-lift-above"=>"0",
		"retract-lift-below"=>"0",
		"retract-layer-change"=>"no",
		"wipe"=>"no"
	      ),
	      "retraction_options_multiextruder"=>array(
		"retract-length-toolchange"=>"10",
		"retract-restart-extra-toolchange"=>"0"
	      ),
	      "cooling_options"=>array(
		"cooling"=>"",
		"min-fan-speed"=>"35%",
		"max-fan-speed"=>"100%",
		"bridge-fan-speed"=>"100%",
		"fan-below-layer-time"=>"60",
		"slowdown-below-layer-time"=>"5",
		"min-print-speed"=>"10",
		"disable-fan-first-layers"=>"3",
		"fan-always-on"=>""
	       ),
	      "skirt_options"=>array(
		"skirts"=>"1",
		"skirt-distance"=>"6",
		"skirt-height"=>"1",
		"min-skirt-length"=>"0",
		"brim-width"=>"0",
		"interior-brim-width"=>"0"
	      ),
	      "transform_options"=>array(
		"scale"=> "1",
		"rotate"=>"0",
		"duplicate"=>"1",
		"duplicate-grid"=>"1,1",
		"duplicate-distance"=>"6",
		"xy-size-compensation"=>"0"
	      ),
	      "sequential_printing_options"=>array(
		"complete-objects"=>"no",
		"extruder-clearance-radius"=>"20",
		"extruderclearanceheight"=>"20"
	      ),
	      "miscellaneous_options"=>array(
		"notes"=>"",
		"resolution"=>"0"
	      ),
	      "flow_options"=>array(
		"extrusion-width"=>"1", 
		"first-layer-extrusion-width"=>"1",
		"perimeter-extrusion-width"=>"1",
		"external-perimeter-extrusion-width"=>"1",
		"infill-extrusion-width"=>"1",
		"solid-infill-extrusion-width"=>"1",
		"top-infill-extrusion-width"=>"1",
		"support-material-extrusion-width"=>"1",
		"infill-overlap"=>"55%",
		"bridge-flow-ratio"=>"1" 
	       ),
	      "multiple_extruder_options"=>array(
		"extruder-offset"=>"0x0",
		"perimeter-extruder"=>"1",
		"infill-extruder"=>"1",
		"solid-infill-extruder"=>"1",
		"support-material-extruder"=>"1",
		"support-material-interface-extruder"=>"1",
		"ooze-prevention"=>"no",
		"standby-temperature-delta"=>"-5"
	       )
	);
 ?>
<b>Slic3R CLI <a href=slic3r/slic3r_manual.php>Reference</a></b>
 <br>
<? 
	$varname = array(
    	    "printer_options"=>array(
		"nozzle-diameter",
		"print-center",
		"z-offset",
		"use-relative-e-distances",
		"use-firmware-retraction",
		"use-volumetric-e"
	     ),
	     "filament_options"=>array(
		"filament-diameter",
		"extrusion-multiplier",
		"temperature",
		"first-layer-temperature",
		"bed-temperature",
		"first-layer-bed-temperature"
	     ),
	     "speed_options"=>array(
		"travel-speed",
		"perimeter-speed",
		"small-perimeter-speed",
		"external-perimeter-speed",
		"infill-speed",
		"solid-infill-speed",
		"top-solid-infill-speed",
		"support-material-speed",
		"support-material-interface-speed",
		"bridge-speed",
		"gap-fill-speed",
		"first-layer-speed"
	      ),
	     "acceleration_options"=>array(
		"perimeter-acceleration",
		"infill-acceleration",
		"bridge-acceleration",
		"first-layer-acceleration",
		"default-acceleration"
	     ),
	     "print_options"=>array(
		"layer-height",      
		"first-layer-height", 
		"infill-every-layers",
		"solid-infill-every-layers",
		"perimeters",
		"top-solid-layers",
		"bottom-solid-layers",
		"solid-layers",
		"fill-density",
		"fill-angle",
		"fill-pattern",
		"fill-gaps",
		"top-infill-pattern",
		"bottom-infill-pattern",
		"before-layer-gcode",
		"layer-gcode",
		"toolchange-gcode",
		"seam-position",
		"external-perimeters-first", 
		"spiral-vase",       
		"only-retract-when-crossing-perimeters",
		"solid-infill-below-area",
		"infill-only-where-needed",
		"infill-first"
	     ),
	     "quality_options"=>array(
		"extra-perimeters",
		"avoid-crossing-perimeters",
		"thin-walls",
		"detect-bridging-perimeters"
	     ),
	     "support_material_options"=>array(
		"support-material",
		"supportmaterialthreshold",
		"support-material-pattern",
		"support-material-spacing",
		"support-material-angle",
		"support-material-contact-distance",
		"support-material-interface-layers",
		"support-material-interface-spacing",
		"raft-layers",
		"support-material-enforce-layers",
		"support-material and threshold",
		"support-material-buildplate-only",
		"dont-support-bridges"
	     ),
	     "retraction_options"=>array(
		"retract-length",
		"retract-speed",
		"retract-restart-extra",
		"retract-before-travel",
		"retract-lift",
		"retract-lift-above",
		"retract-lift-below",
		"retract-layer-change",
		"wipe"
	      ),
	      "retraction_options_multiextruder"=>array(
		"retract-length-toolchange",
		"retract-restart-extra-toolchange"
	      ),
	      "cooling_options"=>array(
		"cooling",
		"min-fan-speed",
		"max-fan-speed",
		"bridge-fan-speed",
		"fan-below-layer-time",
		"slowdown-below-layer-time",
		"min-print-speed",
		"disable-fan-first-layers",
		"fan-always-on"
	       ),
	      "skirt_options"=>array(
		"skirts",
		"skirt-distance",
		"skirt-height",
		"min-skirt-length",
		"brim-width",
		"interior-brim-width"
	      ),
	      "transform_options"=>array(
		"scale",
		"rotate",
		"duplicate",
		"duplicate-grid",
		"duplicate-distance",
		"xy-size-compensation"
	      ),
	      "sequential_printing_options"=>array(
		"complete-objects",
		"extruder-clearance-radius",
		"extruderclearanceheight"
	      ),
	      "miscellaneous_options"=>array(
		"notes",
		"resolution"
	      ),
	      "flow_options"=>array(
		"extrusion-width", 
		"first-layer-extrusion-width",
		"perimeter-extrusion-width",
		"external-perimeter-extrusion-width",
		"infill-extrusion-width",
		"solid-infill-extrusion-width",
		"top-infill-extrusion-width",
		"support-material-extrusion-width",
		"infill-overlap",
		"bridge-flow-ratio" 
	       ),
	      "multiple_extruder_options"=>array(
		"extruder-offset",
		"perimeter-extruder",
		"infill-extruder",
		"solid-infill-extruder",
		"support-material-extruder",
		"support-material-interface-extruder",
		"ooze-prevention",
		"standby-temperature-delta"
		)
        );

?>
<? 
	$varheader = array(
    	    "printer_options",
	    "filament_options",
	    "speed_options",
	    "acceleration_options",
	    "print_options",
	    "quality_options",
	    "support_material_options",
	    "retraction_options",
	    "retraction_options_multiextruder",
	    "cooling_options",
	    "skirt_options",
	    "transform_options",
	    "sequential_printing_options",
	    "miscellaneous_options",
	    "flow_options",
	    "multiple_extruder_options");
?>


<? $hh="Settings";?>
 <form action="slic3r/slic3r_varcatch.php" method="post">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?=$hh?>">
       <b>&nbsp;&nbsp;<?=preg_replace("/_/", " ", $hh)?></b>
      </a>
    </div>
    <div id="collapse<?=$hh?>" class="accordion-body collapse">
   <div class="accordion-inner">
    <b><? slicer_accord($varname,$varheader,$slic3rconfig); ?></b>
   </div>
 </div>
</div>
<input type=text name="slic3rconfig" value="" size=10><br>
<button type="submit" name="saveconfig" class="btn-sm btn-danger">Save config file</button>
</form>
<br>
<?  $configjson = json_decode(file_get_contents('slic3r/slic3rconfigfiles.json'), true);
if (count($configjson['file'])>3){ $size=3; } else { $size = count($configjson['file']);}
?>
<div class="row">
<div class="col-sm-7">
 <? $ddir = $configjson['file'];?>
 <select class="form-control form-control-sm" name="configlist" size=<?=$size?>>
  <? foreach($ddir as $key => &$val){ ?>
  <? if ($val == $_SESSION['configactive']) { ?> 
   <option value=<?=$key?> selected><?=$val?></option>
  <? } else { ?>
   <option value=<?=$key?>><?=$val?></option>
  <? } ?>
  <? } ?>
 </select>
</div>
<div class="col-sm-5">
<button type="submit" name="selectconfig" class="btn-sm btn-success">Select</button><br><br>
<a href="slic3r/slic3rconfig_management.php" class="btn btn-sm btn-warning" role="button" aria-pressed="true">Manage</a>
</div>
</div>



<?
function slicer_accord($varname,$varheader,$slic3rconfig){
?>
<ul>
<div class="accordion" id="accordion2">
<? foreach($varheader as $hh){ ?>
<? //$hh = "printer_options"; ?>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?=$hh?>">
      <b><?=ucwords(preg_replace("/_/", " ",$hh))?></b>
      </a>
    </div>
    <div id="collapse<?=$hh?>" class="accordion-body collapse">
   <div class="accordion-inner">
   <? foreach($varname[$hh] as $var){ ?>
    <?=$var?>&nbsp;<input name="<?=$var?>" type="text" size=3 value="<?=$slic3rconfig[$hh][$var]?>" style="text-align:right;font-size:12px;"/><br>
   <? } ?> 
   </div>
 </div>
</div>
<? } ?> 
</ul>
<? } ?>
