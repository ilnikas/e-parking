<?php
   if( isset($_POST['demCurve']) && isset($_POST['polid'])  ) {

   if(preg_match("/^([0-2])$/",$_POST["numSpaces"])) {

   $curve = $_POST['demCurve'];
   $polygonId = $_POST['polid'];

   require_once("/var/www/phpIncludes/dbConnect.php"); // CONNECT TO DB returns connection as $conn

   $myquery = "UPDATE Polygons SET curve_id='$curve' where polygon_id='$polygonId';";
   $conn->query($myquery);

   mysqli_close($conn); }

   else { exit; //IF INPUT NOT VALID POSSIBLE SQL INJECTION SINCE IT'S ALREADY VALIDATED CLIENT SIDE
   }

   }



?>

