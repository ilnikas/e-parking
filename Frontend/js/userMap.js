//coordinates which the map will initially display  --Currently set to Thessaloniki,Greece
const myLong = 40.628689;  
const myLang = 22.956073;
const zoomBy = 13; //How much to zoom into the map initially

var latDest; //Storing coordinate for user destination latitude
var lngDest; //Storing y for user destination longitude

var mymap = L.map('map',{ scrollWheelZoom : false }).setView([myLong, myLang], zoomBy); //Initializing map

const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors'; //copyright to open street maps

const tileUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
const tiles = L.tileLayer(tileUrl, { attribution }); //creating tiles for the map

if(/Android [4-9]/.test(navigator.appVersion)) {
   window.addEventListener("resize", function() {
      if(document.activeElement.tagName=="INPUT" || document.activeElement.tagName=="TEXTAREA") {
         window.setTimeout(function() {
            document.activeElement.scrollIntoViewIfNeeded();
         },0);
      }
   })
}


tiles.addTo(mymap);

//Adding marker
var myMarker = {};
//What will be displayed on the popup
var popupContent = "<form id='popupForm'> <div style='text-align: center;'> <input id='radiusInput' placeholder='Ακτίνα (μέτρα)' style='display: inline-block; width: 97%; text-align: center;  height: 20px;' type='number' min='10' max='2500' name='radius' oninvalid='this.setCustomValidity(\"Η ακτίνα πρέπει να είναι μεταξύ του 10 και 2500\")' oninput='this.setCustomValidity(\"\")' required> <br>  <input id='timeInput' placeholder='Ώρα άφιξης' type='text' name='timeToArrive' pattern='^([01]\\d|2[0-3])([:.])([0-5]\\d)$' required oninvalid='this.setCustomValidity(\"Η ώρα πρέπει να είναι στη μορφή 14.02 ή 14:02\")' oninput='this.setCustomValidity(\"\")' style='margin-top: 10px; height: 20px; text-align: center;'> </div> <br> <div style='margin-top: 12px; text-align: center;'><input style='height: 21px; font-size: 12px; border-radius: 5px; border: 1px solid coral; background-corol: lightgrey;' type='submit' value='Αποστολή'></div> </form>";  

mymap.on("click",function(e) {
   latDest = e.latlng.lat;
   lngDest = e.latlng.lng;

   //removing existing marker if it exists
   if (myMarker != undefined) {
      mymap.removeLayer(myMarker);
   }

   //adding the marker
   myMarker = L.marker([latDest,lngDest]);
   myMarker.addTo(mymap);
   myMarker.bindPopup(popupContent).openPopup(); //Adding popup to enter variables "radius" and "timeToArrive"  that will be sent to server

   $(document).on("submit", "#popupForm", function(event){
      $.ajax({
         type: "POST",
         url: "../php/calculateDestination.php",
         dataType: "json",
            data: { 
               'latitudeDestination': latDest,
               'longitudeDestination': lngDest,
               'radius' : document.getElementById("radiusInput").value,
               'time' : document.getElementById("timeInput").value
            },
            success: function(destination) {
               console.log(destination); //IF UNABLE TO FIND ANY RETURNS NULL -- TODO handle that case
            },
            error: function () {
               alert('Error');
            }
      });
      return false;
   });
});

