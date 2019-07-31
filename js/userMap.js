//coordinates which the map will initially display  --Currently set to Patras,Greece
const myLong = 38.246208;   
const myLang = 21.735069;
const zoomBy = 14; //How much to zoom into the map initially 

var mymap = L.map('map',{ scrollWheelZoom : false }).setView([myLong, myLang], zoomBy); //Initializing map

const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors'; //copyright to open street maps

const tileUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
const tiles = L.tileLayer(tileUrl, { attribution }); //creating tiles for the map

tiles.addTo(mymap);

//Adding marker
var myMarker = {};
//What will be displayed on the popup
var popupContent = "<form action='kati.php'> <div style='text-align: center;'> <input placeholder='Ακτίνα (μέτρα)' style='display: inline-block; width: 90%; text-align: center;  height: 20px;' type='number' min='1' max='2500' name='radius' oninvalid='this.setCustomValidity(\"Η ακτίνα πρέπει να είναι μεταξύ του 1 και 2500\")' oninput='this.setCustomValidity(\"\")' required> <br>  <input placeholder='Ώρα που θέλετε να είστε εκεί' type='text' name='timeToArrive' pattern='^([01]\\d|2[0-3])([:.])([0-5]\\d)$' required oninvalid='this.setCustomValidity(\"Η ώρα πρέπει να είναι στη μορφή 14.02 ή 14:02\")' oninput='this.setCustomValidity(\"\")' style='margin-top: 10px; height: 20px; text-align: center;'> </div> <br> <div style='margin-top: 12px; text-align: center;'><input style='height: 21px; font-size: 12px; border-radius: 5px; border: 1px solid coral; background-corol: lightgrey;' type='submit' value='Αποστολή'></div> </form>";  

mymap.on("click",function(e) {
    lat = e.latlng.lat;
    lon = e.latlng.lng;

    //removing existing marker if it exists
    if (myMarker != undefined) {
        mymap.removeLayer(myMarker);
    }

    //adding the marker
    myMarker = L.marker([lat,lon]);
    myMarker.addTo(mymap);
    myMarker.bindPopup(popupContent).openPopup(); //Adding popup to enter variables "radius" and "timeToArrive"  that will be sent to server
});

