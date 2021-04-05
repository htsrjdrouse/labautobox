<? //session_start(); ?>
<? //include('blabber.inc.php');?>
<? //include('tcaro.php'); ?>

<?

//include('uCP4.1.lineitems.php');
?>
 <?php //include('bbs.navlist.php'); ?>

<?
//var_dump($lineitems);

 //$pid = "silicon_master_10um_quadrant.jscad";
 //$dir = "/3dviewer/cellprom/recenter.";
  //$dir = "3dviewer/cellprom/";
  $dir = "uploads/";
  //$pid = "Lower_Lattice_Cube.jscad";
//$pid = "tt.jscad";
//
/*
  if(!isset($_SESSION['fromstl'])){ $_SESSION['fromstl'] = 1; } 
  if($_SESSION['fromstl'] == 1){ 
	  $pid = preg_replace("/stl$|STL$/", "jscad", $_SESSION['objectsactive']);
  } else {
    $pid = $_SESSION['jscadfilename'];
  }
*/
    $pid = $_SESSION['jscadfilename'];
  //$dir = "3dviewer/cellprom/";
//$pid = "vvv.jscad";
//
 //$pid = "013.jscad";
 $id = $dir.$pid; //.'?'.date('l jS \of F Y h:i:s A');
?>
<ul><font size=1><b>
Rotate XZ	Left Mouse<br>
Pan	Middle Mouse or SHIFT + Left Mouse<br>
Rotate XY	Right Mouse or ALT + Left Mouse<br>
Zoom In/Out	Wheel Mouse or CTRL + Left Mouse<br>
</b></font></ul>
<?
include('ddiver.3dviewer.php'); 

?>
