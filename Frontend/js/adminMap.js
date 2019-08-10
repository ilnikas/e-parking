//coordinates which the map will initially display  --Currently set to Thessaloniki,Greece
const myLong = 40.628689;  
const myLang = 22.956073;
const zoomBy = 13; //How much to zoom into the map initially 

var mymap = L.map('map',{ scrollWheelZoom : false }).setView([myLong, myLang], zoomBy); //Initializing map
const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors'; //copyright to open street maps

const tileUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
const tiles = L.tileLayer(tileUrl, { attribution }); //creating tiles for the map

tiles.addTo(mymap);
