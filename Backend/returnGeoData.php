<?php
session_start();

mysql_connect("localhost", "tasos", "Xynos1@#") or
    die("Could not connect: " . mysql_error());
mysql_select_db("e_parking");

$result = mysql_query("select ST_AsGeoJSON(coordinates) from Polygons;");

while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
    printf ("ID: %s  Coordinates: %s", $row[0], $row["coordinates"]);
}

mysql_free_result($result);
?>
