<? session_start(); ?>
<h2>Edit and Run Macro</h2>
<form action=program.editor.php method=post>
<? if(!isset($_SESSION['cmdlist'])){ 
 $pprog = json_decode(file_get_contents('labbot.programtorun.json'), true);
 $prog = $pprog['program'];
 } else {  $prog = $_SESSION['cmdlist']; }?>
<br>
<table cellpadding=10><tr><td>
<textarea name="macrofiledata" rows="14" cols="40">
<?
 if(isset($prog)){
  foreach($prog as $gg){
   $gg = preg_replace("/^\s/", "", $gg);
   $gg = preg_replace("/\r|\n/", "", $gg);
   $gg= preg_replace("/^\s+/","",$gg);
   if (strlen($gg) > 1){
    echo preg_replace("/'/","",$gg).'&#013;&#010';
   }
  }
 }
 ?>
</textarea>
<br>
<? if((isset($_SESSION['runmacro']))and($_SESSION['runmacro'] == 1)){ ?>
//echo "run macro"; 
<? 
foreach($prog as $pp){
 $pp = preg_replace("/\r|\n/", "", $pp);
 if(!preg_match("/^\/\/.*$/", $pp)){
   //echo $pp.'<br>';
   if(preg_match("/^sg1e.*/", $pp)){ 
     preg_match("/^sg1e(.*)s(.*)a(.*)_.*$/", $pp, $ar);
     $_SESSION['microliter'] = $ar[1];
     $_SESSION["syringespeed"]= $ar[2];
     $_SESSION["syringeacceleration"]= $ar[3];
   }
   if(preg_match("/^valve.*/", $pp)){ 
     preg_match("/^valve-(.*)-(.*)$/", $pp, $ar);
     $_SESSION['labbot3d']['tiplist'] = (preg_split("/_/", $ar[1]));
     $_SESSION['labbot3d']['valvepos'] = $ar[2];
   }
 }
}

} 
?>

<? $_SESSION['runmacro'] = 0; ?>
<br>

</td><td valign=top>
 &nbsp;&nbsp;<button type="submit" name=savemacro class="btn-xs btn-primary">Save Macro</button><br><br>
 &nbsp;&nbsp;<button type="submit" name=runmacro class="btn-xs btn-success">Run Macro</button><br><br>
<br><br>
&nbsp;&nbsp;<button type="submit" name=storemacro class="btn-xs btn-danger">Store Macro</button><br>
<br> &nbsp;&nbsp;<input type=text name=custommacroname size=15>
</td></tr></table>
</form>






