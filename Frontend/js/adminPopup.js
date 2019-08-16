var polygonID;

function initializePopup(layer) {

var curveNum = layer.feature.properties.demandCurve;
var curveText = "";

if (curveNum == 0) {
	curveText = "center";}
else if (curveNum == 1) {
	curveText = "residential";}
else { curveText = "stable";}


var popupContent = "<div class=popup> Polygon ID: " +layer.feature.properties.id + "<div class=popup> <br><br> Total parking spaces: " +layer.feature.properties.totalParkingSpaces + "<br><input type='number' id='num_spaces'><br><br><button type='button' onclick='update_spaces(num_spaces.value, polygonID);'>update parking spaces</button>" + "<div class=popup> <br><br> Demand curve: " +curveText + "<br><select id='dem_curve' form='dem_curve_form'><option value='0'>city center</option><option value='1'>residential</option><option value='2'>stable</option></select><br><br><button type='button' onclick='update_curve(dem_curve.value, polygonID);'>update demand curve</button>";


layer.bindPopup(popupContent);

}

function update_spaces(numSpaces, polid) {

if( (numSpaces>=0) && (numSpaces<=4999) ) {

alert("num of new spaces of polygon " +polid + " will be: " +numSpaces);


$.ajax({
 method: "POST",
 url: "../php/updateSpaces.php",
 data: { numSpaces: numSpaces, polid: polid },
 success: function() {
            location.reload(false); //REFRESHING PAGE WHILE MAINTAINING CACHED DATA
        },
        error: function() {
            alert("error");
        }
})

}

else { alert("parking spaces input exceeds limits (0 to 4999)"); }

}

function update_curve(demCurve, polid) {
alert("num of new curve will be: " +demCurve);

$.ajax({
 method: "POST",
 url: "../php/updateCurve.php",
 data: { demCurve: demCurve, polid: polid },
 success: function() {
            location.reload(false); //REFRESHING PAGE WHILE MAINTAINING CACHED DATA
        },
        error: function() {
            alert("error");
        }
})

}

mymap.on('popupopen', function(e) { polygonID = e.popup._source.feature.properties.id;});

