#include <ESP8266WiFi.h>
#include <SPI.h>
#include <ESP8266HTTPClient.h>

const char* ssid = "Wireless Switch";
const char* password = "88192010";

int ledPin = 16;
int connInd = 16;

WiFiServer server(80);

void setup() {
  pinMode(ledPin, OUTPUT);
  pinMode(connInd, OUTPUT);
  digitalWrite(connInd, HIGH);
  digitalWrite(ledPin, HIGH);
  
  WiFi.begin(ssid, password);
   
  while (WiFi.status() != WL_CONNECTED) {
    digitalWrite(connInd, LOW);
    delay(500);
    digitalWrite(connInd, HIGH);
    delay(500);
  }
  
  server.begin();
  
  delay(10);

  HTTPClient http;
  
  String s = "http://192.168.173.1/servip.php?locip=";
  s += WiFi.localIP().toString();
  
  http.begin(s);
  
  int httpCode = http.GET();
  
  http.end();
}
 
void loop() {
  WiFiClient client = server.available();
  if (!client) {
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
