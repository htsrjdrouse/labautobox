<ul>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseCircle">
      Circle
      </a>
    </div>
    <div id="collapseCircle" class="accordion-body collapse">
   <div class="accordion-inner">
<pre><code>
circle();                        // openscad like
circle(1); 
circle({r: 2, fn:5});            // fn = number of segments to approximate the circle
circle({r: 3, center: true});    // center: false (default)

CAG.circle({center: [0,0], radius: 3, resolution: 32});   // using CSG objects' built in methods
</code></pre>
      </div>
    </div>
  </div>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseRectangle">
      Square / Rectangle
      </a>
    </div>
    <div id="collapseRectangle" class="accordion-body collapse">
   <div class="accordion-inner">
<pre><code>
square();                                   // openscad like
square(1);                                  // 1x1
square([2,3]);                              // 2x3
square({size: [2,4], center: true});        // 2x4, center: false (default)

CAG.rectangle({center: [0,0], radius: [w/2, h/2]});   // CAG built ins, where w or h = side-length of square
CAG.roundedRectangle({center: [0,0], radius: [w/2, h/2], roundradius: 1, resolution: 4});
</code></pre>
      </div>
    </div>
  </div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapsePolygon">
      Polygon
      </a>
    </div>
    <div id="collapsePolygon" class="accordion-body collapse">
   <div class="accordion-inner">
<pre><code>
polygon([ [0,0],[3,0],[3,3] ]);                // openscad like
polygon({ points: [ [0,0],[3,0],[3,3] ] });                    
polygon({ points: [ [0,0],[3,0],[3,3],[0,6] ], paths: [ [0,1,2],[1,2,3] ] }); // multiple paths not yet implemented

var shape1 = CAG.fromPoints([ [0,0],[5,0],[3,5],[0,5] ]);    // CAG built ins
</code></pre>
      </div>
    </div>
  </div>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTransformations">
      2D Transformations
      </a>
    </div>
    <div id="collapseTransformations" class="accordion-body collapse">
   <div class="accordion-inner">
<pre><code>
translate([2,2], circle(1));      // openscad like
rotate([0,0,90], square());       //     ''
shape = center(true, shape());    // center both axis
shape = center([true,false], shape()); // center axis-wise [x] 

shape = shape.translate([-2, -2]);   // object methods
shape = shape.rotateZ(20);
shape = shape.scale([0.7, 0.9]);
shape = shape.center();          // center both axis
shape = shape.center('x');       // center axis-wise [x]
</code></pre>
      </div>
    </div>
  </div>



  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapsePath">
      2D Path
      </a>
    </div>
    <div id="collapsePath" class="accordion-body collapse">
   <div class="accordion-inner">
A path is simply a series of points, connected by lines. A path can be open or closed (an additional line is drawn between the first and last point). 2D paths are supported through the CSG.Path2D class. The difference between a 2D Path and a 2D CAG is that a path is a 'thin' line, whereas a CAG is an enclosed area.<br>
Paths can be constructed either by giving the constructor an array of 2D coordinates, or through the various CSG.Path2D member functions, which include:
<ul>
<li>arc(endpoint, options): return a circular or ellipsoid curved path (see example below for usage).</li>
<li>appendPoint([x,y]): create & return a new Path2D containing the callee's points followed by the given point.</li>
<li>appendPoints([[x,y],...]): create & return a new Path2D containing the callee's points followed by the given points. [Note: as of 2016/08/13, this method also modifies the callee; this is probably a bug and might be changed in the future; see <a href=https://github.com/jscad/OpenJSCAD.org/issues/165>issue</a></li>
<li>appendBezier([[x,y],...], options): create & return a new Path2D containing the callee's points followed by a Bezier curve ending at the last point given; all but the last point given are the control points of the Bezier; a null initial control point means use the last two points of the callee as control points for the new Bezier curve. options can specify {resolution: <NN>}.</li>
</ul>
Paths can be concatenated with .concat(), the result is a new path.<br>
A path can be converted to a CAG in two ways:
<ul>
<li>expandToCAG(pathradius, resolution) traces the path with a circle, in effect making the path's line segments thick.</li>
<li>innerToCAG() creates a CAG bounded by the path. The path should be a closed path.</li>
</ul>
Creating a 3D solid is currently supported by the rectangularExtrude() function. This creates a 3D shape by following the path with a 2D rectangle (upright, perpendicular to the path direction):
<pre><code>
var path = new CSG.Path2D([ [10,10], [-10,10] ], /* closed = */ false);
var anotherpath = new CSG.Path2D([ [-10,-10] ]);
path = path.concat(anotherpath);
path = path.appendPoint([10,-10]);
path = path.close(); // close the path

// of course we could simply have done:
// var path = new CSG.Path2D([ [10,10], [-10,10], [-10,-10], [10,-10] ], /* closed = */ true);

// We can make arcs and circles:
var curvedpath = CSG.Path2D.arc({
  center: [0,0,0],
  radius: 10,
  startangle: 0,
  endangle: 180,
  resolution: 16,
});
</code></pre>
      </div>
    </div>
  </div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseHull">
      Hull
      </a>
    </div>
    <div id="collapseHull" class="accordion-body collapse">
   <div class="accordion-inner">
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_hull_examples.PNG">
    <br><br>

