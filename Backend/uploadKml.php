
<!DOCTYPE html>
<html lang="el">
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
            echo 'Το αρχείο ξεπερνά το μέγιστο επιτρεπτό όριο των 40MB';
            break;
        case 3:
            echo 'Μερική μεταφόρτωση αρχείου';
            break;
        case 4:
            echo 'Δεν επιλέχθηκε αρχείο';
            break;
        case 6:
            echo 'Δεν έχει οριστεί temp directory';
            break;
        case 7:
            echo 'Αποτυχία εγγραφής στο δίσκο';
            break;
        case 8:
            echo 'Κάποιο php extension απέτρεψε τη μεταφόρτωση';
            break;
        default:
            echo 'Αδιευκρίνηστο σφάλμα';
    }
    exit; //IF ERROR DETECTED EXIT
}

//GET MIME FILE TYPE
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $_FILES['myKmlFile']['tmp_name']); //Getting mime type
finfo_close($finfo);

//CHECK IF FILE TYPE IS CORRECT
if (($mime_type != 'application/vnd.google-earth.kml+xml') and ($mime_type != 'application/xml')) {
    echo 'Αποτυχία μεταφόρτωσης!<br>Το αρχείο δεν είναι τύπου kml';
    exit; //IF FILE NOT KML EXIT
} else if (pathinfo($_FILES['myKmlFile']['name'],PATHINFO_EXTENSION) != 'kml') {
    echo 'Αποτυχία μεταφόρτωσης!<br>Βεβαιωθείτε πως το αρχείο είναι τύπου kml';
    exit; //IF EXTENSION NOT kml EXIT
}

$uploaded_file = '/var/www/uploads/data.kml';


if (is_uploaded_file($_FILES['myKmlFile']['tmp_name'])) {
    if (!move_uploaded_file($_FILES['myKmlFile']['tmp_name'], $uploaded_file)) {
        echo 'Αποτυχία μεταφόρτωσης!<br>Αποτυχία μεταφοράς του αρχείου στο ζητούμενο κατάλογο';
        exit;
    }
} else {
    echo 'Αποτυχία μεταφόρτωσης!<br>Πιθανό file upload attack';
    exit;
}

echo 'Η μεταφόρτωση ολοκληρώθηκε επιτυχώς!';

//__________________________________PARSING KML AND INSERTING TO DATABASE____________________________
include_once('kmlParser.php');


?>



    </body>
</html>
