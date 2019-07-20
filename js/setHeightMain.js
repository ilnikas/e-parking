function setHeightMain() {
    var myHeight = window.innerHeight - 50; //50 pixels is the fixed height of the header
    document.getElementById("main").style.height = myHeight + "px"; //Header and main part of page takes the whole screen
}