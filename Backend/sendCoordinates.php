<?php

require("/var/www/phpIncludes/dbConnect.php"); //returns database connection as $conn --File put outside of /var/www/html for security reasons

$result = $conn->query("SELECT polygon_id, ST_AsGeoJSON(coordinates), curve_id, population_block, parking_spaces from Polygons ORDER BY polygon_id;");
$currentRow = 0; //IF ADDED BY 1 IT'S ALSO POLYGON ID

$numberRows = mysqli_num_rows($result);

//CREATING FEATURE COLLECTINO GEOJSON OBJECT SO IT CAN BE ADDED IMMEDIATELY VIA LEAFLET

$geojsonObject = array(
    'type'      => 'FeatureCollection',
    'features'  => array()
 );

while ($row = mysqli_fetch_row($result)) {

    $feature = array(
        'type' => 'Feature',
        'geometry' => json_decode(($row[1])),
        'properties' => array(
            'id' => $row[0],
            'demandCurve' => $row[2],
            'population' => $row[3],
            'totalParkingSpaces' => $row[4]
        )
    );

    array_push($geojsonObject['features'], $feature);

}
echo json_encode($geojsonObject, JSON_NUMERIC_CHECK);

unset($feature);
unset($geojsonObject);
mysqli_free_result($result);

mysqli_close($conn);
?>

