
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Uploading KML</title>
    </head>
    <body>


<?php

//ERROR CHECKING
if ($_FILES['myKmlFile']['error'] > 0) {
    echo 'Αποτυχία μεταφόρτωσης!<br>';
    switch ($_FILES['myKmlFile']['error']) {
        case 1:
            echo 'File size exceeds maximum limit of 40MB';
            break;
        case 3:
            echo 'Partial file upload';
            break;
        case 4:
            echo 'No file was selected';
            break;
        case 6:
            echo 'No temp directory is defined';
            break;
        case 7:
            echo 'Fail to write in disk';
            break;
        case 8:
            echo 'A php extension prevented the upload';
            break;
        default:
            echo 'Unspecified error';
    }
    exit; //IF ERROR DETECTED EXIT
}

//GET MIME FILE TYPE
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $_FILES['myKmlFile']['tmp_name']); //Getting mime type
finfo_close($finfo);

//CHECK IF FILE TYPE IS CORRECT
if (($mime_type != 'application/vnd.google-earth.kml+xml') and ($mime_type != 'application/xml')) {
    echo 'Upload failed!<br>File is not kml';
    exit; //IF FILE NOT KML EXIT
} else if (pathinfo($_FILES['myKmlFile']['name'],PATHINFO_EXTENSION) != 'kml') {
    echo 'Upload failed!<br>Make sure the file is kml';
    exit; //IF EXTENSION NOT kml EXIT
}

$uploaded_file = '/var/www/uploads/data.kml';


if (is_uploaded_file($_FILES['myKmlFile']['tmp_name'])) {
    if (!move_uploaded_file($_FILES['myKmlFile']['tmp_name'], $uploaded_file)) {
        echo 'Upload failed!<br>Fail to move file to the specified directoory';
        exit;
    }
} else {
    echo 'Upload failed!<br>Possible file upload attack';
    exit;
}



//__________________________________PARSING KML AND INSERTING TO DATABASE____________________________
include_once('kmlParser.php');

echo 'Upload completed successfully!'; //This will only be displayed at the end of overall process (including db inserts) because of iframe

?>



    </body>
</html>
