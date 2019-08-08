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
?>