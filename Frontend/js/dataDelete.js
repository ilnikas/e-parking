$(document).on("click", "#confirmDelete", function(event){ //SIMPLE ON CLICK EVENT DOESN'T WORK BECAUSE BUTTON IS IN MODAL  --this handler works for elements that exist or will exist
    $.ajax({
        type: "POST",
        url: "../php/dataDelete.php",
        success: function() {
            location.reload(false); //REFRESHING PAGE WHILE MAINTAINING CACHED DATA
        },
        error: function() {
            alert("error");
        }
    });
});