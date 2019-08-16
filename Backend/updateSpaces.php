<?php
   if( isset($_POST['numSpaces']) && isset($_POST['polid']) ) {

   if(preg_match("/^([0-9]|[1-9][0-9]|[1-9][0-9][0-9]|[1-4][0-9][0-9][0-9])$/",$_POST["numSpaces"])) {

   $spaces = $_POST['numSpaces'];
   $polygonId = $_POST['polid'];

   require_once("/var/www/phpIncludes/dbConnect.php"); // CONNECT TO DB returns connection as $conn

   $myquery = "UPDATE Polygons SET parking_spaces='$spaces' where polygon_id='$polygonId';";
   $conn->query($myquery);

   mysqli_close($conn); }

   else { exit; //IF INPUT NOT VALID POSSIBLE SQL INJECTION SINCE IT'S ALREADY VALIDATED CLIENT SIDE
   }

   }



?>

