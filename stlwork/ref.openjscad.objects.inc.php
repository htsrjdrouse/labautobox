<ul>
<div class="accordion" id="accordion2">

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
        Cube
      </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse">
   <div class="accordion-inner">
<img src="openjscad_images/r.labbot_3d_printer_openjscad_cube_examples.PNG">
<br><br>
<pre><code>
cube(); // openscad like
cube(1);
cube({size: 1});
cube({size: [1,2,3]});
cube({size: 1, center: true}); // default center:false
cube({size: 1, center: [false,false,false]}); // individual axis center true or false
cube({size: [1,2,3], round: true});

CSG.cube(); // using the CSG primitives
CSG.cube({
    center: [0, 0, 0],
    radius: [1, 1, 1]
});
CSG.cube({ // define two opposite corners
    corner1: [4, 4, 4],
    corner2: [5, 4, 2]
});
CSG.roundedCube({ // rounded cube
    center: [0, 0, 0],
    radius: 1,
    roundradius: 0.9,
    resolution: 8,
});
</code></pre>
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
        Cylinder
      </a>
    </div>
    <div id="collapseTwo" class="accordion-body collapse">
      <div class="accordion-inner">
<img src="openjscad_images/r.labbot_3d_printer_openjscad_cylinders_examples.PNG">
<br><br>
<pre></code>
cylinder({r: 1, h: 10});      // openscad like
cylinder({d: 1, h: 10});
cylinder({r: 1, h: 10, center: true});   // default: center:false
cylinder({r: 1, h: 10, center: [true, true, false]});  // individual x,y,z center flags
cylinder({r: 1, h: 10, round: true});
cylinder({r1: 3, r2: 0, h: 10});
cylinder({d1: 1, d2: 0.5, h: 10});
cylinder({start: [0,0,0], end: [0,0,10], r1: 1, r2: 2, fn: 50});

CSG.cylinder({     //using the CSG primitives
  start: [0, -1, 0],
  end: [0, 1, 0],
  radius: 1,     // true cylinder
  resolution: 16
});
CSG.cylinder({
  start: [0, -1, 0],
  end: [0, 1, 0],
  radiusStart: 1,  // start- and end radius defined, partial cones
  radiusEnd: 2,
  resolution: 16
});
CSG.roundedCylinder({  // and its rounded version
  start: [0, -1, 0],
  end: [0, 1, 0],
  radius: 1,
  resolution: 16
});
</code></pre>

      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
        Sphere
      </a>
    </div>
    <div id="collapseThree" class="accordion-body collapse">
      <div class="accordion-inner">
<img src="openjscad_images/r.labbot_3d_printer_openjscad_sphere_examples.PNG">
<br><br>
<pre><code>
sphere();   // openscad like
sphere(1);
sphere({r: 2});   // Note: center:true is default (unlike other primitives, as OpenSCAD)
sphere({r: 2, center: true});  // Note: OpenSCAD doesn't support center for sphere but we do
sphere({r: 2, center: [false, false, true]}); // individual axis center 
sphere({r: 10, fn: 100 });
sphere({r: 10, fn: 100, type: 'geodesic'});  // geodesic approach (icosahedron further triangulated)

CSG.sphere();   // using the CSG primitives
CSG.sphere({
  center: [0, 0, 0],
  radius: 2,    // must be scalar
  resolution: 128
});
</code></pre>
      </div>
    </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
        Torus
      </a>
    </div>
    <div id="collapseFour" class="accordion-body collapse">
      <div class="accordion-inner">
<img src="openjscad_images/r.labbot_3d_printer_openjscad_torus_examples.PNG">
<br><br>
A torus is defined as such:<ul>

<li>ri = inner radius (default: 1),</li>
<li>ro = outer radius (default: 4),</li>
<li>fni = inner resolution (default: 16),</li>
<li>fno = outer resolution (default: 32),</li>
<li>roti = inner rotation (default: 0)</li>
</ul>
<br>
<pre><code>
torus();      // ri = 1, ro = 4;  
torus({ ri: 1.5, ro: 3 });
torus({ ri: 0.2 });

torus({ fni:4 });   // make inner circle fn = 4 => square
torus({ fni:4,roti:45 });   // rotate inner circle, so flat is top/bottom
torus({ fni:4,fno:4,roti:45 });
torus({ fni:4,fno:5,roti:45 });
</code></pre>
      </div>
    </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive">
        Text
      </a>
    </div>
    <div id="collapseFive" class="accordion-body collapse">
      <div class="accordion-inner">
<img src="openjscad_images/r.labbot_3d_printer_openjscad_text_examples.PNG">
<br><br>
<pre><code>
var l = vector_text(0,0,"Hello World!");  // l contains a list of polylines to be drawn
var o = [];
l.forEach(function(pl) {     // pl = polyline (not closed)
   o.push(rectangular_extrude(pl, {w: 2, h: 2}));   // extrude it to 3D
});
return union(o);
</code></pre>
Also multiple-line with "\n" is supported, for now just left-align is supported. If you want to dive more into the details, you can request a single character:
<pre><code>
var c = vector_char(x,y,"A");
c.width;    // width of the vector font rendered character
c.segments; // array of segments / polylines
</code></pre>
      </div>
    </div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix">
        Polyhedron
      </a>
    </div>
    <div id="collapseSix" class="accordion-body collapse">
      <div class="accordion-inner">
<img src="openjscad_images/r.labbot_3d_printer_openjscad_polyhedron_examples.PNG">
<br><br>
<pre><code>
polyhedron({      // openscad-like (e.g. pyramid)
  points: [ [10,10,0],[10,-10,0],[-10,-10,0],[-10,10,0], // the four points at base
            [0,0,10] ],     // the apex point 
  triangles: [ [0,1,4],[1,2,4],[2,3,4],[3,0,4],   // each triangle side
               [1,0,3],[2,1,3] ]   // two triangles for square base
});
</code></pre>
Additionally you can also define `polygons: [ [0,1,4,5], [..] ]` too, not just `triangles:`.<br>
You can also create a polyhedron at a more low-level:
<pre><code>
var polygons = [];
polygons.push(new CSG.Polygon([
      new CSG.Vertex(new CSG.Vector3D(-5,-5,0)),
      new CSG.Vertex(new CSG.Vector3D(2,2,5)),
      new CSG.Vertex(new CSG.Vector3D(3,3,15))
   ])
);
// add more polygons and finally:
solid = CSG.fromPolygons(polygons);
</code></pre>
      </div>
    </div>
  </div>
</div>	 
</ul>

