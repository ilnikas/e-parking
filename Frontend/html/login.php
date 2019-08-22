<?php
session_start();
require_once("/var/www/phpIncludes/credentials.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wrong = NULL;

    if (password_verify($_POST['username'],$username) && password_verify($_POST['password'],$password)) {
        $_SESSION["username"] = $username; //session so no one else can access the admin page
        header("Location:admin.php"); //redirecting to admin page
    } else {
        $wrong = "Please try again";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
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
                Welcome
            </div>

            <div id="mainPageLogin">

                <form method="post" action="login.php">
                    <div id="allInputs">
                        <input class="inputField" type="text" name="username" placeholder="Username">
                        <input class="inputField" id="lastInput" type="password" name="password" placeholder="Password">
                        <?php
                          if(isset($wrong)) {
                            echo "<p style=text-align: center;";
                            echo $wrong;
                            echo "</p>";
                          }
                        ?>
                    </div>
                    <input id="submitButton" name="btnSubmit" type="Submit" value="Login">
                </form>

            </div>

        </div>
    </body>

</html>

