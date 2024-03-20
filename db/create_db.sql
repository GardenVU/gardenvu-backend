CREATE DATABASE IF NOT EXISTS gardenvu;

USE gardenvu;
CREATE TABLE IF NOT EXISTS plot_information (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS sensor_data (
  id INT AUTO_INCREMENT PRIMARY KEY,
  plot_id INT NOT NULL,
  temperature DECIMAL(5, 2) NOT NULL,
  pH DECIMAL(5, 2) NOT NULL,
  tds DECIMAL(5, 2) NOT NULL,
  waterLevel DECIMAL(5, 2) NOT NULL,
  time_collected TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (plot_id) REFERENCES plot_information(id)
);
