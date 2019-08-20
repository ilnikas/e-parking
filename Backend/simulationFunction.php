<?php
    //Make sure time is validated before passed into this function
    //Performs simulation for given time and returns array
    function simulate($time) {
        require("/var/www/phpIncludes/dbConnect.php"); // CONNECT TO DB returns connection as $conn

        $myquery = "SELECT Polygons.polygon_id, Polygons.population_block, Polygons.parking_spaces, Demand_Curves.demand FROM Polygons INNER JOIN Demand_Curves ON Polygons.curve_id = Demand_Curves.curve_id WHERE Demand_Curves.time_ = ".$time." ORDER BY Polygons.polygon_id;";

        $myresult = $conn->query($myquery);

        while ($row = mysqli_fetch_row($myresult)) {
            $stableDemand = (int)ceil(0.2 * $row[1]); //calculating stable demand --number of positions that are never available 
            $spacesLeft = $row[2] - $stableDemand;
            if (($spacesLeft <= 0) || ($row[2] == 0)) { //If stable demand takes up all spaces or if there are no available parking spaces in the block demand is 100%
                $demand = 1; //No spaces available
            } else {
                $availableSpaces = $spacesLeft - (int)ceil($row[3] * $spacesLeft);
                $demand = 1 - ($availableSpaces / $row[2]);
            }
            $demandData[] = array('id' => $row[0], 'demand' => $demand); //APPROPRIATE FORMAT SO JSON_ENCODE WILL WORK
        }

        mysqli_free_result($myresult);
        mysqli_close($conn);

        return $demandData;
    }
?>