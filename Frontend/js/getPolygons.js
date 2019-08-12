document.addEventListener("load",fetchCoordinates()); //when admin page loads
//there is also call to the fetchCoordinates() function after file gets uploaded and parsed --see file uploadKmlFile.js for the call

var initialMapLayer; //STORING GEOJSON LAYER CREATED FROM FEATURE COLLECTION OBJECT RETURNED FROM SERVER

function fetchCoordinates() {
    $.ajax({
        type: "POST",
        url: "../php/sendCoordinates.php",
        dataType: "json", 
        success: function (polygonCoordinates) {
            console.log(polygonCoordinates); //Testing server response
            var defaultStyle = {
                 "color": "gray",
                 "fillColor": "gray",
                 "weight": 6,
                 "opacity": 0.5
            };

            initialMapLayer = L.geoJSON(polygonCoordinates, {
               style: defaultStyle,
               onEachFeature: function(feature, layer) {
                    layer._leaflet_id = feature["properties"]["id"];  //LAYER ID'S COORRELATE WITH POLYGON ID'S
                    //TODO BIND POPUP FOR EACH FEATURE
                }
            });
            initialMapLayer.addTo(mymap);
        }
    });
}