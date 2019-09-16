<?php
$servername = "localhost";
$username = "HIDDEN USERNAME";
$password = "HIDDEN PASSWORD";
$dbname = "e_parking";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
mysqli_set_charset($conn,"utf8"); //Following command was used on database to supprot utf-8 -- ALTER DATABASE e_parking CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
?>