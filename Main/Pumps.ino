// Pumps.ino

// Define the pin for the pump relay
const int PUMP_RELAY_PIN = 4;

// Setup
void setupPumps() {
    // Set the pump relay pin as output
    pinMode(PUMP_RELAY_PIN, OUTPUT);
}

// Function to turn on the pump
void turnOnPump() {
    // Turn on the pump
    digitalWrite(PUMP_RELAY_PIN, HIGH);
}

// Function to turn off the pump
void turnOffPump() {
    // Turn off the pump
    digitalWrite(PUMP_RELAY_PIN, LOW);
}
