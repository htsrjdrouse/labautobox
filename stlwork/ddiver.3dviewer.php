<!--

== OpenJSCAD.org, Copyright (c) 2016, Licensed under MIT License ==
   in conjunction with other libraries by various authors (see the individual files)

Purpose:
  This application provides an example of how to show JSCAD designs with minimal HTML and CSS.

History:
  2016/06/27: 0.5.1: Changes for 0.5.1 libraries by Z3 Dev
  2016/05/01: 0.5.0: Changes for 0.5.0 libraries by Z3 Dev
  2016/02/02: 0.4.0: Initial version by Z3 Dev

-->
<?//$path = "/3dviewer/";?>
<?$path = "";?>
<!--<head>-->
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<script src="<?=$path?>jquery/jquery-1.9.1.js?0.5.1"></script>
<script src="<?=$path?>jquery/jquery.hammer.js?0.5.1"></script>
<script src="<?=$path?>lightgl.js"></script>
<script src="<?=$path?>csg.js?0.5.1"></script>
<script src="<?=$path?>formats.js?0.5.1"></script>
<script src="<?=$path?>openjscad.js?0.5.1"></script>
<script src="<?=$path?>openscad.js?0.5.1"></script>
<script src="<?=$path?>js/jscad-worker.js?0.5.1" charset="utf-8"></script>
<script src="<?=$path?>js/jscad-function.js?0.5.1" charset="utf-8"></script>
<link rel="stylesheet" href="<?=$path?>min.css?0.5.1" type="text/css">
<!--</head>-->

<!--<body onload="loadProcessor()">-->
<!-- setup display of the errors as required by OpenJSCAD.js -->
<!--<body> -->

<? //$a = "yes"; ?>
<? if ($a = 1) { ?>
<!--Do you have <a href=https://get.webgl.org/>WebGL</a>?-->
<script>
$(function() {
 /*
  var queryDict = {};
  location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]})
  console.log("testing "+queryDict['vid']);
  console.log("testing "+queryDict['jjd']);
   var photo = queryDict['jjd'];
    console.log("photo sanity ");
    console.log(photo);
  if (photo == "yes") {
  }
  */
    loadProcessor();
});
</script>
<? } ?>
<script>
$(function(){
	$('div[onload]').trigger('onload');
});
</script>

<!--<div onload="$(this).text('Hello world in Div using text() just a check');"></div>-->
<div onload="$(this).loadProcessor()"></div>


  <div class="jscad-container">
    <div id="header">
      <div id="errordiv"></div>
    </div>

<!-- setup display of the viewer, i.e. canvas -->
    <div oncontextmenu="return false;" id="viewerContext"></div>

<!-- setup display of the design parameters, as required by OpenJSCAD.js -->
<!-- set display: block to display this -->
    <div id="parametersdiv" style="display: none;"></div>

<!-- setup display of the status, as required by OpenJSCAD.js -->
<!-- set display: block to display this -->
    <div id="tail" style="display: none;">
      <div id="statusdiv"></div>
    </div>
  </div>

<!-- define the design and the parameters -->
  <script type="text/javascript">
    var gProcessor = null;        // required by OpenJScad.org

    //var gComponents = [ { file: 'stls/openmv_camera_lensmount.jscad' } ];
    var gComponents = [ { file: '<?=$id?>' } ];

    function loadProcessor() {
      gProcessor = new OpenJsCad.Processor(document.getElementById("viewerContext"));

      loadJSCAD(0);
    }

    function loadJSCAD(choice) {
      var filepath = gComponents[choice].file;
      var xhr = new XMLHttpRequest();
      xhr.open("GET", filepath, true);
      gProcessor.setStatus("Loading "+filepath+" <img id=busy src='imgs/busy.gif'>");

      xhr.onload = function() {
        var source = this.responseText;
        //console.log(source);

        if(filepath.match(/\.jscad$/i)||filepath.match(/\.js$/i)) {
          gProcessor.setStatus("Processing "+filepath+" <img id=busy src='imgs/busy.gif'>");
          gProcessor.setJsCad(source,filepath);
        }
      }
      xhr.send();
    }
  </script>

<!--
</body>

</html> 
-->
