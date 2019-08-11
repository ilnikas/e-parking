<?php
    if(isset($_POST["timeToRun"])) {
        if(preg_match("/^([01]\d|2[0-3])([0-5]\d)$/",$_POST["timeToRun"])) { //CHECKING IF INPUT IS VALID
            $myTime = $_POST["timeToRun"];
            $myTime = substr_replace($myTime ,"00",-2); //CHANGING TIME FROM HHMM TO HH00 BECAUSE CURRENT VALUES IN DEMAND_CURVES TABLE CONTAINS TIME IN THAT FORMAT --IF MORE TIME VALUES ARE ADDED ADJUST THIS C$

            require("/var/www/phpIncludes/dbConnect.php"); // CONNECT TO DB returns connection as $conn

            $myquery = "SELECT Polygons.polygon_id, Polygons.population_block, Polygons.parking_spaces, Demand_Curves.demand FROM Polygons INNER JOIN Demand_Curves ON Polygons.curve_id = Demand_Curves.curve_id WHERE Demand_Curves.time_ = ".$myTime.";";

            $myresult = $conn->query($myquery);

            while ($row = mysqli_fetch_row($myresult)) {
                $stableDemand = (0.2 * $row[1]) / $row[2]; //calculating stable demand
                $demand = $row[3] + $stableDemand; //calculating updated demand after adding stable demand
                $temp = array('id' => $row[0], 'demand' => $demand);
                $toSend[] = array('id' => $row[0], 'demand' => $demand); //APPROPRIATE FORMAT SO JSON_ENCODE WILL WORK
            }

            echo json_encode($toSend);

            unset($toSend);
            mysqli_free_result($myresult);

            mysqli_close($conn);

        } else {
            exit; //IF INPUT NOT VALID POSSIBLE SQL INJECTION SINCE IT'S ALREADY VALIDATED CLIENT SIDE
        }
    } else {
        exit;
    }
?>