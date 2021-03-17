
<?
      $masters = array(
        array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_donut_other_ring_20_micron_inner_ring_10_micron.png",
	"alt"=>"PDMS stamp donut 20 micron outer and 10 inner",
         "order"=>"first",
        "desc"=>'Donut outer 20 &micro;m inner 10 &micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_donut_other_ring_30_micron_inner_ring_20_micron.png",
        "alt"=>"PDMS stamp donut 30 micron outer and 20 inner",
         "order"=>"second",
        "desc"=>'Donut outer 30 &micro;m inner 20 &micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_donut_other_ring_50_micron_inner_ring_30_micron.png", 
	"alt"=>"PDMS stamp donut 50 micron outer and 30 inner",
         "order"=>"third",
        "desc"=>'Donut outer 50 &micro;m inner 30 &micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_foot_2_by_5_micron.png", 
	"alt"=>"PDMS stamp foot 2 by 5 micron",
         "order"=>"fourth",
        "desc"=>'Foot 2&micro;m x 5&micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_football_2_by_5_micron.png", 
	"alt"=>"microcontact silicon and PDMS stamp football 2 by 5 micron",
         "order"=>"fifth",
        "desc"=>'Football shape 2&micro;m x 5&micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_hole_2_micron.png", 
	"alt"=>"microcontact silicon master and PDMS stamp Hole 2 micron",
         "order"=>"sixth",
         "filea"=>"/images/cellprom_master_collection/silicon_master_2µm_hole.png",

        "desc"=>'Hole shape 2&micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_line_10_micron.png", 
	"alt"=>"microcontact silicon master and PDMS stamp Hole 10 micron",
        "desc"=>'Hole shape 10&micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_line_20_micron.png", 
	"alt"=>"microcontact silicon master and PDMS stamp Hole 20 micron",
         "order"=>"seventh",
        "desc"=>'Hole shape 20&micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_line_2_micron.png", 
	"alt"=>"microcontact silicon master and PDMS stamp line 2 micron",
         "order"=>"eighth",
         "filea"=>"/images/cellprom_master_collection/silicon_master_2µm_line.png", 
        "desc"=>'Line shape 2&micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_line_5_micron.png", 
	"alt"=>"microcontact silicon master and PDMS stamp line 5 micron",
         "order"=>"nineth",
        "desc"=>'Line shape 5&micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_mesh_10_micron.png", 
	"alt"=>"microcontact silicon master and PDMS stamp line 10 micron",
         "order"=>"tenth",
        "desc"=>'Line shape 10&micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_mesh_5_micron.png", 
	"alt"=>"microcontact silicon master and PDMS stamp mesh 5 micron",
         "order"=>"eleventh",
        "desc"=>'Mesh shape 5&micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_quadrant_10_micron.png", 
	"alt"=>"microcontact silicon master and PDMS stamp quadrant 10 micron",
         "order"=>"twelth",
        "desc"=>'Quadrant shape 10&micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_quadrant_5_micron.png", 
	"alt"=>"microcontact silicon master and PDMS stamp quadrant 5 micron",
         "order"=>"thirteenth",
        "desc"=>'Quadrant shape 5&micro;m (left: silicon master, right: PDMS stamp)'),
      array("file"=>"/images/microcon/masters/microcontact_master_pdms_stamp_banger_2_by_5_micron.png", 
	"alt"=>"silicon masters banger 2 by 5 micron shape",
         "order"=>"fourteenth",
        "desc"=>'Banger shape 2x5 micron (left: silicon master, right: PDMS stamp)')
	);