You can convex hull multiple 2D polygons (e.g. circle(), square(), polygon()) together.
<pre><code>
var h = hull( square(10),circle(10).translate([10,10,0]) );

linear_extrude({ height: 10 }, h);
</code></pre>
      </div>
    </div>
  </div>



  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseChainhull">
      Chain Hull
      </a>
    </div>
    <div id="collapseChainhull" class="accordion-body collapse">
   <div class="accordion-inner">
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_chainhull_examples.PNG">
    <br><br>
Chained hulling is a variant of hull on multiple 2D forms, essentially sequential hulling and then union those
<pre><code>
chain_hull( 
    circle(), circle().translate([2,0,0]), ... );   // list of CAG/2D forms

var a = [];
a.push(circle()); 
chain_hull( a );                       // array of CAG/2D forms

chain_hull({closed: true},             // default is false
   [circle(),circle().translate([2,0,0]),circle().translate([2,2,0])]);
   // notice that with parameter {closed:true}, hull_chain requires an array
</code></pre>
      </div>
    </div>
  </div>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseLinearextrude">
      Linear Extrude
      </a>
    </div>
    <div id="collapseLinearextrude" class="accordion-body collapse">
   <div class="accordion-inner">
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_linearextrude_examples.PNG">
    <br><br>

Extruding 2D shapes into 3D, given height, twist (degrees), and slices (if twist is made):
<pre><code>
// openscad like
linear_extrude({ height: 10 }, square());
linear_extrude({ height: 10, twist: 90 }, square([1,2]));
linear_extrude({ height: 10, twist: 360, slices: 50}, circle().translate([1,0,0]) );

linear_extrude({ height: 10, center: true, twist: 360, slices: 50}, translate([2,0,0], square([1,2])) );
linear_extrude({ height: 10, center: true, twist: 360, slices: 50}, square([1,2]).translate([2,0,0]) );
</code></pre>
Linear extrusion of 2D shape, with optional twist. The 2d shape is placed in in z=0 plane and extruded into direction <offset> (a CSG.Vector3D). The final face is rotated <twistangle> degrees. Rotation is done around the origin of the 2d shape (i.e. x=0, y=0) twiststeps determines the resolution of the twist (should be >= 1), returns a CSG object:
<pre><code>
// CAG build in method
var c = CAG.circle({radius: 3});
extruded = c.extrude({offset: [0,0,10], twistangle: 360, twiststeps: 100});
</code></pre>

      </div>
    </div>
  </div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseRectangularextrude">
      Rectangular Extrude
      </a>
    </div>
    <div id="collapseRectangularextrude" class="accordion-body collapse">
   <div class="accordion-inner">
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_rectangularextrude_examples.PNG">
    <br><br>

Extrude the path by following it with a rectangle (upright, perpendicular to the path direction), returns a CSG solid.
<br>
Simplified (openscad like, even though OpenSCAD doesn't provide this) via rectangular_extrude(), where as
<ul>
<li>w: width (default: 1),</li>
<li>h: height (default: 1),</li>
<li>fn: resolution (default: 8), and</li>
<li>closed: whether path is closed or not (default: false)</li>
</ul>
<pre><code>
rectangular_extrude([ [10,10], [-10,10], [-20,0], [-10,-10], [10,-10] ],  // path is an array of 2d coords
    {w: 1, h: 3, closed: true});
</code></pre>
or more low-level via rectangularExtrude(), with following unnamed variables:
<ul>
<ol>
<li>width of the extrusion, in the z=0 plane</li>
<li>height of the extrusion in the z direction</li>
<li>resolution, number of segments per 360 degrees for the curve in a corner</li>
<li>roundEnds: if true, the ends of the polygon will be rounded, otherwise they will be flat</li>
</ol>
</ul>

<pre><code>
// first creating a 2D path, and then extrude it
var path = new CSG.Path2D([ [10,10], [-10,10], [-20,0], [-10,-10], [10,-10] ], /*closed=*/true);
var csg = path.rectangularExtrude(3, 4, 16, true);   // w, h, resolution, roundEnds
return csg;
</code></pre>

      </div>
    </div>
  </div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseRotateextrude">
      Rotate Extrude
      </a>
    </div>
    <div id="collapseRotateextrude" class="accordion-body collapse">
   <div class="accordion-inner">
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_rotateextrude_examples.PNG">
    <br><br>

<pre><code>
// openscad-like
rotate_extrude( translate([4,0,0], circle({r: 1, fn: 30, center: true}) ) );

// using CSG objects' built in methods to translate 
rotate_extrude({fn:4}, square({size: [1,1], center: true}).translate([4,0,0]) );

rotate_extrude( polygon({points:[ [0,0],[2,1],[1,2],[1,3],[3,4],[0,5] ]}) );
rotate_extrude({fn:4}, polygon({points:[ [0,0],[2,1],[1,2],[1,3],[3,4],[0,5] ]}) );
</code></pre>
      </div>
    </div>
  </div>








</ul>






