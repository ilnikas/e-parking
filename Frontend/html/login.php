<?php
    session_start();
    require_once("/var/www/phpIncludes/credentials.php");
    
    if(!isset($_POST['username']) || (!isset($_POST['password']))) {
        //echo "Παρακαλώ εισάγετε τα στοιχεία σας!";
    } else if (password_verify($_POST['username'],$username) && password_verify($_POST['password'],$password)) {
        $_SESSION["username"] = $username; //session so no one else can access the admin page
        header("Location:admin.php"); //redirecting to admin page
    } else {
        //echo "Λανθασμένα στοιχεία username/password <br>Παρακαλώ προσπαθήστε ξανά";
    }
?>

<!DOCTYPE html>
<html lang="el">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/login.css" type="text/css">
        <title>
            e-parking | Login
        </title>

    </head>

    <body>
        <div id="container">

            <div id="homePageLogo">
                <a href="../index.html" target="_self"> <img id="logo" src="../css/img/logo.png"></a>
            </div>

            <div id="welcomeMessage">
                Καλώς ήρθατε!
            </div>
            
            <div id="mainPageLogin">

                <form method="post" action="login.php">
                    <div id="allInputs">
                        <input class="inputField" type="text" name="username" placeholder="Username">
                        <input class="inputField" id="lastInput" type="password" name="password" placeholder="Password">
                    </div>
                    <input id="submitButton" type="Submit" value="Σύνδεση">
                </form>

            </div>

        </div>
    </body>

</html>
