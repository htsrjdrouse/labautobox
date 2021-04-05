<h4>Select JSCAD file:</h4><br>
<? if((isset($_GET['id']))and($_GET['id']=="download")){?>
<a href="rendered/rendered_<?=preg_replace("/.jscad$/", ".stl",$_SESSION['jscadfilename'])?>" class="btn btn-sm btn-success" role="button" aria-pressed="true">Download Rendered STL</a><br>
<? } ?><br>
 <?$jdir = scandir("uploads/"); ?>
<? $djdir = array(); foreach($jdir as $jd){ ?>
<? if (preg_match("/^.*.jscad$/", $jd)){ array_push($djdir, $jd); }?>
<? } ?>
 <? $size = count($djdir);
  if (count($djdir) > 10){ $size=10; }
 ?>
<? $_SESSION['jscadlist'] = $djdir;?>
<form action=objects.json.form.php method=post>
 <select class="form-control form-control-sm" name="objectlist" size=<?=$size?>>
  <? foreach($djdir as $key => &$val){ ?>
  <? if ($val == $_SESSION['jscadfilename']) { ?> 
   <option value=<?=$key?> selected><?=$val?></option>
  <? } else { ?>
   <option value=<?=$key?>><?=$val?></option>
  <? } ?>
 <? } ?>
 </select>
<br>
  <button type="submit" name="selectjscad" class="btn-sm btn-primary">Select file</button> 
&nbsp;
&nbsp;
 <button type="submit" name="deletejscad" class="btn-sm btn-danger">Delete file</button>
&nbsp;
&nbsp;
<? if(isset($_SESSION['jscadfilename'])){ ?>
<button type="submit" name="renderfromjscad" class="btn-sm btn-success">Render to STL</button>
<? } ?>
</form>
<br>

