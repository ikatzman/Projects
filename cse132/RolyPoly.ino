#include <Wire.h>
#include <SparkFun_MMA8452Q.h>
MMA8452Q accel;

int rows[] = {2, 3, 4, 5, 6, 7 , 8};
int cols[] = {9, 10, 11, 12, 13};
int count = 0;
int preyX;
int preyY;
int predX;
int predY;

unsigned long dPrey = 0;
unsigned int preyMove = 500;
unsigned long dPred = 0;
unsigned long predMove = 1000;

boolean finish = 0;
boolean predOn = true;
unsigned long delta = 0;
unsigned long delta2 = 0;
unsigned long flash = 200;
boolean predWin = false;
boolean preyWin = false;
int preyWins = 0;
int predWins = 0;
void setup()
{
  Serial.begin(9600);
  pinMode(rows[0], OUTPUT);
  pinMode(rows[1], OUTPUT);
  pinMode(rows[2], OUTPUT);
  pinMode(rows[3], OUTPUT);
  pinMode(rows[4], OUTPUT);
  pinMode(rows[5], OUTPUT);
  pinMode(rows[6], OUTPUT);
  pinMode(cols[0], OUTPUT);
  pinMode(cols[1], OUTPUT);
  pinMode(cols[2], OUTPUT);
  pinMode(cols[3], OUTPUT);
  pinMode(cols[4], OUTPUT);

  digitalWrite(rows[0], LOW);
  digitalWrite(rows[1], LOW);
  digitalWrite(rows[2], LOW);
  digitalWrite(rows[3], LOW);
  digitalWrite(rows[4], LOW);
  digitalWrite(rows[5], LOW);
  digitalWrite(rows[6], LOW);
  digitalWrite(cols[0], HIGH);
  digitalWrite(cols[1], HIGH);
  digitalWrite(cols[2], HIGH);
  digitalWrite(cols[3], HIGH);
  digitalWrite(cols[4], HIGH);

  accel.init();

  randomSeed(analogRead(0));
  preyX = random(0, 4);
  preyY = random(0, 6);
  if(preyX == predX || preyX == predX + 1 || preyY == predY || preyY == predY + 1)
  {
    predX = random(preyX, 4);
    predY = random(preyY, 6);
  }
  Serial.print(preyX);
  Serial.print(preyY);
  Serial.print(predX);
  Serial.print(predY);
}

