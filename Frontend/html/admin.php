<?php
session_start();
if(!isset($_SESSION['username'])){
   header("Location:login.php");
}
?>


<!DOCTYPE html>
<html lang="el">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/admin.css" type="text/css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>

        <title>
            e-parking | Admin
        </title>

    </head>

    <body onload="setValues()">
        <div id="wrapper">
            <div id="header">
                <img id="logo" src="../css/img/logo.png">
                <a href="../php/logout.php" target="_self">Αποσύνδεση</a>
            </div>
            <div class="mainPart">
                <h3 id="kmlLoadTitle">Φόρτωση kml αρχείου</h3>
                <div id="uploadFile">
                    <form>
                        <div id="chooseFile">
                            <input id="realButton" type="file" name="myKmlFile" accept=".kml" hidden="hidden">
                            <input type="button" id="chooseFileButton" value="Επιλέξτε αρχείο">
                            <span id="infoChooseFile">Δεν έχει επιλεγεί αρχείο</span>
                        </div>
                        <input id="uploadButton" type="button" value="Upload" onClick="fileUpload(this.form,'uploadKml.php','infoUpload'); return false;">
                        <div id="infoUpload"></div>
                    </form>
                </div>
                <h3 id="dataDeleteTitle">Διαγραφή δεδομένων πόλης</h3>
                <div id="deleteData">
                    <button id="deleteDataButton">Διαγραφή</button>
                    <div id="deleteDataModal" class="modal">
                        <div class="modal-content">
                            <span class="closeModal">&times;</span>
                            <p>Θα διαγραφούν όλα τα δεδομένα που αφορούν τον πληθυσμό και την ρυμοτομία της πόλης. Είστε σίγουρος πως θέλετε να συνεχίσετε;</p>
                            <button id="confirmDelete" class="modalButton">Ναι</button>
                            <button id="cancelDelete" class="modalButton">Όχι</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mainPart">
                <h3 id="cityDataTitle">Στοιχεία πόλης</h3>
                <div id="mapAndButtons">
                    <div id="map">
                        map
                    </div>
					<div id="simulationFunc">
					<button id="simulationButtonL"></button>
                    <button id="simulationButtonM">Εκτέλεση εξομοίωσης</button>
					<button id="simulationButtonR"></button>
					</div>
                    <div id="simulationModal" class="modal">
                        <div class="modal-content">
                            <span class="closeModal">&times;</span>
                            <p>Παρακαλώ εισάγετε τις παραμέτρους για εκτέλεση εξομοίωσης<br><br></p>
                            <div id="manualTime">
								<iframe name="votar" style="display:none;"></iframe>
                                <form onsubmit="return validate_simul()"> <!-- action="dummy_php": should be done with AJAX instead -->
                                    (αν το πεδίο παραμείνει κενό, λαμβάνεται υπόψη ως ώρα έναρξης της εξομοίωσης η τρέχουσα ώρα) <br>
                                    <input type="text" id="settime"> <br>Ώρα<br><br>
                                    (αν το πεδίο παραμείνει κενό, βήμα/offset της εξομοίωσης θα είναι τα 10 λεπτά) <br>
                                    <input type="text" id="aftertime"> <br> Βήμα εξομοίωσης σε λεπτά <br><br>
                                    <button type="submit" class="modalButton">Εκτέλεση</button>
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
    <script src="../js/startSimulation.js"></script>
    <script src="../js/adminMap.js"></script>
    <script src="../js/uploadKmlFile.js"></script>

</html>
