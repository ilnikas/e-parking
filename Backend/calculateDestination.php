<?php

    require_once("simulationFunction.php");

    require_once("dbscan.php");

    //Used for usort function to sort multidimensional array by sub-arrays size
    function cmp($a, $b){ 
        return (count($b) - count($a));
    }

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
        $radiusDeg = $radius / 111300; //Converting meters to degrees - One degree in the equator is 111300 meters
        //TODO CALCULATE RANDOM POINTS WITHING RADIUS OF CENTROID --AS MANY AS FREE PARKING SPACES
        for($i = 0; $i < $numberOfFreeParkingSpaces; $i++) {
            //TODO calculate a point (lng,lat) within $radius meters of (centroidLng,centroid///Lat)
            $u = lcg_value(); //Generating random value in (0,1)
            $v = lcg_value(); //Generating random value in (0,1)
            $w = $radiusDeg * sqrt($u);
            $t = 2 * pi() * $v;
            $x = $w * cos($t);
            $y = $w * sin($t);

            $xFixed = $x / cos(deg2rad($centroidLat));  // Adjusting x-coordinate for the shrinking of the east-west distances
            $newLat = $y + $centroidLat;
            $newLng = $xFixed + $centroidLng;
            $randomPoints[] = array('latitude' => $newLat, 'longitude' => $newLng);
        }
        return $randomPoints;

    }

    function getClusterCentroid($data) {

        if (!is_array($data)) return FALSE;

        $numberOfPoints = count($data);

        $X = 0.0;
        $Y = 0.0;
        $Z = 0.0;

        foreach ($data as $point)
        {
            $lat = $point['latitude'] * pi() / 180;
            $lon = $point['longitude'] * pi() / 180;

            $a = cos($lat) * cos($lon);
            $b = cos($lat) * sin($lon);
            $c = sin($lat);

            $X += $a;
            $Y += $b;
            $Z += $c;
        }

        $X /= $numberOfPoints;
        $Y /= $numberOfPoints;
        $Z /= $numberOfPoints;

        $lon = atan2($Y, $X);
        $hyp = sqrt($X * $X + $Y * $Y);
        $lat = atan2($Z, $hyp);

        $finalLat = $lat * 180 / pi();
        $finalLng = $lon * 180 / pi();
        return array('latitude' => $finalLat, 'longitude' => $finalLng);
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


    //Execute simulation for given time
    $time = substr_replace($time ,"00",-2); //CHANGING TIME FROM HHMM TO HH00 BECAUSE CURRENT VALUES IN DEMAND_CURVES TABLE CONTAINS TIME IN THAT FORMAT --IF MORE TIME VALUES ARE ADDED ADJUST THIS
    $demandData = simulate($time);

    
    $largestClusters = array(); //Here will be stored the clusters that contain the most points
    for($i = 0; $i < sizeof($validPolygons); $i++) {
        $pointsForDBScan = generatePointsWithinRadius($validPolygons[$i],$demandData); //TODO handle the case where the function returns 0 and move to the next polygon
        if ($pointsForDBScan !== 0) {
            //Generate unique id for each point
            $idStart = 'AAA';
            $pointIds = array();
            for($k = 0; $k < sizeof($pointsForDBScan); $k++){
                $pointIds[$k] = $idStart++; //Going back to actual points using index --$pointIds[0] is id for $pointsForDBScan[0]
            }
            //Generating upper diagonal distance matrix
            $distanceMatrix = array();
            //For every point
            for($j = 0; $j < sizeof($pointIds); $j++){
                $distanceMatrix[$pointIds[$j]] = array(); //For each point there is an array that contains its distances with other points
                for($l = $j + 1; $l < sizeof($pointIds); $l++){  //For last point there will only be an empty array
                    $tempDistance = getDistance($pointsForDBScan[$j]['latitude'],$pointsForDBScan[$j]['longitude'],$pointsForDBScan[$l]['latitude'],$pointsForDBScan[$l]['longitude']);
                    $distanceMatrix[$pointIds[$j]][$pointIds[$l]] = $tempDistance;
                }
            }
            //Finished generating upper diagonal distance matrix
            //My distance matrix is $distanceMatrix and my point id's are $pointIds --Inputs for DBScan algorithm

            // Setup DBSCAN with distance matrix and unique point IDs
            if(sizeof($distanceMatrix) > 0) {
                $DBSCAN = new DBSCAN($distanceMatrix, $pointIds);
                $epsilon = 35;
                $minpoints = 5;
                // Perform DBSCAN clustering
                $clusters = $DBSCAN->dbscan($epsilon, $minpoints);  //Here are all the clusters calculated for polygon $i
                //Finding the biggest cluster(s)
                usort($clusters, 'cmp'); //Storing by size of each sub-array
                $maxClusterSize = sizeof($clusters[0]); //Biggest size stored here
                for ($counter = 0; $counter < sizeof($clusters); $counter++) {
                    if (sizeof($clusters[$counter]) == $maxClusterSize) {
                        //Changing from id's to points
                        foreach($clusters[$counter] as &$pointId) {
                            $key = array_search($pointId, $pointIds);
                            $pointId = $pointsForDBScan[$key];
                        }
                        unset($pointId); // breaking the reference
                        array_push($largestClusters,$clusters[$counter]); //Adding largest cluster(s) for polygon to array largestClusters
                    } else {
                        break;
                    }
                }
            }

        } //else move to the next polygon
          
    }

    //Largest cluster for each polygon has been stored to array $largestClusters
    usort($largestClusters, 'cmp'); //Storing by size of each sub-array
    $maxSize = sizeof($largestClusters[0]);
    $finalClusters = array(); //this contains the biggest clusters from the $largestClusters array (could be more than one)
    for ($counter =0; $counter < sizeof($largestClusters); $counter++) {
        if (sizeof($largestClusters[$counter]) == $maxSize) {
            array_push($finalClusters,$largestClusters[$counter]);
        } else {
            break;
        }
    }
    //TODO calculate centroid for each cluster in $finalClusters
    foreach($finalClusters as $cluster) {
        $centroid = getClusterCentroid($cluster);
        $distance = getDistance($lat,$lng,$centroid['latitude'],$centroid['longitude']);
        $toSend[] = array('centroid' => $centroid, 'distance' => $distance);
    }

    echo json_encode($toSend);


    

    //TODO Calculate centroid(s) for above cluster(s)
    //TODO Calculate distance(s) between point(s) and user destination
    //TODO Generate and echo JSON with calculated information

?>