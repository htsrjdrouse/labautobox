<? session_start(); ?>
<? //include('blabber.inc.php');?>
<? //include('tcaro.php'); ?>

<?

//include('uCP4.1.lineitems.php');
?>
 <?php //include('bbs.navlist.php'); ?>

Objects <? echo $_SESSION['objectsactive'];?><br>


<?
//var_dump($lineitems);

 //$pid = "silicon_master_10um_quadrant.jscad";
 //$dir = "/3dviewer/cellprom/recenter.";
  //$dir = "3dviewer/cellprom/";
  $dir = "uploads/";
  //$pid = "Lower_Lattice_Cube.jscad";
  //$pid = "tttt.jscad";
  //$pid = "aba.jscad";
  //$pid = "dev.jscad";
  $pid = "arducam_case_rtPCR.jscad";
  //$dir = "3dviewer/cellprom/";
  //$pid = "vvv.jscad";
 $id = $dir.$pid;

include('ddiver.3dviewer.php'); 

?>
