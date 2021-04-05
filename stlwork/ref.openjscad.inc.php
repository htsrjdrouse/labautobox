
<b>OpenJSCAD Reference</b><ul>

<div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapsePrg">
      <b>Programming structure</b>
      </a>
    </div>
    <div id="collapsePrg" class="accordion-body collapse">
   <div class="accordion-inner">
  An OpenJSCAD script must have at least one function defined, the main() function, which has to return a CSG object, or an array of non-intersecting CSG objects. 
 <pre><code>
function main() {
   return union(sphere(), ...);    // an union of objects or
   return [sphere(), ...];        // an array of non-intersecting objects
}
 </code></pre>
or like this:
 <pre><code>
var w = new Array();
function a() {
   w.push( sphere() );
   w.push( cube().translate([2,0,0]) );
}
function main() {
   a();
   return w;
}
 </code></pre>
      </div>
    </div>
  </div>




  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseObj">
      <b>Objects</b>
      </a>
    </div>
    <div id="collapseObj" class="accordion-body collapse">
   <div class="accordion-inner">
      <?include('ref.openjscad.objects.inc.php')?>
      </div>
    </div>
  </div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTrans">
      <b>Transformations</b>
      </a>
    </div>
    <div id="collapseTrans" class="accordion-body collapse">
   <div class="accordion-inner">
      <?include('ref.openjscad.transformations.inc.php')?>
      </div>
    </div>
  </div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2D">
      <b>2D</b>
      </a>
    </div>
    <div id="collapse2D" class="accordion-body collapse">
   <div class="accordion-inner">
      <?include('ref.openjscad.2D.inc.php')?>
      </div>
    </div>
  </div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseProperties">
      <b>Properties</b>
      </a>
    </div>
    <div id="collapseProperties" class="accordion-body collapse">
   <div class="accordion-inner">
The 'property' property of a solid can be used to store metadata for the object, for example the coordinate of a specific point of interest of the solid. Whenever the object is transformed (i.e. rotated, scaled or translated), the properties are transformed with it. So the property will keep pointing to the same point of interest even after several transformations have been applied to the solid.
<br>
Properties can have any type, but only the properties of classes supporting a 'transform' method will actually be transformed. This includes CSG.Vector3D, CSG.Plane and CSG.Connector. In particular CSG.Connector properties (see below) can be very useful: these can be used to attach a solid to another solid at a predetermined location regardless of the current orientation.
<br>
It's even possible to include a CSG solid as a property of another solid. This could be used for example to define the cutout cylinders to create matching screw holes for an object. Those 'solid properties' get the same transformations as the owning solid but they will not be visible in the result of CSG operations such as union().
<br>
Other kind of properties (for example, strings) will still be included in the properties of the transformed solid, but the properties will not get any transformation when the owning solid is transformed.
<br>
All primitive solids have some predefined properties, such as the center point of a sphere (TODO: document).
<br>
The solid resulting from CSG operations (union(), subtract(), intersect()) will get the merged properties of both source solids. If identically named properties exist, only one of them will be kept.

 <pre><code>

var cube = CSG.cube({radius: 1.0});
cube.properties.aCorner = new CSG.Vector3D([1, 1, 1]);
cube = cube.translate([5, 0, 0]);
cube = cube.scale(2);
// cube.properties.aCorner will now point to [12, 2, 2],
// which is still the same corner point 

// Properties can be stored in arrays; all properties in the array
// will be transformed if the solid is transformed:
cube.properties.otherCorners = [
  new CSG.Vector3D([-1, 1, 1]),
  new CSG.Vector3D([-1, -1, 1])
];

// and we can create sub-property objects; these must be of the 
// CSG.Properties class. All sub properties will be transformed with
// the solid:
cube.properties.myProperties = new CSG.Properties();
cube.properties.myProperties.someProperty = new CSG.Vector3D([-1, -1, -1]);

 </code></pre>
      </div>
    </div>
  </div>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseConnectors">
      <b>Connectors</b>
      </a>
    </div>
    <div id="collapseConnectors" class="accordion-body collapse">
   <div class="accordion-inner">
