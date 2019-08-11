function simulate(timeToRun) {
    $.ajax({
        type: "POST",
        url: "../php/adminSimulation.php",
        dataType: "json",
        data: {
            'timeToRun': timeToRun
        },
        success: function (data) {
           console.log(data);
           console.log(polygonData);

           for (let i=0; i<data.length; i++) {
                if(data[i]["demand"] < 0.8) {
                    console.log("trol");
                    initialMapLayer.getLayer(i).setStyle({color: "#000000"});
                }
          }
        },
        error: function () {
         alert('Error');
        }
    });
}
