var a = 80;
var b = 80;

function setup() {
  createCanvas(window.innerWidth, window.innerHeight);
  background(50);
}

function draw() {
  //noStroke();
  fill(100, 100, 200);
  ellipse(a, b, 80, 80);
  a += 5;
  b += 5;
  while(a > 500 && a < 1000) {
    a -= 5;
    //b = -b;
    if(b < window.innerHeight) {
      b -= 5;
    }
  }

  //if(b < 500) {
    //b -= 5;
    //a = -a;
  //}
}
