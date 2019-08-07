var modal = document.getElementById("deleteDataModal"); //poppup
var btn = document.getElementById("deleteDataButton"); //button to trigger the poppup
var closeButton = document.getElementsByClassName("closeModal")[0]; //button that closes poppup
var confirmButton = document.getElementById("confirmDelete");
var deleteButton = document.getElementById("cancelDelete");


btn.onclick = function() {
    modal.style.display = "block";
    document.getElementById("infoUpload").style = "display: none;" //No need to display message for failed upload
  }

closeButton.onclick = function() {
    modal.style.display = "none";
}


confirmButton.onclick = function() {
    //TODO delete data
    modal.style.display = "none";
}

deleteButton.onclick = function() {
    modal.style.display = "none";
}