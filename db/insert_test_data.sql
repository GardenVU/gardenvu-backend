-- Stored procedure to insert test data into the plot_information table
DROP PROCEDURE IF EXISTS insert_plot_information;
DELIMITER //
CREATE PROCEDURE insert_plot_information()
BEGIN
    DECLARE i INT DEFAULT 0;
    WHILE i < 3 DO
        INSERT INTO plot_information (name)
        VALUES (CONCAT('Plot ', i));
        SET i = i + 1;
    END WHILE;
END //
DELIMITER ;

-- Stored procedure to insert test data into the sensor_data table
DROP PROCEDURE IF EXISTS insert_sensor_data;
DELIMITER //
CREATE PROCEDURE insert_sensor_data()
BEGIN
    DECLARE i INT;
    DECLARE plot_count INT;
    DECLARE j INT DEFAULT 0;
    SELECT COUNT(*) INTO plot_count FROM plot_information;
    SET i = 1;
    WHILE i <= plot_count DO
        WHILE j < 10 DO
            INSERT INTO sensor_data (plot_id, temperature, pH, tds, waterLevel)
            VALUES (i, RAND() * 100, RAND() * 14, RAND() * 1000, RAND() * 100);
            SET j = j + 1;
        END WHILE;
        SET i = i + 1;
        SET j = 0;
    END WHILE;
END //
DELIMITER ;

-- Clear the information stored in the tables
USE gardenvu;
DELETE FROM plot_information;
DELETE FROM sensor_data;

-- Call the stored procedures to insert test data
USE gardenvu;
CALL insert_plot_information();

-- Run this line individually to prevent plot_id mismatches
CALL insert_sensor_data();