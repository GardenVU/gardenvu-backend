#include <OneWire.h>
#include <DallasTemperature.h>

// Define pin configurations
const int ONE_WIRE_BUS = 2; // Pin for the temperature sensor
const int PH_SENSOR_PIN = A0; // Pin for the pH sensor
const int TDS_SENSOR_PIN = A1; // Pin for the TDS sensor
const int WATER_LEVEL_SENSOR_PIN = A2; // Pin for the water level sensor

// Create a new instance for OneWire and DallasTemperature
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);

void setupSensors() {
    // Start the serial communication
    Serial.begin(115200);

    // Start the temperature sensor
    sensors.begin();
}

// Function to read temperature
float readTemperature() {
    // Request the temperature from the sensor
    sensors.requestTemperatures();

    // Get the temperature in Celsius
    float temperature = sensors.getTempCByIndex(0);

    return temperature;
}

// Function to read pH
float readPH() {
    // Read the analog value from the pH sensor
    int sensorValue = analogRead(PH_SENSOR_PIN);

    // Convert the analog value to pH
    float pH = (float)sensorValue * 5.0 / 1024.0;

    return pH;
}

// Function to read TDS
float readTDS() {
    // Read the analog value from the TDS sensor
    int sensorValue = analogRead(TDS_SENSOR_PIN);

    // Convert the analog value to TDS
    float tds = (float)sensorValue * 5.0 / 1024.0;

    return tds;
}

// Function to read water level
float readWaterLevel() {
    // Read the analog value from the water level sensor
    int sensorValue = analogRead(WATER_LEVEL_SENSOR_PIN);

    // Convert the analog value to water level
    float waterLevel = (float)sensorValue * 5.0 / 1024.0;

    return waterLevel;
}

// Function to read all sensors
void readSensors(float* temperature, float* pH, float* tds, float* waterLevel) {
    *temperature = readTemperature();
    *pH = readPH();
    *tds = readTDS();
    *waterLevel = readWaterLevel();
}
