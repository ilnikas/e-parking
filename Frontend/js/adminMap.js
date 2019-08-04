//coordinates which the map will initially display  --Currently set to Patras,Greece
const myLong = 38.246208;   
const myLang = 21.735069;
const zoomBy = 14; //How much to zoom into the map initially 

var mymap = L.map('map',{ scrollWheelZoom : false }).setView([myLong, myLang], zoomBy); //Initializing map
const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors'; //copyright to open street maps

const tileUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
const tiles = L.tileLayer(tileUrl, { attribution }); //creating tiles for the map

tiles.addTo(mymap);
