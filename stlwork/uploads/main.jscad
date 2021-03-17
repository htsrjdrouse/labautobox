// main.jscad
//include("lib.jscad");
importScripts("lib.jscad");

// lib.jscad
/*
myLib = function() {
   var a = function(n) {  // internal 
      return n*4;  
   }
   myLib.b = function(n) {      // public 
      return sphere(a(n));  
   }
}

*/

function main() {
  myLib();
  return myLib.b(2);
}

