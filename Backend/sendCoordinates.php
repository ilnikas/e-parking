<?php

require("/var/www/phpIncludes/dbConnect.php"); //returns database connection as $conn --File put outside of /var/www/html for security reasons

$result = $conn->query("SELECT ST_AsGeoJSON(coordinates) from Polygons;");
$currentRow = 0; //IF ADDED BY 1 IT'S ALSO POLYGON ID

$numberRows = mysqli_num_rows($result);

echo '{ "type": "FeatureCollection", "features": ['; //FORMATTING DATA AS FEAUTURE COLLECTION SO EVERYTHING WILL BE SEND WITH ONE AJAX CALL

while ($row = mysqli_fetch_row($result)) {
    echo '{ "type": "Feature", "geometry": '; //FORMATTING DATA AS FEAUTURE COLLECTION

    foreach ($row as $field){ 
        echo $field; //GETTING DATA FOR EACH FIELD OF EVERY ROW (ALREADY IN JSON FORMAT NO NEED FOR json_encode
    }
    echo "}"; //FORMATTING DATA AS FEAUTURE COLLECTION
    $currentRow = $currentRow + 1;

   if ($currentRow < $numberRows) {echo ", ";} // AT THE LAST FEAUTURE NO NEED TO PRINT ','

}
echo " ] }"; //FORMATTING DATA AS FEAUTURE COLLECTION

mysqli_free_result($result);

mysqli_close($conn);
?>

