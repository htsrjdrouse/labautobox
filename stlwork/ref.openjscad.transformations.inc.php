<ul>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseScale">
      Scale
      </a>
    </div>
    <div id="collapseScale" class="accordion-body collapse">
   <div class="accordion-inner">
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_scale_examples.PNG">
    <br><br>
<pre><code>
var obj = sphere(5);
scale(2,obj);          // openscad like
scale([1,2,3],obj);    //      '' 

obj.scale([1,2,3]);    // using CSG objects' built in methods
</code></pre>
      </div>
    </div>
  </div>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseRotate">
      Rotate
      </a>
    </div>
    <div id="collapseRotate" class="accordion-body collapse">
   <div class="accordion-inner">
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_rotate_examples.PNG">
    <br><br>
<pre><code>
var obj = cube([5,20,5]);
rotate([90,15,30],obj);       // openscad like
rotate(90,[1,0.25,0.5],obj);  //    ''

obj.rotateX(90);   // using CSG objects' built in methods
obj.rotateY(45);
obj.rotateZ(30);

obj.rotate(rotationCenter, rotationAxis, degrees)
obj.rotateEulerAngles(alpha, beta, gamma, position)
</code></pre>
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTranslate">
      Translate (Move)
      </a>
    </div>
    <div id="collapseTranslate" class="accordion-body collapse">
   <div class="accordion-inner">
<pre><code>
translate([0,0,10],obj);  // openscad like

obj.translate([0,0,10]);  // using CSG objects' built in methods
</code></pre>
      </div>
    </div>
  </div>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseCenter">
      Center
      </a>
    </div>
    <div id="collapseCenter" class="accordion-body collapse">
   <div class="accordion-inner">
Centering an object altogether or axis-wise:
<pre><code>
center(true,cube());                // openscad-like all axis
center([true,true,false],cube());   // openscad-like axis-wise [x,y]

// false = do nothing, true = center axis

cube().center();                // using CSG objects' built in methods
cube().center('x','y');         // using CSG objects' built in method to center axis-wise [x,y]
</code></pre>
It center() and .center() helps you to compose a symmetric whose complete size you don't know when composing, e.g. from parametric design.
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseMatrix">
      Matrix Operations
      </a>
    </div>
    <div id="collapseMatrix" class="accordion-body collapse">
   <div class="accordion-inner">
<pre><code>
var m = new CSG.Matrix4x4();
m = m.multiply(CSG.Matrix4x4.rotationX(40));
m = m.multiply(CSG.Matrix4x4.rotationZ(40));
m = m.multiply(CSG.Matrix4x4.translation([-.5, 0, 0]));
m = m.multiply(CSG.Matrix4x4.scaling([1.1, 1.2, 1.3]));

// and apply the transform:
var cube3 = cube().transform(m);
</code></pre>
      </div>
    </div>
  </div>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseMirror">
      Mirror
      </a>
    </div>
    <div id="collapseMirror" class="accordion-body collapse">
   <div class="accordion-inner">
<pre><code>
mirror([10,20,90], cube(1)); // openscad like

var cube = CSG.cube().translate([1,0,0]);   // built in method chaining

var cube2 = cube.mirroredX(); // mirrored in the x=0 plane
var cube3 = cube.mirroredY(); // mirrored in the y=0 plane
var cube4 = cube.mirroredZ(); // mirrored in the z=0 plane

// create a plane by specifying 3 points:
var plane = CSG.Plane.fromPoints([5,0,0], [5, 1, 0], [3, 1, 7]);

// and mirror in that plane:
var cube5 = cube.mirrored(plane);
</code></pre>
      </div>
    </div>
  </div>






  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseUnion">
      Union
      </a>
    </div>
    <div id="collapseUnion" class="accordion-body collapse">
   <div class="accordion-inner">
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_union_examples.PNG">
    <br><br>
<pre><code>
union(sphere({r: 1, center:true}),cube({size: 1.5, center:true}));  // openscad like
</code></pre>

multiple objects can be added, also arrays.
<pre><code>
sphere({r: 1, center:true}).union(cube({size: 1.5, center:true}));  // using CSG objects' built in methods
</code></pre>
      </div>
    </div>
  </div>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseIntersection">
      Intersection
      </a>
    </div>
    <div id="collapseIntersection" class="accordion-body collapse">
   <div class="accordion-inner">
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_intersection_examples.PNG">
    <br><br>
<pre><code>
intersection(sphere({r: 1, center:true}),cube({size: 1.5, center:true})); // openscad like
</code></pre>
multiple objects can be intersected, also arrays.
<pre><code>
sphere({r: 1, center:true}).intersect(cube({size: 1.5, center:true}));   // using CSG objects' built in methods
</code></pre>
Note intersection() (openscad like) vs intersect() (function vs CSG objects' built in methods)
      </div>
    </div>
  </div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseDifference">
      Difference (Subtraction)
      </a>
    </div>
    <div id="collapseDifference" class="accordion-body collapse">
   <div class="accordion-inner">
    <img src="openjscad_images/r.labbot_3d_printer_openjscad_difference_examples.PNG">
    <br><br>
<pre><code>
difference(sphere({r: 1, center:true}),cube({size: 1.5, center:true}));    // openscad like
</code></pre>
multiple objects can be differentiated (subtracted) from the first element, also arrays.
<pre><code>
sphere({r: 1, center:true}).subtract(cube({size: 1.5, center:true}));      // using CSG objects' built in methods
</code></pre>
Note: difference() (openscad like) vs subtract() (method, object-oriented)
      </div>
    </div>
  </div>









</ul>


