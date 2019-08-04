const realButton = document.getElementById("realButton"); //input button that is hidden
const chooseFileButton = document.getElementById("chooseFileButton"); //custom button that appears on user
const infoChooseFile = document.getElementById("infoChooseFile"); //text that will appear below chooseFile button

chooseFileButton.addEventListener("click", function() {
    realButton.click();
});

realButton.addEventListener("change", function() {
    if (realButton.value) { //If there is a file that was chosen
        let filename = realButton.value.replace(/^.*[\\\/]/, ''); //extracting filename from path
        infoChooseFile.innerHTML = filename; //printing filename to infochooseFile element
    } else {
        infoChooseFile.innerHTML = "Δεν έχει επιλεγεί αρχείο"; //Display default text
    }
});