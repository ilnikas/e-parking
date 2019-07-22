function toggleMenu(){
    var dropdownContent = document.getElementById("dropdown-content");
    if (dropdownContent.style.visibility == "visible") {
        dropdownContent.style.visibility = "hidden";
        dropdownContent.style.opacity = "0";
    } else {
        dropdownContent.style.visibility = "visible";
        dropdownContent.style.opacity = "0.8";
    }
}

function hideMenu(){
    var dropdownContent = document.getElementById("dropdown-content");
    dropdownContent.style.visibility = "hidden";
    dropdownContent.style.opacity = "0";
}