The CSG.Connector class is intended to facilitate attaching two solids to each other at a predetermined location and orientation. For example suppose we have a CSG solid depicting a servo motor and a solid of a servo arm: by defining a Connector property for each of them, we can easily attach the servo arm to the servo motor at the correct position (i.e. the motor shaft) and orientation (i.e. arm perpendicular to the shaft) even if we don't know their current position and orientation in 3D space.
<br>
In other words Connector give us the freedom to rotate and translate objects at will without the need to keep track of their positions and boundaries. And if a third party library exposes connectors for its solids, the user of the library does not have to know the actual dimensions or shapes, only the names of the connector properties.
<br>
A CSG.Connector consist of 3 properties:
<ul>
<li>point: a CSG.Vector3D defining the connection point in 3D space</li>
<li>axis: a CSG.Vector3D defining the direction vector of the connection (in the case of the servo motor example it would point in the direction of the shaft)</li>
<li>normal: a CSG.Vector3D direction vector somewhat perpendicular to axis; this defines the "12 o'clock" orientation of the connection.</li>
</ul>
When connecting two connectors, the solid is transformed such that the point properties will be identical, the axis properties will have the same direction (or opposite direction if mirror == true), and the normals match as much as possible.
<br>
Connectors can be connected by means of two methods: A CSG solid's connectTo() function transforms a solid such that two connectors become connected. Alternatively we can use a connector's getTransformationTo() method to obtain a transformation matrix which would connect the connectors. This can be used if we need to apply the same transform to multiple solids.
 <pre><code>
var cube1 = CSG.cube({radius: 10});
var cube2 = CSG.cube({radius: 4});

// define a connector on the center of one face of cube1
// The connector's axis points outwards and its normal points
// towards the positive z axis:
cube1.properties.myConnector = new CSG.Connector([10, 0, 0], [1, 0, 0], [0, 0, 1]);

// define a similar connector for cube 2:
cube2.properties.myConnector = new CSG.Connector([0, -4, 0], [0, -1, 0], [0, 0, 1]);

// do some random transformations on cube 1:
cube1 = cube1.rotateX(30);
cube1 = cube1.translate([3.1, 2, 0]);

// Now attach cube2 to cube 1:
cube2 = cube2.connectTo(
  cube2.properties.myConnector, 
  cube1.properties.myConnector, 
  true,   // mirror 
  0       // normalrotation
);

// Or alternatively:
var matrix = cube2.properties.myConnector.getTransformationTo(
  cube1.properties.myConnector, 
  true,   // mirror 
  0       // normalrotation
);
cube2 = cube2.transform(matrix);

var result = cube2.union(cube1);
 </code></pre>
      </div>
    </div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseBounds">
      <b>Bounds & Surface Laying</b>
      </a>
    </div>
    <div id="collapseBounds" class="accordion-body collapse">
   <div class="accordion-inner">
The <i>getBounds()</i> function can be used to retrieve the bounding box of an object, returning an array with two CSG.Vector3Ds specifying the minimum X,Y,Z coordinates and the maximum X,Y,Z coordinates.
<br>
The <i>lieFlat()</i> function lays an object onto the Z surface, in such a way that the Z-height is minimized and the object is centered around the Z axis. This can be useful for CNC milling, allowing an object to be transform into the space of the stock material during milling. Or for 3D printing: it is laid in such a way that it can be printed with minimal number of layers. Instead of the lieFlat() function, the <i>getTransformationToFlatLying()</i> function can be used, which returns a CSG.Matrix4x4 for the transformation.
 <pre><code>

var cube1 = CSG.cube({radius: 10});
var cube2 = CSG.cube({radius: 5});

// get the right bound of cube1 and the left bound of cube2:
var deltax = cube1.getBounds()[1].x - cube2.getBounds()[0].x;

// align cube2 so it touches cube1:
cube2  = cube2.translate([deltax, 0, 0]);

var cube3 = CSG.cube({radius: [100,120,10]});
// do some random transformations:
cube3 = cube3.rotateZ(31).rotateX(50).translate([30,50,20]);
// now place onto the z=0 plane:
cube3  = cube3.lieFlat();

// or instead we could have used:
var transformation = cube3.getTransformationToFlatLying();
cube3 = cube3.transform(transformation);

return cube3;

 </code></pre>
      </div>
    </div>



  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseColors">
      <b>Colors</b>
      </a>
    </div>
    <div id="collapseColors" class="accordion-body collapse">
   <div class="accordion-inner">
OpenSCAD-like:
<pre><code>
color([r,g,b], object, object2 ...); // for example, color([1,1,0],sphere());
color([r,g,b], array);
color([r,g,b,a], object, object2 ...);
color([r,g,b,a], array);
color(name, object, object2 ...); // for example, color('red',sphere());
color(name, a, object, object2 ...); // for example, color('red',0.5, sphere());
color(name, array);
color(name, a, array);
</code></pre>
Whereas the named colors are case-insensitive, e.g. 'RED' is the same as 'red'.
<br>
using CSG objects' built in methods (r, g, b must be between 0 and 1, not 0 and 255):
<pre><code>
object.setColor([r,g,b]);
object.setColor([r,g,b,a]);
object.setColor(r,g,b);
object.setColor(r,g,b,a);
object.setColor(css2rgb('dodgerblue'));
</code></pre>

