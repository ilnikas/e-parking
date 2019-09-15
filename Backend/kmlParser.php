<?php

function insertToPolygons($connection,$coordinates,$population,$curve) {
    $setCoordinates = "SET @_coordinates = ST_GeomFromText('" .$coordinates."')"; //MYSQL VARIABLE _coordinates contains coordinates as POLYGON data type
    $setPopulation = "SET @_population = ".$population; //MYSQL VARIABLE _population contains population
    $setCentroid = "SET @_centroid = ST_Centroid(@_coordinates)"; //MYSQL VARIABLE _centroid contains centroid as POINT data type
    $setCurveId = "SET @_curveId = ".$curve; //MYSQL VARIABLE _curveId contais curve id for polygon

    //executing the above querries
if ($connection->query($setCoordinates) === TRUE) { /*echo "Succesfull";*/ } else { /*echo "FAiled";*/}
if ($connection->query($setPopulation) === TRUE) { /*echo "Succesfull";*/ } else { /*echo "FAiled";*/}
if ($connection->query($setCentroid) === TRUE) {/*echo "Succesfull";*/} else { /*echo "FAiled";*/}
if ($connection->query($setCurveId) === TRUE) { /*echo "Succesfull";*/} else { /*echo "FAiled";*/}

// Inserting data
if($population != 0){
    $parkingSpaces = mt_rand(0.15*$population,0.8*$population); //Initial parking spaces values are generated randomly
} else {
    $parkingSpaces = mt_rand(20,100);
}
$insertQuerry = "INSERT INTO Polygons (population_block,centroid,coordinates,parking_spaces,curve_id) VALUES (@_population,@_centroid,@_coordinates,".$parkingSpaces.",@_curveId)";
if ($connection->query($insertQuerry) === TRUE) { /*echo "Insert Querry Succesfull";*/ } else { /*echo "Insert Querry FAiled";*/}

}



require("/var/www/phpIncludes/dbConnect.php"); //returns database connection as $conn --File put outside of /var/www/html for security reasons

if ($conn->query("TRUNCATE TABLE Polygons;") === TRUE) {  //DELETES DATA ON TABLE Polygon at beggining
    echo "Successfully deleted preexisting polygon data.<br>";
} else {  
    echo '<script language="javascript">';
    echo 'alert("Could not delete preexisting polygon data")';
    echo '</script>';
}

$xml = simplexml_load_file("/var/www/uploads/data.kml"); //FILE data.kml MUST BE IN THE SPECIFIED DIRECTORY
$data = $xml->Document->Folder->Placemark;
$id = 1;
foreach ($data as $record) {

    //Getting population for each placemark SAVES TO VARIABLE population
    $desc = $record->description;

    $descHtml = new DOMDocument();
    $descHtml->loadHTML(htmlspecialchars_decode((string)$desc));

    $population = $descHtml->getElementsByTagName('span')->item(5); //TODO Better get attribute with name population instead of assuming it's always the 5th span element
    if (!empty($population)) {
        $population = $population->textContent;
    } else {
        $population = 0; //Assumes population is 0 - for example a mall has available parking spaces but 0 population
    }


    //Getting polygon's coordinates
    if( !empty($record->MultiGeometry->MultiGeometry)){
        $coordinates = $record->MultiGeometry->MultiGeometry->Polygon[0]->outerBoundaryIs->LinearRing->coordinates[0]; //If placemark contains more than one polygons ignore everything but the first
    }  else {
            $coordinates = $record->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates[0];
    }
    $coordinates = str_replace(" ","_",$coordinates); //tood replace "_" with ","
    $coordinates = str_replace(",","|",$coordinates); //todo replace "|" with " "
    $coordinates = str_replace("_",",",$coordinates);
    $coordinates = str_replace("|"," ",$coordinates);
    $mySQLCoordinates = "POLYGON((" . $coordinates . "))"; 
    


    insertToPolygons($conn,$mySQLCoordinates,$population,rand(0,2));
}
mysqli_close($conn);
?>
