# GardenVU Backend Setup Guide

This document provides step-by-step instructions for setting up the Gardenvu-backend environment. Please follow the steps in the order they are given.

## Prerequisites

Before starting, ensure that you have the following installed on your system:

- WAMP Server
- MySQL Workbench

## Initial Setup

### Step 1: Install WAMP

Download and install the WAMP server from its official website.

### Step 2: Install MySQL Workbench

Download and install MySQL Workbench from its official website.

### Step 3: Clone the Back-End Repository

Clone the GardenVU back-end repository to your local machine.

## Database Configuration

### Step 4: Establish a New MySQL Connection

1. Open MySQL Workbench.
2. Click the '+' icon next to MySQL Connections.
3. Name the new connection `GardenVU`.
4. Leave the password field empty (or set as per your configuration).
5. Click 'Test Connection' to ensure it's successful.

### Step 5: Execute SQL Scripts

1. In the GardenVU connection, run the `create_db.sql` and `insert_test_data.sql` scripts.
2. Refresh the schemas in the sidebar to confirm database creation.

## Server Setup

### Step 6: Prepare WAMP Server Directory

1. Create a new folder named `gardenvu` in `C:\wamp64\www`.
2. Copy all files from the `php\localhost` folder into `C:\wamp64\www\gardenvu`.

### Step 7: Configure Database in PHP

1. Inside the `gardenvu` folder, create a new file named `db_config.php`.
2. Add the following PHP code to the file:

    ```php
    <?php
    // Database configuration
    $dbHost     = "DB_HOSTNAME";
    $dbUsername = "DB_USERNAME";
    $dbPassword = "DB_PASSWORD";
    $dbName     = "GardenVU";

    // Create database connection
    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    ?>
    ```

3. Replace `DB_HOSTNAME`, `DB_USERNAME`, and `DB_PASSWORD` with your actual database details.

### Step 8: Verify Localhost Connection

1. Open a web browser and navigate to `http://localhost/gardenvu/`.
2. Append a PHP file name and any parameters to the URL to test different functionalities. For example:
   - Configuration test: `http://localhost/gardenvu/db_config.php`
   - Sensor data retrieval: `http://localhost/gardenvu/getSensorData.php?num_points=X` (replace `X` with the desired number of data points).

## Front-End Setup

### Step 9: Clone the Front-End Repository

Clone the Gardenvu front-end repository to your local machine.

### Step 10: Launch the Front-End Application

1. Open a terminal in the front-end repository directory.
2. Run the command `npm start`.
3. Follow the `localhost` link provided in the terminal to view the application.

---

For any additional help or troubleshooting, refer to the repository's issue tracker or contact the maintainers.
