<? session_start(); ?>
<?

if (isset($_POST['renderfromjscad'])){
//echo "testing";
$jscadfile =  $_SESSION['jscadfilename'];
system("openjscad uploads/".$jscadfile." -o uploads/rendered_".preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename']));
exec('sudo chown www-data:www-data uploads/mod.'.$_SESSiON['objectsactive']);
$_SESSION['objectsactive'] = preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename']);
$_SESSION['fromstl'] = 0;
echo '<br>'.$jscadfile.'<br>';
}
?>
