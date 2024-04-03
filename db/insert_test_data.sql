-- Stored procedure to insert test data into the plot_information table
DROP PROCEDURE IF EXISTS insert_plot_information;
DELIMITER //
CREATE PROCEDURE insert_plot_information()
BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE created_at DATETIME;
    SET created_at = NOW() - INTERVAL 5 DAY;
    WHILE i < 3 DO
        INSERT INTO plot_information (name, created_at)
        VALUES (CONCAT('Plot ', i), created_at);
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
    DECLARE start_date DATETIME;
    DECLARE end_date DATETIME;
    DECLARE curr_date DATETIME;
    SELECT COUNT(*) INTO plot_count FROM plot_information;
    SET i = 1;
    WHILE i <= plot_count DO
        SET start_date = NOW() - INTERVAL 5 DAY;
        SET end_date = DATE_ADD(start_date, INTERVAL 5 DAY);
        SET curr_date = start_date;
        WHILE curr_date <= end_date DO
            SET j = 0;
            WHILE j < 10 DO
                INSERT INTO sensor_data (plot_id, time_collected, temperature, pH, tds)
                VALUES (i, curr_date, RAND() * (72 - 68) + 68, RAND() * (7.5 - 6.5) + 6.5, RAND() * (500 - 300) + 300);
                SET j = j + 1;
                SET curr_date = DATE_ADD(curr_date, INTERVAL 1 HOUR);
            END WHILE;
        END WHILE;
        SET i = i + 1;
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