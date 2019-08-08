<?php


//______________CHANGE THE VALUE OF VARIABLES TO CHANGE USERNAME AND/OR PASSWORD_________________
$adminUsername = "HIDDEN";
$adminPassword = "HIDDEN";
//______________----------------------------------------------------------------_________________




$username = password_hash($adminUsername,PASSWORD_BCRYPT); //No need to display username so this is hashed as well
$password = password_hash($adminPassword,PASSWORD_BCRYPT); //replace first arguement with your password
?>