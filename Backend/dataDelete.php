<?php
    require_once("/var/www/phpIncludes/dbConnect.php"); // CONNECT TO DB returns connection as $conn

    $myquery = "TRUNCATE TABLE Polygons;";
    $conn->query($myquery); //DELETING DATA

    mysqli_close($conn);
?>