void loop()
{
  if (finish == 0)
  {
    if (millis() - delta <= 15000 && predWin != true)
    {
      setPrey();      
      setPred();
      light();
      if (millis() - flash >= 125)
      {
          {
            if (predOn == false)
            {
              predOn = true;
            }
            else
            {
              predOn = false;
            }
          }
          flash = millis();
      }
      if ((preyX == predX || preyX == predX + 1) &&
          (preyY == predY || preyY == predY + 1))
      {
        predWin = true;
        predWins = predWins + 1;
      }
 
    }
    else
    {
      if (millis() - delta >= 15000)
      {
        preyWins += 1;
        preyWin = true;
      }
//      if ((preyX == predX || preyX == predX + 1) &&
//          (preyY == predY || preyY == predY + 1))
//      {
//        predWin = true;
//        predWins += 1;
//      }
      finish = 1;
      delta2 = millis();
    }
  }

  else if(finish == 1)
  {
    if (millis() - delta2 <= 4000)
    {
      if(predWin == true)
      {
        Serial.print(predWins);
        digitalWrite(rows[3], HIGH);
        digitalWrite(rows[4], HIGH);
        digitalWrite(cols[2], LOW);
        digitalWrite(cols[3], LOW);
        delay(5);
        digitalWrite(rows[3], LOW);
        digitalWrite(rows[4], LOW);
        digitalWrite(cols[2], HIGH);
        digitalWrite(cols[3], HIGH);
        
        if(predWins == preyWins)
        {
          Serial.print("FIRST CASE");
          digitalWrite(cols[2], LOW);
          digitalWrite(rows[6], HIGH);
          delay(5);
          reset();
        }
        else if((predWins - preyWins == 1) || (predWins - preyWins == 2))
        {
          digitalWrite(cols[2], LOW);
          digitalWrite(cols[3], LOW);
          digitalWrite(rows[6], HIGH);
          delay(5);
          reset();
        }
        else if(predWins - preyWins > 2)
        {
          digitalWrite(cols[2], LOW);
          digitalWrite(cols[3], LOW);
          digitalWrite(cols[4], LOW);
          digitalWrite(rows[6], HIGH);
          delay(5);
          reset();
        }
        else if((preyWins - predWins == 1) || (preyWins - predWins == 2))
        {
          digitalWrite(cols[1], LOW);
          digitalWrite(cols[2], LOW);
          digitalWrite(rows[6], HIGH);
          delay(5);
          reset();
        }
        else if(preyWins - predWins > 2)
        {
          digitalWrite(cols[0], LOW);
          digitalWrite(cols[1], LOW);
          digitalWrite(cols[2], LOW);
          digitalWrite(rows[6], HIGH);
          delay(5);
          reset();
        }
      }
      
      if(predWin == false)
      {
        digitalWrite(rows[3], HIGH);
        digitalWrite(cols[2], LOW);
        delay(5);
        digitalWrite(rows[3], LOW);
        digitalWrite(cols[2], HIGH);
        
        if(preyWins == predWins)
        {
          digitalWrite(cols[2], LOW);
          digitalWrite(rows[6], HIGH);
          delay(5);
          reset();
        }
        else if((preyWins - predWins == 1) || (preyWins - predWins == 2))
        {
          digitalWrite(cols[2], LOW);
          digitalWrite(cols[3], LOW);
          digitalWrite(rows[6], HIGH);
          delay(5);
          reset();
        }
        else if(preyWins - predWins > 2)
        {
          digitalWrite(cols[2], LOW);
          digitalWrite(cols[3], LOW);
          digitalWrite(cols[4], LOW);
          digitalWrite(rows[6], HIGH);
          delay(5);
          reset();
        }
        else if((predWins - preyWins == 1) || (predWins - preyWins == 2))
        {
          digitalWrite(cols[1], LOW);
          digitalWrite(cols[2], LOW);
          digitalWrite(rows[6], HIGH);
          delay(5);
          reset();
        }
        else if(predWins - preyWins > 2)
        {
          digitalWrite(cols[0], LOW);
          digitalWrite(cols[1], LOW);
          digitalWrite(cols[2], LOW);
          digitalWrite(rows[6], HIGH);
          delay(5);
          reset();
        }
      }
      
    }
    else
    {
      finish = 0;
      predWin = false;
      preyWin = false;
      delta = millis();
      randomSeed(analogRead(0));
      preyX = random(0, 4);
      preyY = random(0, 6);
      if(preyX == predX || preyX == predX + 1 || preyY == predY || preyY == predY + 1)
      {
        predX = random(preyX, 4);
        predY = random(preyY, 6);
      }
      while ((preyX >= predX - 1 && preyX <= predX + 2) &&
             (preyY >= predY - 1 && preyY <= predY + 2))
      {
        randomSeed(analogRead(0));
        preyX = random(0, 4);
        preyY = random(0, 6);
        //if(preyX == predX || preyX == predX + 1 || preyY == predY || preyY == predY + 1)
        //{
        //  predX = random(preyX, 4);
        //  predY = random(preyY, 6);
        //}
      }
    }
  }
}
  void setPrey()
  {
    if (millis() - dPrey >= preyMove)
    {
      if (accel.available())
      {
        accel.read();

        if (accel.cx >= .05)
        {
          preyX++;
          if (preyX > 3)
          {
            preyX = 4;
          }
        }

        if (accel.cx <= -.02)
        {
          preyX--;
          if (preyX < 1)
          {
            preyX = 0;
          }
        }

        if (accel.cx < .05 && accel.cx > -.02)
        {
          preyX = preyX;
        }

        if (accel.cy < .017 && accel.cy > 0)
        {
          preyY = preyY;
        }

        if (accel.cy >= .017)
        {
          preyY--;
          if (preyY < 1)
          {
            preyY = 0;
          }
        }

        if (accel.cy <= 0)
        {
          preyY++;
          if (preyY > 5)
          {
            preyY = 6;
          }
        }
      }
      dPrey = millis();
  }
}

  void setPred()
  {
    if(millis() - dPred >= predMove)
    {
      if (Serial.available() > 0)
    {
      byte x = Serial.read();
      Serial.print(x);
      if (x == 'c')
      {
        predX++;
        Serial.println(predX);
        if (predX > 3)
        {
          predX = 4;
        }
      }

      if (x == 'a')
      {
        predX--;
        Serial.println(predX);
        if (predX < 1)
        {
          predX = 0;
        }
      }

      if (x == 'b')
      {
        predY--;
        Serial.println(predY);
        if (predY < 1)
        {
          predY = 0;
        }
      }

      if (x == 'd')
      {
        predY++;
        Serial.println(predY);
        if (predY > 5)
        {
          predY = 6;
        }
      }
    }
    dPred = millis();
    }
    
  }
  void light()
  {
    for (int i = 0; i < 5; i++)
    {
      if (preyX == i || predX == i || predX + 1 == i)
      {
        digitalWrite(cols[i], LOW);
      }
      else
      {
        digitalWrite(cols[i], HIGH);
      }
      for (int j = 0; j < 7; j++)
      {
        if (preyX == i && preyY == j)
        {
          digitalWrite(rows[j], HIGH);
        }
//        if (millis() - flash <= 1000)
//        {
          if (predOn == true)
          {
            if (predX == i && predY == j)
            {
              digitalWrite(rows[j], HIGH);
            }
            else if (predX == i && predY + 1 == j)
            {
              digitalWrite(rows[j], HIGH);
            }
            else if (predX + 1 == i && predY == j)
            {
              digitalWrite(rows[j], HIGH);
            }
            else if (predX + 1 == i && predY + 1 == j)
            {
              digitalWrite(rows[j], HIGH);
            }
            //digitalWrite(rows[predY], HIGH);
          }
//          else
//          {
//            if (predOn == false)
//            {
//              predOn = true;
//            }
//            else
//            {
//              predOn = false;
//            }
//          }
//          flash = millis();
        }
//      }
//      delay(2);
//      reset();

//      if ((preyX == predX || preyX == predX + 1) &&
//          (preyY == predY || preyY == predY + 1))
//      {
//        predWin = true;
//        predWins = predWins + 1;
//      }
      delay(2);
      reset();
    }
  }
  
  void reset()
  {
    digitalWrite(rows[0], LOW);
    digitalWrite(rows[1], LOW);
    digitalWrite(rows[2], LOW);
    digitalWrite(rows[3], LOW);
    digitalWrite(rows[4], LOW);
    digitalWrite(rows[5], LOW);
    digitalWrite(rows[6], LOW);
    digitalWrite(cols[0], HIGH);
    digitalWrite(cols[1], HIGH);
    digitalWrite(cols[2], HIGH);
    digitalWrite(cols[3], HIGH);
    digitalWrite(cols[4], HIGH);
  } 
