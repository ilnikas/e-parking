CREATE TABLE IF NOT EXISTS Demand_Curves (
    curve_id TINYINT UNSIGNED NOT NULL,
    time_ TINYINT UNSIGNED NOT NULL,
    demand TINYINT UNSIGNED NOT NULL,
    PRIMARY KEY (curve_id, time_)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Polygons (
    polygon_id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    population_block MEDIUMINT UNSIGNED NOT NULL,
    centroid POINT NOT NULL,
    coordinates POLYGON NOT NULL,
    parking_spaces MEDIUMINT UNSIGNED DEFAULT 100 NOT NULL, -- Initially assumes that every block has 100 available parking spaces
    curve_id TINYINT UNSIGNED NOT NULL, 
    FOREIGN KEY (curve_id) REFERENCES Demand_Curves(curve_id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=INNODB;

