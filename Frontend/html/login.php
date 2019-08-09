<?php
    session_start();
    require_once("/var/www/phpIncludes/credentials.php");

    $cred = NULL;
    $wrong = NULL;



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $myusername = $_POST['username'];
      $mypassword = $_POST['password'];

      if (password_verify($_POST['username'],$username) && password_verify($_POST['password'],$password)) {
        $_SESSION["username"] = $username; //session so no one else can access the admin page
        header("Location:admin.php"); //redirecting to admin page
    } else if (($myusername == "") || ($mypassword == "")){
        $cred = "Παρακαλώ εισάγετε τα στοιχεία σας!";
        $wrong = NULL;
    } else {
        $wrong = "Λανθασμένα στοιχεία username/password.<br>Παρακαλώ προσπαθήστε ξανά";
        $cred = NULL;
        }
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
                        <p>
                        <?php
                          echo isset($cred) ? $cred : "";
                          echo isset($wrong) ? $wrong : "";
                        ?>
                        </p>
                    </div>
                    <input id="submitButton" name="btnSubmit" type="Submit" value="Σύνδεση">
                </form>

            </div>

        </div>
    </body>

</html>

