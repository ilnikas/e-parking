CREATE TABLE IF NOT EXISTS Demand_Curves (
    curve_id TINYINT UNSIGNED NOT NULL,
    time_ TINYINT UNSIGNED NOT NULL,
    demand TINYINT UNSIGNED NOT NULL,
    PRIMARY KEY (curve_id, time_)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Polygons (
    polygon_id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    population_block MEDIUMINT UNSIGNED NOT NULL,
    centroid_lat DECIMAL(10,8) NOT NULL,
    centroid_lng DECIMAL(11,8) NOT NULL,
    parking_spaces MEDIUMINT UNSIGNED DEFAULT 100 NOT NULL, -- Initially assumes that every block has 100 available parking spaces
    curve_id TINYINT UNSIGNED NOT NULL, 
    FOREIGN KEY (curve_id) REFERENCES Demand_Curves(curve_id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Coordinates (
    point_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    polygon_id MEDIUMINT UNSIGNED NOT NULL,
    lat DECIMAL(10,8) NOT NULL, -- 8 bit precision after the decimal point (1.11mm precission!)
    lng DECIMAL(11,8) NOT NULL, -- 8 bit precision after the decimal point (1.11mm precission!)
    FOREIGN KEY (polygon_id) REFERENCES Polygons(polygon_id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=INNODB;
