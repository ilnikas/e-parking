function fetchCoordinates() {
    $.ajax({
        type: "POST",
        url: "../php/sendData.php",
        dataType: "json", 
        success: function (polygonCoordinates) {
            console.log(polygonCoordinates); //Testing server response
            var defaultStyle = {
                 "color": "gray",
                 "fillColor": "gray",
                 "weight": 6,
                 "opacity": 0.5
            };

            polygonsInfo = polygonCoordinates;
            initialMapLayer = L.geoJSON(polygonCoordinates, {
               style: defaultStyle,
               onEachFeature: function(feature, layer) {
                    layer._leaflet_id = feature["properties"]["id"];  //LAYER ID'S COORRELATE WITH POLYGON ID'S
                    //TODO BIND POPUP FOR EACH FEATURE
                }
            });
            initialMapLayer.addTo(mymap);

            //After drawing execute simulation for default (current) time (this is why already implemented fetchCoordinates() function wasn't used here)
            //Default time is current time
            let curr_time = new Date().toTimeString().substr(0,5);
            curr_time = curr_time.replace(":", "");
            alert("simTime" + curr_time);
            simulate(curr_time);
        }
    });
}

var initialMapLayer; //STORING GEOJSON LAYER CREATED FROM FEATURE COLLECTION OBJECT RETURNED FROM SERVER
var polygonsInfo; //STORING INFORMATION FOR POLYGONS GLOBALLY
document.addEventListener("load",fetchCoordinates()); //on load get coordinates and draw on map

document.getElementById("timeForm").onsubmit = function() {
    let userInputTime = document.getElementById("customTime").value;
    userInputTime =  userInputTime.replace(".", ""); //removing '.' if it exists to time will be in correct format for simulate() function
    userInputTime = userInputTime.replace(":", ""); //removing ':' if it exists so time will be in correct format for simulate() function
    simulate(userInputTime);
    return false; //so page won't refresh
};