Examples:
<pre><code>
color([1,0.5,0.3],sphere(1));                      // openscad like
color([1,0.5,0.3],sphere(1),cube(2));
color("Red",sphere(),cube().translate([2,0,0]));   // named color (case-insensitive)

sphere().setColor(1,0.5,0.3);                      // built in methods
sphere().setColor([1,0.5,0.3]);
</code></pre>

See the <a href=https://www.w3.org/TR/css-color-3/#svg-color>Extended Color Keywords</a> for all available colors.<bR>
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_colors_examples.PNG">
<br>
Code except:
<pre><code>
o.push( color([1,0,0],sphere()) );
o.push( color([0,1,0],cube()) );
o.push( color([0,0,1],cylinder()) );

o.push( color("red",sphere()) );
o.push( color("green", cube()) );
o.push( color("blue", cylinder()) );

for(var i=0; i&lt;1; i+=1/12) {
   o.push( cube().setColor(hsl2rgb(i,1,0.5)) );
}
</code></pre>
<br>
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_colors1_examples.PNG">
<br>
<pre><code>
function main() {
   var o = [];
   for(var i=0; i&lt;8; i++) {
      o.push(cylinder({r:3,h:20}).
         setColor(
            hsl2rgb(i/8,1,0.5).  // hsl to rgb, creating rainbow [r,g,b]
            concat(1/8+i/8)      // and add to alpha to make it [r,g,b,a]
         ).translate([(i-3)*7.5,0,0])
      );
   }
   o.push(color("red",cube(5)).translate([-4,-10,0]));
   o.push(color("red",0.5,cube(5)).translate([4,-10,0]));
   return o;
}
</code></pre>
<b>Color Spacing Conversion</b><br>
Following functions to convert between color spaces:

<pre><code>
var hsl = rgb2hsl(r,g,b); // or rgb2hsl([r,g,b]);
var rgb = hsl2rgb(h,s,l); // or hsl2rgb([h,s,l]);
var hsv = rgb2hsv(r,g,b); // or rgb2hsv([r,g,b]);
var rgb = hsv2rgb(h,s,v); // or hsv2rgb([h,s,v]);
</code></pre>
whereas
<ul>
<li>r,g,b (red, green, blue)</li>
<li>h,s,l (hue, saturation, lightness)</li>
<li>h,s,v (hue, saturation, value)</li>
</ul>
E.g. to create a rainbow, t = 0..1 and .setColor(hsl2rgb(t,1,0.5))
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_colors2_examples.PNG">

      </div>
    </div>
  </div>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseEcho">
      <b>Echo</b>
      </a>
    </div>
    <div id="collapseEcho" class="accordion-body collapse">
   <div class="accordion-inner">
<pre><code>
a = 1, b = 2;
echo("a="+a,"b="+b);
</code></pre>
prints out on the JavaScript console: a=1, b=2
      </div>
    </div>
  </div>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseMath">
      <b>Math</b>
      </a>
    </div>
    <div id="collapseMath" class="accordion-body collapse">
   <div class="accordion-inner">
Javascript provides several functions through the <a href=https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math>Math</a> library. In addition, the following OpenSCAD compatible functions are available:
<pre><code>
sin(a);                   // a = 0..360
cos(a);                   //     ''
asin(a);                  // a = 0..1, returns 0..360
acos(a);                  //       ''
tan(a);                   // a = 0..360
atan(a);                  // a = 0..1, returns 0..360
atan2(a,b);               // returns 0..360
ceil(a);
floor(a);
abs(a);
min(a,b);
max(a,b);
rands(min,max,vn,seed);   // returns random vectors of vn dimension, seed not yet implemented
log(a);
lookup(ix,v);             // ix = index, e.g. v = [ [0,100], [10,10], [20,200] ] whereas v[x][0] = index, v[x][1] = value
                          //    return will be linear interpolated (e.g. lookup(5,[ [0,100], [10,10], [20,200] ]) == 45

pow(a,b);
sign(a);                  // -1, 0 or 1
sqrt(a);
round(a);
</code></pre>
      </div>
    </div>
  </div>


</div>



