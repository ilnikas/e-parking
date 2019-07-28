var modal2 = document.getElementById("simulationModal");
var btn = document.getElementById("simulationButton");
var closeButton = document.getElementsByClassName("closeModal")[1]; //button that closes poppup


btn.onclick = function() {
    modal2.style.display = "block"; 
  }

closeButton.onclick = function() {
    modal2.style.display = "none";
}

//TODO Start simulation after validating data