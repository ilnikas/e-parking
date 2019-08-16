<?php
    require_once("simulationFunction.php");
    if(isset($_POST["timeToRun"])) {
        if(preg_match("/^([01]\d|2[0-3])([0-5]\d)$/",$_POST["timeToRun"])) { //CHECKING IF INPUT IS VALID
            $myTime = $_POST["timeToRun"];
            $myTime = substr_replace($myTime ,"00",-2); //CHANGING TIME FROM HHMM TO HH00 BECAUSE CURRENT VALUES IN DEMAND_CURVES TABLE CONTAINS TIME IN THAT FORMAT --IF MORE TIME VALUES ARE ADDED ADJUST THIS

            echo json_encode(simulate($myTime));

        } else {
            exit; //IF INPUT NOT VALID POSSIBLE SQL INJECTION SINCE IT'S ALREADY VALIDATED CLIENT SIDE
        }
    } else {
        exit;
    }
?>