#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#define WIFI_SSID "Pixel"            // WIFI SSID                                   
#define WIFI_PASSWORD "gligglig"        // WIFI password 
#include <ArduinoJson.h>

//DIGI_462a10   5b2eb9d5
//Pixel         gligglig
//TP-LINK_81F4  31214278
//MG            4Q4422ff

String serverName = "http://www.gligorm.online/TX.php";

int led1 = D0 ;
int led2 = D1;
int led3 = D2 ;
int led4 = D7;
int led5 = D4 ;

int Alarma = D8;
int LED_Alarma = D6;

int b6=0,b_usa=0,b_garaj=0,b_geam1=0,b_geam2=0,b_smoke=0 ,n2Smoke =0;

double distanta ;
double smoke;
double temperatura ;

int aux;
char * values = NULL;
char * valuesAux = NULL;
String text = " ";

void setup() {

  Serial.begin(9600);
  pinMode(led1, OUTPUT);
  pinMode(led2, OUTPUT);
  pinMode(led3, OUTPUT);
  pinMode(led4, OUTPUT);
  pinMode(led5, OUTPUT);
  pinMode(LED_Alarma, OUTPUT);

  digitalWrite(led1, LOW);
  digitalWrite(led2, LOW);
  digitalWrite(led3, LOW);
  digitalWrite(led4, LOW);
  digitalWrite(led5, LOW);
  digitalWrite(LED_Alarma, LOW);


  WiFi.mode(WIFI_STA);
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);

  while (WiFi.status() != WL_CONNECTED)
  { //Serial.print(".");
    delay(500);
  }

}


void loop() {

  delay(1200);
//------------------------------------------------------------------//
  comunicatie_seriala(b6, b_usa, b_garaj, b_smoke,b_geam1, b_geam2,text);
//-----------------------------------------------------------------//
  aux = 0;
  if (WiFi.status() == WL_CONNECTED) {

    WiFiClient client;
    HTTPClient http1;
    String postData;
    http1.begin(client, serverName);
    http1.addHeader("Content-Type", "application/x-www-form-urlencoded");
    postData ="value1=" + String(temperatura) + "&value2=" + String(distanta)+ "&value3=" + String(smoke);
    int httpCode = http1.POST(postData);
    

    if (httpCode > 0) {

      String payload = http1.getString();
      //Serial.println(payload);
      values = strtok ((char*)payload.c_str() , "##");

      while (values != NULL)
      {
        aux++;
        asignare_valori(aux, values);
        values = strtok(NULL, "##");
      }
    }
    http1.end();
  }

  if(distanta < 12 && distanta > 0)
  {
    alarma();
  }
  if(smoke > n2Smoke)
  {
    alarma();
  }
  
}
//----------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------//
void comunicatie_seriala(int b6,int b_usa,int b_garaj,int b_smoke ,int b_geam1, int b_geam2 ,String text) {
  
  Serial.flush();
  DynamicJsonDocument doc(1024);

  doc["type"] = "request";
  doc["b6"] = b6;
  doc["b_usa"] = b_usa;
  doc["b_garaj"] = b_garaj;
  doc["b_smoke"] = b_smoke;
  doc["b_geam1"] = b_geam1;
  doc["b_geam2"] = b_geam2;
  doc["text"] = text;
  
  serializeJson(doc, Serial);
  doc.clear();
  
  boolean messageReady = false;
  String message = "";
  
  while (messageReady == false) {
    if (Serial.available()) {
      message = Serial.readString();
      messageReady = true;
    }
  }
  
  Serial.flush();
  DynamicJsonDocument doc1(256);

  DeserializationError error = deserializeJson(doc1, message);
  if (error) {
    Serial.print(F("deserializeJson() failed: "));
    Serial.println(error.c_str());
    return;
  }
  
  distanta = doc1["distanta"];
  smoke = doc1["smoke"];
  temperatura =doc1["temperatura"];

  
  String output = "distanta: " + String(distanta) + "\n";
  output += "Smoke level: " + String(smoke)+ "\n";
  output += "Temperature: " + String(temperatura);

  Serial.println();
  Serial.println(output);
  Serial.println();
  doc1.clear();
  Serial.flush();
}
//----------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------//
void setBoolAndLED(char *values, int ledAux)
{
  int b=atoi(values);
   if (b == 1)
    {
      digitalWrite(ledAux, HIGH);
    }
    else
    {
      digitalWrite(ledAux, LOW);
    }
}
//----------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------//
void alarma()
{
  for(int i = 0;i<5;i++)
  {
    digitalWrite(LED_Alarma,HIGH);
    tone(Alarma,700);
    delay(200);
    digitalWrite(LED_Alarma,LOW);
    noTone(Alarma);
    delay(200);
  }
  
}
//----------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------------------//
void asignare_valori(int aux, char * values )
{
   
  if (aux == 1) {
    setBoolAndLED(values,led1);
  }
  if (aux == 2) {
    setBoolAndLED(values,led2);
  }
  if (aux == 3) {
    setBoolAndLED(values,led3);
  }
  if (aux == 4) {
    setBoolAndLED(values,led4);
  }
  if (aux == 5) {
    setBoolAndLED(values,led5);
  }
  
  if (aux == 6) {
    b6 = atoi(values);
    if (b6 == 1)
    {
      digitalWrite(LED_Alarma, HIGH);
    }
    else
    {
      digitalWrite(LED_Alarma, LOW);
    }
  }
  
  if (aux == 7) {
    b_usa = atoi(values);
  }
  if (aux == 8) {
    b_garaj = atoi(values);
  }
   if (aux == 9) {
    b_geam1 = atoi(values);
  }
  if (aux == 10) {
    b_geam2 = atoi(values);
  }
  if (aux == 11) {
    b_smoke = atoi(values);
  }
  if (aux == 13) {
    n2Smoke = atoi(values);
  }
  if(aux == 15){
     valuesAux = strtok (values , "~");
    text = valuesAux;
 
  }
}
//----------------------------------------------------------------------------------------------------//
