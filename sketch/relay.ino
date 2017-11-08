#include <ESP8266WiFi.h>
#include <SPI.h>
#include <ESP8266HTTPClient.h>

const char* ssid = "Wireless Switch";
const char* password = "88192010";

int err = 12;
int connInd = 16;

WiFiServer server(80);

void setup() {
  pinMode(err, OUTPUT);
  pinMode(connInd, OUTPUT);
  digitalWrite(connInd, HIGH);
  digitalWrite(err, HIGH);
  
  WiFi.begin(ssid, password);
   
  while (WiFi.status() != WL_CONNECTED) {
    switch(WiFi.status()){
      case WL_CONNECT_FAILED:
        digitalWrite(err, LOW);
        delay(2000);
        break;
      case WL_NO_SSID_AVAIL:
        digitalWrite(err, LOW);
        delay(500);
        digitalWrite(err, HIGH);
        delay(500);
        break;
      case WL_IDLE_STATUS:
        digitalWrite(connInd, LOW);
        delay(1000);
        break;
      case WL_DISCONNECTED:
        digitalWrite(connInd, LOW);
        delay(1000);
        digitalWrite(connInd, HIGH);
        delay(1000);
        break;
    }
  }
  server.begin();
  
  delay(10);

  HTTPClient http;
  
  String s = "http://w-switch.herokuapp.com/servip.php?ip=";
  s += WiFi.localIP().toString();
  http.begin(s);
  
  int httpCode = http.GET();
  
  http.end();

  while(httpCode != 200){
    digitalWrite(err, LOW);
    http.begin(s);
    httpCode = http.GET();
    http.end();
    delay(500);
    digitalWrite(err, HIGH);
    delay(500);
  }
}
 
void loop() {
  WiFiClient client = server.available();
  if (!client) {
    delay(10);
    return;
  }
  String request = client.readStringUntil('\r');
  String led = "";
  int ledId;
  
  if(request.indexOf("ON")!=-1) {
    led = request.substring(request.indexOf("/")+1,request.length()-12);
  } else if(request.indexOf("OFF")!=-1) {
    led = request.substring(request.indexOf("/")+1,request.length()-13);
  } else {
    led = "0";
  }
  ledId = led.toInt();
  if(ledId == 0) {
    return;
  }
  pinMode(ledId, OUTPUT);
  
  int value = LOW;
  if (request.indexOf("ON") != -1) {
    digitalWrite(ledId, LOW);
  } 
  if (request.indexOf("OFF") != -1){
    digitalWrite(ledId, HIGH);
  }
}
