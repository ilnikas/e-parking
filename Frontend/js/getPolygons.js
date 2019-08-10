document.addEventListener("load",fetchCoordinates()); //when admin page loads
//there is also call to the fetchCoordinates() function after file gets uploaded and parsed --see file uploadKmlFile.js for the call
function fetchCoordinates() {
    $.ajax({
        type: "POST",
        url: "../php/sendCoordinates.php",
        dataType: "json", //GETTING DATA AS TEXT BECAUSE NO json_encode FUNCTION WAS USED...DATA ARE IN JSON FORMAT
        success: function (polygonCoordinates) {
            //TODO add GeoJSON data to Leaflet
            console.log(polygonCoordinates); //Testing server response

            //var myLayer = L.geoJSON().addTo(mymap);
            //myLayer.addData(polygonCoordinates);
            var myStyle = {
                 "color": "838383",
                 "weight": 6,
                 "opacity": 0.5
            };

                L.geoJSON(polygonCoordinates, {
                   style: myStyle
                }).addTo(mymap);
        }
    });
}
