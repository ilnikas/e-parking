<?php
$servername = "localhost";
$username = "ilias";
$password = "Il1997!@#";
$dbname = "e_parking";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>