var a = 0;
var b = 0;
var c = 0;

function setup()
{
  createCanvas(window.innerWidth, window.innerHeight);
  background(51);
  textSize(12);
  fill(255, 255, 255);
  text('choose pen color:', 10, 20);
  fill(255, 0, 0);
  ellipse(80, 49, 20, 20);
  fill(0, 255, 0);
  ellipse(90, 79, 20, 20);
  fill(0, 0, 255);
  ellipse(80, 109, 20, 20);
  fill(0, 0, 0);
  ellipse(90, 139, 20, 20);
  fill(255, 255, 255);
  ellipse(90, 169, 20, 20);
  fill(255, 255, 255);
  text('hold space and drag to erase', 10, 190);
  button = createButton('RED');
  button.position(20, 40);
  button.mousePressed(penRed);
  button = createButton('GREEN');
  button.position(20, 70);
  button.mousePressed(penGreen);
  button = createButton('BLUE');
  button.position(20, 100);
  button.mousePressed(penBlue);
  button = createButton('BLACK');
  button.position(20, 130);
  button.mousePressed(penBlack);
  button = createButton('WHITE');
  button.position(20, 160);
  button.mousePressed(penWhite);
}

 function penRed()
 {
   a = 255;
   b = 0;
   c = 0;
 }
 function penGreen()
 {
   a = 0;
   b = 255;
   c = 0;
 }
 function penBlue()
 {
   a = 0;
   b = 0;
   c = 255;
 }
 function penBlack()
 {
   a = 0;
   b = 0;
   c = 0;
 }
 function penWhite()
 {
   a = 255;
   b = 255;
   c = 255;
 }

function draw()
{
  if((mouseIsPressed) && (mouseX >= 10 && mouseX <= 30) && (mouseY >= 30 && mouseY <= 50))
  {
    a = 255;
    b = 0;
    c = 0;
  }
  if(mouseX >= 200)
  {
    if(mouseIsPressed)
    {
      stroke(a, b, c);
      strokeWeight(10);
      line(pmouseX, pmouseY, mouseX, mouseY);
    }
    else if(keyIsDown(32))
    {
      stroke(51);
      strokeWeight(100);
      line(pmouseX, pmouseY, mouseX, mouseY);
    }
  }
}