$features = array();
$ct = -1;
foreach($masters as $mm){
 $ct = $ct + 1;
 array_push($features,array(
                 "order"=>$mm['order'],
		 "file"=> $mm['file'],
	  	 "desc"=> $mm['desc'])
 );
}

      $amasters = array(
array("desca"=>"Anthroplas 230nm pillar" ,"filea"=>"/images/cellprom_master_collection/silicon_master_230nm_pillar.png", "details"=>"Using PDMS stamp NIL imprint conducted in resist film of 500-2000nm SU8-5, resulting in raised pillars (UV-curing 365-420nm, 10s exposure). Stable when heated after UV-polymerization. Pillars are too small to see using 3D viewer.","size"=>"3mm x 3mm"),
array("desca"=>"CellProm 2µm hole" ,"filea"=>"/images/cellprom_master_collection/silicon_master_2µm_hole.png"),
array("desca"=>"CellProm 2µm line" ,"filea"=>"/images/cellprom_master_collection/silicon_master_2µm_line.png"),
array("desca"=>"CellProm 2µm diameter pillar height 4-5µm" ,"filea"=>"/images/cellprom_master_collection/silicon_master_2µm_pillar.png", "details"=>"Using PDMS stamp NIL imprint conducted in resist film of 500-2000nm SU8-5, resulting in raised pillars (UV-curing 365-420nm, 10s exposure). Stable when heated after UV-polymerization.","size"=>"10mm x 10mm"),

array("desca"=>"CellProm 5µm banger" ,"filea"=>"/images/cellprom_master_collection/silicon_master_5µm_banger.png"),
array("desca"=>"CellProm 5µm foots" ,"filea"=>"/images/cellprom_master_collection/silicon_master_5µm_foots.png"),
array("desca"=>"CellProm 5µm line" ,"filea"=>"/images/cellprom_master_collection/silicon_master_5µm_line.png"),
array("desca"=>"CellProm 5µm mesh" ,"filea"=>"/images/cellprom_master_collection/silicon_master_5µm_mesh.png"),
array("desca"=>"CellProm 5µm quadrant" ,"filea"=>"/images/cellprom_master_collection/silicon_master_5µm_quadrant.png"),
array("desca"=>"CellProm 10µm football" ,"filea"=>"/images/cellprom_master_collection/silicon_master_10µm_football.png"),
array("desca"=>"CellProm 10µm line" ,"filea"=>"/images/cellprom_master_collection/silicon_master_10µm_line.png"),
array("desca"=>"CellProm 10µm mesh" ,"filea"=>"/images/cellprom_master_collection/silicon_master_10µm_mesh.png"),
array("desca"=>"CellProm 10µm quadrant" ,"filea"=>"/images/cellprom_master_collection/silicon_master_10µm_quadrant.png"),
array("desca"=>"CellProm 20µm donuts" ,"filea"=>"/images/cellprom_master_collection/silicon_master_20µm_donuts.png"),
array("desca"=>"CellProm 20µm line" ,"filea"=>"/images/cellprom_master_collection/silicon_master_20µm_line.png"),
array("desca"=>"CellProm 30µm donuts" ,"filea"=>"/images/cellprom_master_collection/silicon_master_30µm_donuts.png"),
array("desca"=>"CellProm 50µm donuts" ,"filea"=>"/images/cellprom_master_collection/silicon_master_50µm_donuts.png"),

array("desca"=>"Hexagonal wells base 13&micro;m wall thickness 2.5&micro;m depth 15&micro;", "filea"=>"hexwells/hexwells_PCS_13micron_thick_2_5_depth_15.jscad"),
array("desca"=>"Hexagonal wells base 15.5&micro;m wall thickness 2.5&micro;m depth 15&micro;", "filea"=>"hexwells/hexwells_PCS_15_5micron_thick_2_5_depth_15_ctc_15.jscad"),
array("desca"=>"Hexagonal wells base 20&micro;m wall thickness 5&micro;m depth 30&micro;", "filea"=>"hexwells/hexwells_PCS_20micron_base.jscad", "structurepic"=>"/images/20_micrometer_hexwell.PNG"),
array("desca"=>"Hexagonal wells base 25&micro;m wall thickness 5&micro;m depth 30&micro;", "filea"=>"hexwells/hexwells_PCS_20micron_base.jscad", "filea"=>"hexwells/hexwells_PCS_25micron_base.jscad", "structurepic"=>"/images/25_micrometer_hexwell_w.png"),
array("desca"=>"Hexagonal wells base 7.5&micro;m wall thickness 2&micro;m depth 15&micro;", "filea"=>"hexwells/hexwells_PCS_7_5micron_thick_2_depth_15.jscad"),
array("desca"=>"Hexagonal wells base 9.5&micro;m wall thickness 2.5&micro;m depth 15&micro;", "filea"=>"hexwells/hexwells_PCS_9_5micron_thick_2_5_depth_15.jscad"),
array("desca"=>"Hexagonal well base 250&micro;m wall thickness 5&micro;m depth 100&micro;m", "filea"=>"hexwells/hexwells_PCS_C250.jscad", "structurepic"=>"/images/picowells/hexagonal/hexagonal_picowell_example_dimensions.png", "explanpic"=>"/images/picowells/hexagonal/hexagonal_shaped_picowells.png", "examplepic"=>"/images/picowells/hexagonal/hexagonal_picowell_example_cells.png")

);

$featuresa = array();
$ct = -1;
foreach($amasters as $mm){
 $ct = $ct + 1;
 array_push($featuresa,array(
		 "file"=> $mm['filea'],
	  	 "desc"=> $mm['desca'])
 );
}


?>






