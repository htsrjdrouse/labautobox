var w = new Array();
function a() {
   w.push( sphere(4) );
   w.push(cube([160,40,30]).translate([132,120,0]) );
   w.push(b());
}
function main() {
   a();
   return w;
}
function b(){
return sphere(4).translate([40,0,10]);
}