#include <ESP8266WiFi.h>
#include <SPI.h>
#include <ESP8266HTTPClient.h>

const char* ssid = "Wireless Switch"; // WiFi ssid to connect to
const char* password = "88192010"; // WiFi Password

int connInd = 16; // LED to blink when WiFi is not connected yet

WiFiServer server(80); // Define server in port 80

void setup() {
  pinMode(connInd, OUTPUT); // Set pin 16 as OUTPUT
  digitalWrite(connInd, HIGH); // Set pin 16 to HIGH (the led is off)
  
  WiFi.begin(ssid, password); // Connecting to WiFi with the information given above
   
  while (WiFi.status() != WL_CONNECTED) { // If not connected yet
    digitalWrite(connInd, LOW); // Turn on led on pin 16
    delay(500); // Add delay for half seconds
    digitalWrite(connInd, HIGH); // Then turn off the led on 16
    delay(500); // Delay again for half seconds
  }
  
  // If the program reaches here that means we are already connected to the WiFi
  server.begin(); // Begin the server on port 80
  
  delay(10); // Unnecessary delay

  HTTPClient http; // Define HTTPClient object named http
  
  String s = "http://192.168.173.1/servip.php?locip="; // Please read the README.md to understand what and why do I need this line
  s += WiFi.localIP().toString();
  
  http.begin(s); // Initialize http request
  
  int httpCode = http.GET(); // Send http request to 192.168.173.1
  
  http.end(); // Close http request
}
 
void loop() {
  WiFiClient client = server.available(); // Define client
  if (!client) {
    return; // If no client is connected, then return back to the loop, and check for client again, and so on
  }
  
  String request = client.readStringUntil('\r'); // Read the client request
  String led = ""; // Initialize a String called led
  int ledPin; // Initialize an integer led pin
  
  if(request.indexOf("ON")!=-1) { // If the request is ON then do
    // The request string -> GET /ledpin=ON HTTP/1.1
    // So we need to fetch the ledpin to know which pin should be turned on
    led = request.substring(request.indexOf("/")+1,request.length()-12);
    // So we just substring it by the index of '/' plus one until the length of the request minus twelve
    // Now we get the led pin requested by the user to be turned on
    // But the led variable is string so we need to convert to integer first before using it
  } else if(request.indexOf("OFF")!=-1) { // If the request is OFF then do
    // Same as before, we just need to get the pin
    led = request.substring(request.indexOf("/")+1,request.length()-13);
  } else { // Else if request is none above
    led = "0"; // Set led variable to '0'
  }
  ledPin = led.toInt(); // Converts string to integer
  if(ledPin == 0) { // Therefore if the ledPin is equal to zero
    return; // Return back to the loop
  }
  pinMode(ledPin, OUTPUT); // Set desired pin as OUTPUT
  
  if (request.indexOf("ON") != -1) { // If request contains ON
    digitalWrite(ledPin, LOW); // Lights up the LED
  } 
  if (request.indexOf("OFF") != -1){ // Else if request contains OFF
    digitalWrite(ledPin, HIGH); // Turns off the LED
  }
}
