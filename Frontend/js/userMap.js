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

//Android keyboard fix messes with vh fix
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
var markerCounter = 0;
var destMarker = [];
//Adding marker
var myMarker;
var greyIcon = new L.Icon({
   iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-grey.png',
   //shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
   iconSize: [25, 41],
   iconAnchor: [12, 41],
   popupAnchor: [1, -34],
   //shadowSize: [41, 41]
 });
 
//What will be displayed on the popup
var popupContent = "<form id='popupForm'> <div style='text-align: center;'> <input id='radiusInput' placeholder='Radius (meters)' style='display: inline-block; width: 97%; text-align: center;  height: 20px;' type='number' min='10' max='2500' name='radius' oninvalid='this.setCustomValidity(\"Radius must be between 10 and 2500 meters\")' oninput='this.setCustomValidity(\"\")' required> <br>  <input id='timeInput' placeholder='Arrival time' type='text' name='timeToArrive' pattern='^([01]\\d|2[0-3])([:.])([0-5]\\d)$' required oninvalid='this.setCustomValidity(\"Time must be in 14.02 or 14:02 format\")' oninput='this.setCustomValidity(\"\")' style='margin-top: 10px; height: 20px; text-align: center;'> </div> <br> <div style='margin-top: 12px; text-align: center;'><input style='height: 21px; font-size: 12px; border-radius: 5px; border: 1px solid coral; background-corol: lightgrey;' type='submit' value='Αποστολή'></div> </form>";  




mymap.on("click",function(e) {
   latDest = e.latlng.lat;
   lngDest = e.latlng.lng;

   //removing existing marker if it exists
   if (myMarker != undefined) {
      mymap.removeLayer(myMarker);
   }

   //adding the marker
   myMarker = L.marker([latDest,lngDest], {icon: greyIcon}).addTo(mymap);
   myMarker.bindPopup(popupContent); //Adding popup to enter variables "radius" and "timeToArrive"  that will be sent to server

  
});

$(document).on("submit", "#popupForm", function(event){
   var simTime = document.getElementById("timeInput").value;
   mymap.closePopup();
   $.ajax({
      type: "POST",
      url: "../php/calculateDestination.php",
      dataType: "json",
         data: { 
            'latitudeDestination': latDest,
            'longitudeDestination': lngDest,
            'radius' : document.getElementById("radiusInput").value,
            'time' : simTime
         },
         success: function(destinations) {
            // TODO perform simulation for time given
            console.log(destinations); //testing
            if(markerCounter != 0) {
               for(let markerToRemove of destMarker) {
                  mymap.removeLayer(markerToRemove);
               }
            }
            markerCounter = 0;
            for (let point of destinations) {
               let latDest = point['centroid']['latitude'];
               let lngDest = point['centroid']['longitude'];
               let distance = point['distance'];
               destMarker[markerCounter] = L.marker([latDest,lngDest]);
               destMarker[markerCounter].addTo(mymap);
               destMarker[markerCounter].bindPopup("Distance: " + distance.toFixed(1) + " meters");
               markerCounter = markerCounter + 1;
            }

         },
         error: function () {
            alert('No available parking spaces were found!');
         }
   });
   return false;
});

