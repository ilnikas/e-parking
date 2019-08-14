<?php

    require_once("simulationFunction.php");

    //Calculates distance in meters given two points in the form of latitude/longitude coordinates using Haversine formula
    function getDistance($latitudeFrom,$longitudeFrom,$latitudeTo,$longitudeTo) {
        $earthRadius = 6371000; //meters --the result unit will be of this type
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    //Returns polygons for which the centroid is within radius (first arguement)
    //Result in array validPolygons or 0 in case there isn't any
    function getPolygonsWithinRadius($radius,$latTo,$lngTo) {
        require_once("/var/www/phpIncludes/dbConnect.php"); // CONNECT TO DB returns connection as $conn
        $myquery = "SELECT polygon_id, ST_X(centroid), ST_Y(centroid), parking_spaces FROM Polygons";
        $myresult = $conn->query($myquery);
        while ($row = mysqli_fetch_row($myresult)) {
            $latFrom = $row[2];
            $lngFrom = $row[1];
            if(getDistance($latFrom,$lngFrom,$latTo,$lngTo) <= $radius) {
                $validPolygons[] = array('id' => $row[0], 'parking_spaces' => $row[3], 'centroid_lat' => $row[2], 'centroid_lng' => $row[1]); //contains polygon id and available parking spaces for polygons that their centroid is within the radius
            }
        }
        mysqli_close($conn);
        if (isset($validPolygons)) {
            return $validPolygons;
        } else {
            return 0;
        }
    }

    //Returns as many random points as the free parking spaces for the polygon --In case no parking spaces are available returns 0
    function generatePointsWithinRadius($polygon, $demandData, $radius = 50) { //Default radius is 50 meters
        //Finding number of free parking spaces at the specified simulation time
        $keyId = $polygon['id'];
        $keyDemand = $demandData[$keyId - 1]['demand']; //demandData array indexes are -1 the id of the polygon they contain (sql querry that calculates them is sorted by id)
    
        $numberOfFreeParkingSpaces = $polygon['parking_spaces'] * (1 - $keyDemand);
        $numberOfFreeParkingSpaces = (int)floor($numberOfFreeParkingSpaces); //rounding down
        if($numberOfFreeParkingSpaces <= 0) {
            return 0;
        }
        
        //Generating as many points as the number of free parking spaces
        $centroidLat = $polygon['centroid_lat'];
        $centroidLng = $polygon['centroid_lng'];
        //TODO CALCULATE RANDOM POINTS WITHING RADIUS OF CENTROID --AS MANY AS FREE PARKING SPACES
        for($i = 0; i < $numberOfFreeParkingSpaces; $i++) {
            //TODO calculate a point (lng,lat) within $radius meters of (centroidLng,centroid///Lat)
        }


    }

//_______________________________________END OF FUNCTION DEFIINITIONS______________________________________________


    $lat = $_POST['latitudeDestination'];
    $lng = $_POST['longitudeDestination'];
    $radius = (int) $_POST['radius']; //returns 0 if it can't convert
    $time = $_POST['time'];


    //Validating user input --Coordinates don't need validating cause they're not provided from user
    $time =  str_replace(".", "", $time); //removing '.' if it exists to time will be in correct format 
    $time = str_replace(":", "", $time); //removing ':' if it exists so time will be in correct format
    $timeRegexp = "/^([01]\d|2[0-3])([0-5]\d)$/";
    if ( ($radius < 10) || (!preg_match($timeRegexp,$time))) {
        exit; //if not valid possible sql injection because data was already validated client side
    }

    $validPolygons = getPolygonsWithinRadius($radius,$lat,$lng); //contains polygon_id and available parking spaces or 0 in case there weren't any valid polygons

    if($validPolygons === 0) {
        exit; //no valid polygons exist
    }


    echo json_encode($validPolygons);

    //Execute simulation for given time
    $time = substr_replace($time ,"00",-2); //CHANGING TIME FROM HHMM TO HH00 BECAUSE CURRENT VALUES IN DEMAND_CURVES TABLE CONTAINS TIME IN THAT FORMAT --IF MORE TIME VALUES ARE ADDED ADJUST THIS
    $demandData = simulate($time);

    //TODO generate random points for each polygon in validPolygons array

?>