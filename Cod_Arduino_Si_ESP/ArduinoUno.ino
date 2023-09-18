#include <Servo.h>
#include <ArduinoJson.h>

#include <Wire.h> 
#include <LiquidCrystal_I2C.h>

LiquidCrystal_I2C lcd(0x27,20,4);

Servo servo_usa;
Servo servo_garaj;
Servo servo_geam1;
Servo servo_geam2;

const int usa = 2;
const int garaj= 3;
const int geam1= 4;
const int geam2= 5;

const int LED_usa = 11;
const int LED_garaj= 10;
const int LED_geam1= 9;
const int LED_geam2= 8;

const int trig= 6;
const int echo= 7;

const int temperatura = A2;
const int smoke = A0;

double valDist;
double valSmoke;
double valTemp;

int b6,b_usa,b_garaj,b_smoke,b_geam1,b_geam2;

bool mReady = false;
String msg = "";
char * value = NULL;
String text = "";
/////////////////////////////////////////////////////////////////////////////////////////////////
void setup() {

  servo_usa.attach(usa);
  servo_garaj.attach(garaj);
  servo_geam1.attach(geam1);
  servo_geam2.attach(geam2);

  pinMode(trig, OUTPUT); // Sets the trigPin as an Output
  pinMode(echo, INPUT);
  pinMode(temperatura, INPUT);
  pinMode(smoke, INPUT);

  pinMode(LED_usa, OUTPUT); 
  pinMode(LED_garaj, OUTPUT);
  pinMode(LED_geam1, OUTPUT);
  pinMode(LED_geam2, OUTPUT);

  digitalWrite(LED_usa, LOW); 
  digitalWrite(LED_garaj, LOW);
  digitalWrite(LED_geam1, LOW);
  digitalWrite(LED_geam2, LOW);
  
  
  Serial.begin(9600);

  lcd.init();
  lcd.backlight();
}

/////////////////////////////////////////////////////////////////////////////////////////////////

void loop() {
  receptie_seriala();
  management_date(b6,b_usa,b_garaj,b_smoke,b_geam1,b_geam2);
  trimitere_seriala();
}

/////////////////////////////////////////////////////////////////////////////////////////////////

void management_date(int b6,int b_usa,int b_garaj,int b_smoke, int b_geam1 , int b_geam2)
{
 //-------------------------------------------------------------//
 //-------------------- Senzor de distanta ---------------------//
  if(b6==1)
  {
   pinMode(trig, OUTPUT);
   digitalWrite(trig, LOW);
   delayMicroseconds(2);
   digitalWrite(trig, HIGH);
   delayMicroseconds(10);
   digitalWrite(trig, LOW);
   pinMode(echo, INPUT);
   valDist = (pulseIn(echo, HIGH))/29/2;
  }
  else{
    valDist=0;
  }
 //-------------------------------------------------------------//
 //------------------------ Motoare servo ----------------------//
  if(b_usa==1 ){
    digitalWrite(LED_usa,HIGH);
    servo_usa.write(90);             
  }else if(b_usa==0){
    digitalWrite(LED_usa,LOW);
    servo_usa.write(0);             
  }

  if(b_garaj==1){
    digitalWrite(LED_garaj,HIGH);
    servo_garaj.write(90);            
  }else if(b_garaj==0){
    digitalWrite(LED_garaj,LOW);
    servo_garaj.write(0);              
  }

  if(b_geam1==1){
    digitalWrite(LED_geam1,HIGH);
    servo_geam1.write(90);            
  }else if(b_garaj==0){
    digitalWrite(LED_geam1,LOW);
    servo_geam1.write(0);              
  }

  if(b_geam2==1){
    digitalWrite(LED_geam2,HIGH);
    servo_geam2.write(90);            
  }else if(b_garaj==0){
    digitalWrite(LED_geam2,LOW);
    servo_geam2.write(0);              
  }
 //-------------------------------------------------------------//
 //---------------------- Senzor de fum ------------------------//
  if(b_smoke==1){
    valSmoke = analogRead(smoke);
  }
  else{
    valSmoke =0;
  }
 //-------------------------------------------------------------//
 //------------------ Setare temperatura -----------------------//

  double ten= analogRead(temperatura);
   ten=ten*(4.3/1023.0);
   valTemp = ten*100;
//-------------------------------------------------------------//
 //------------------ Setare text -----------------------//
  value = (char *)text.c_str();
  lcd.setCursor(1,0);
  lcd.clear();
  lcd.print(value);

}

void receptie_seriala()
{
  Serial.flush();
  while (mReady==false) {
    if(Serial.available())
    {
      msg=Serial.readString();
      mReady=true;
    }
    
  }
  Serial.flush();
  DynamicJsonDocument doc1(512);
  DeserializationError error = deserializeJson(doc1,msg);
  if(error)
  {
    Serial.println(error.c_str());
  }
  
  b6 = doc1["b6"];
  b_usa = doc1["b_usa"];
  b_garaj = doc1["b_garaj"];
  b_smoke = doc1["b_smoke"];
  b_geam1 = doc1["b_geam1"];
  b_geam2 = doc1["b_geam2"];
  text = (const char *)doc1["text"];
  doc1.clear();
  Serial.flush();

}



void trimitere_seriala()
{
  DynamicJsonDocument doc(128);
  doc["type"] = "response";
  doc["distanta"] = valDist;
  doc["smoke"] = valSmoke;
  doc["temperatura"] = valTemp;
  
  serializeJson(doc, Serial);
  Serial.println();
  mReady = false;
  doc.clear();
  Serial.flush();
}
