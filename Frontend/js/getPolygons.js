document.addEventListener("load",fetchCoordinates()); //when admin page loads
//there is also call to the fetchCoordinates() function after file gets uploaded and parsed --see file uploadKmlFile.js for the call
var polygonData;
var initialMapLayer;
function fetchCoordinates() {
    $.ajax({
        type: "POST",
        url: "../php/sendCoordinates.php",
        dataType: "json", //GETTING DATA AS TEXT BECAUSE NO json_encode FUNCTION WAS USED...DATA ARE IN JSON FORMAT
        async: "false", //SO RESPONSE CAN BE STORED
        success: function (polygonCoordinates) {
            //TODO add GeoJSON data to Leaflet
            console.log(polygonCoordinates); //Testing server response
            polygonData = polygonCoordinates;
            //var myLayer = L.geoJSON().addTo(mymap);
            //myLayer.addData(polygonCoordinates);
            var myStyle = {
                 "color": "838383",
                 "weight": 6,
                 "opacity": 0.5
            };



            var id = 1;

            for(let polygon of  polygonCoordinates["features"]) { //ID IS AUTO INCREMENT IN DATABASE SO THIS FOR LOOP LETS THE CLIENT KNOWS WHAT IS THE ID FOR EACH POLYGON
                polygon["id"] = id;
                id++;
            }
            initialMapLayer = L.geoJSON(polygonCoordinates, {
               style: myStyle
            });
            //ASSIGNING ID'S TO LAYERS --SAME AS FEATURES
            initialMapLayer = L.geoJson(polygonCoordinates,{
                  onEachFeature: function(feature, layer) {
                          layer._leaflet_id = feature.id;
            }});
            initialMapLayer.addTo(mymap);
        }
    });
}