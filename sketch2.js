var a = 0;
var b = 0;
var c = 0;

var d = 0;
var e = 255;
var f = 0;

var x = 450;
var y = 500;


function setup()
{
  createCanvas(window.innerWidth, window.innerHeight);
  //button = createButton("Military Time");
  //button.position(575, 200);
  //button.mousePressed(timeChange);

}

function draw()
{
  background(a, b, c);
  let h = hour();
  let m = minute();
  let s = second();
  var st = "AM";
  fill(d, e, f);
  ellipse((minute()*20), (second()*10), 80, 80);
  fill(0);
  if(h > 12)
  {
    h = h - 12;
    st = "PM";
  }
  textAlign(CENTER);
  textSize(10);
  noStroke();
  if(m < 10)
  {
    if(s < 10)
    {
      text(h + ":0" + m + ":0" + s + st, (minute()*20), (second()*10));
    }
    else
    {
      text(h + ":0" + m + ":" + s + st, (minute()*20), (second()*10));
    }
  }
  else
  {
    if(s < 10)
    {
      text(h + ":" + m + ":0" + s + st, (minute()*20), (second()*10));
    }
    else
    {
      text(h + ":" + m + ":" + s + st, (minute()*20), (second()*10));
    }
  }

}

function mousePressed()
{
  a = random(255);
  b = random(255);
  c = random(255);

  d = random(255);
  e = random(255);
  f = random(255);
  //x = random(window.innerWidth - 100);
  //y = random(window.innerHeight - 100);
}
