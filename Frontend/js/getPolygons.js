document.addEventListener("load",fetchCoordinates()); //when admin page loads
//there is also call to the fetchCoordinates() function after file gets uploaded and parsed --see file uploadKmlFile.js for the call 

function fetchCoordinates() {
    $.ajax({
        type: "POST",
        url: "../php/sendCoordinates.php",
        dataType: 'json',
        success: function (polygonCoordinates) {
            //TODO add GeoJSON data to Leaflet
        }
    });
}