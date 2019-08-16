<?php
session_start();
if(!isset($_SESSION['username'])){
   header("Location:login.php");
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="../css/img/fav.ico" />
        <link rel="stylesheet" href="../css/admin.css" type="text/css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> <!-- Mostyly for AJAX -->

        <title>
            e-parking | Admin
        </title>

    </head>

    <body onload="setValues()">
        <div id="wrapper">
            <div id="header">
                <img id="logo" src="../css/img/logo.png">
                <a href="../php/logout.php" target="_self">Logout</a>
            </div>
            <div class="mainPart">
                <h3 id="kmlLoadTitle">Load KML File</h3>
                <div id="uploadFile">
                    <form>
                        <div id="chooseFile">
                            <input id="realButton" type="file" name="myKmlFile" accept=".kml" hidden="hidden">
                            <input type="button" class="otherbutton" id="chooseFileButton" value="Choose file">
                            <span id="infoChooseFile">No file has been chosen</span>
                        </div>
                        <input id="uploadButton" type="button" value="Upload" onClick="fileUpload(this.form,'../php/uploadKml.php','infoUpload'); return false;">
                        <div id="infoUpload"></div>
                    </form>
                </div>
                <h3 id="dataDeleteTitle">Delete city data</h3>
                <div id="deleteData">
                    <button id="deleteDataButton">Delete</button>
                    <div id="deleteDataModal" class="modal">
                        <div class="modal-content">
                            <span class="closeModal">&times;</span>
                            <p>All data concerning city architecture and population will be deleted. Are you sure you want to continue?</p>
                            <button id="confirmDelete" class="modalButton">Yes</button>
                            <button id="cancelDelete" class="modalButton">No</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mainPart">
                <h3 id="cityDataTitle">City Data</h3> <br>
                <div id="mapAndButtons">
                    <div id="map">
                        map
                    </div>
					<div id="simulationFunc">
					<button id="simulationButtonL"></button>
                    <button id="simulationButtonM">Execute simulation</button>
					<button id="simulationButtonR"></button>
					</div>
                    <div id="simulationModal" class="modal">
                        <div class="modal-content">
                            <span class="closeModal">&times;</span>
                            <p>Please enter parameters for simulation<br><br></p>
                            <div id="manualTime">
								<iframe name="votar" style="display:none;"></iframe>
                                <form onsubmit="return validate_simul()"> <!-- action="dummy_php": should be done with AJAX instead -->
                                    (If field remains blank, simulation time is set as the current time) <br>
                                    <input type="text" id="settime"> <br>Time<br><br>
                                    <input type="text" id="aftertime"> <br> Simulation step in minutes <br><br>
                                    <button type="submit" class="modalButton">Execute</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
	
    <script src="../js/chooseKmlFile.js"></script>
    <script src="../js/confirmDataDelete.js"></script>
    <script src="../js/adminMap.js"></script>
    <script src="../js/uploadKmlFile.js"></script>
    <script src="../js/getPolygons.js"></script>
    <script src="../js/adminSimulation.js"></script>
    <script src="../js/adminPopup.js"></script>
    <script src="../js/simulation.js"></script>
    <script src="../js/dataDelete.js"></script>

</html>
