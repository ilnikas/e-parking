document.addEventListener("load",fetchCoordinates()); //when admin page loads
//there is also call to the fetchCoordinates() function after file gets uploaded and parsed --see file uploadKmlFile.js for the call

var polygonData; //RESPONSE FROM SERVER --STORED HERE TO BE AVAILABLE GLOBALLY
var initialMapLayer; //STORING GEOJSON LAYER CREATED FROM FEATURE COLLECTION OBJECT RETURNED FROM SERVER

function fetchCoordinates() {
    $.ajax({
        type: "POST",
        url: "../php/sendCoordinates.php",
        dataType: "json", 
        async: "false", //SO RESPONSE CAN BE STORED
        success: function (polygonCoordinates) {
            console.log(polygonCoordinates); //Testing server response
            polygonData = polygonCoordinates;
            var defaultStyle = {
                 "color": "gray",
                 "weight": 6,
                 "opacity": 0.5
            };

            initialMapLayer = L.geoJSON(polygonCoordinates, {
               style: defaultStyle
            });
            initialMapLayer.addTo(mymap);
        }
    });
}