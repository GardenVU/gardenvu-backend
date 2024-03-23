// Main.ino

// Include the required libraries
#include <WiFi.h>
#include <ESP8266HTTPClient.h>
#include "Pumps.ino"
#include "Sensors.ino"
#include "arduino_secrets.h"

// Network Credentials
const char* ssid = SECRET_SSID;
const char* password = SECRET_PASS;

// Server Details
const char* serverAddress = "http://";

// Setup
void setup() {
  // Start the serial communication
  Serial.begin(115200);

  // Connect to the WiFi network
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to the WiFi network");

  // Setup the pumps
  setupPumps();

  // Setup the sensors
  setupSensors();
}

// Loop
void loop() {
  if ((WiFi.status() == WL_CONNECTED)) {
    // Create HTTP Client
    HTTPClient http;
    http.begin(serverAddress);
    http.addHeader("Content-Type", "application/json");

    // Read the sensor values
    float temperature = readTemperature();
    float pH = readPH();
    float tds = readTDS();
    float waterLevel = readWaterLevel();

    // Construct JSON payload
    String payload = "{\"temperature\":" + String(temperature) + ",\"pH\":" + String(pH) + ",\"tds\":" + String(tds) + ",\"waterLevel\":" + String(waterLevel) + "}";

    // Send POST request
    int httpResponseCode = http.POST(payload);

    // Check the response code
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println(httpResponseCode);
      Serial.println(response);
    } else {
      Serial.println("Error on sending POST: " + String(httpResponseCode));
    }

    // End HTTP Client
    http.end();

    // Turn on the pump
    turnOnPump();

    // Delay for 5 minutes
    delay(1000 * 60 * 5);

    // Turn off the pump
    turnOffPump();
  } else {
    Serial.println("WiFi Disconnected, reconnecting...");
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED) {
      delay(1000);
      Serial.println("Connecting to WiFi...");
    }
    Serial.println("Connected to the WiFi network");
  }
}