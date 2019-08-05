<?php
$xml = simplexml_load_file("data.kml");
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
        echo "Population for placemark is: ". $population;
    } else {
        $population = 0;
        echo "Population for placemark is: ". $population; 
    }
    echo "<br><br>";


    //Getting polygon's coordinates
    if( !empty($record->MultiGeometry->MultiGeometry)){
        $coordinates = $record->MultiGeometry->MultiGeometry->Polygon[0]->outerBoundaryIs->LinearRing->coordinates[0]; //If placemark contains more than one polygons ignore everything but the first
    }  else {
            $coordinates = $record->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates[0];
    }
    print($coordinates);
    $points = explode(" ", $coordinates); //Has stored points in form (LAT,LNG)
    echo "_________________________________________________________________________This was id  ". $id;
    echo "_________________________________________________________________________";
    echo "<br><br>";
    $id++;
}
?>
