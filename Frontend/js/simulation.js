function simulate(timeToRun) {
    $.ajax({
        type: "POST",
        url: "../php/adminSimulation.php",
        dataType: "json",
        data: {
            'timeToRun': timeToRun
        },
        success: function(demandData) {
			console.log(demandData);
			for(let polygonIndex=0; polygonIndex < demandData.length; polygonIndex++) { //INDEX OF TWO POLYGONS HAVE PERFECT CORRESPONDENCE SINCE BOTH RESULTS THAT ARE RETURNED TO CLIENT ARE SORTED BY POLYGON ID -- SO NO SEARCH IS REQUIRED
				if((demandData[polygonIndex]["demand"]) <= 0.59) {   				   
					//green
					initialMapLayer.getLayer(polygonIndex + 1).setStyle({ //+1 BECAUSE LAYER ID'S STARTS FROM 1 (SAME AS FEATURE ID'S)
						"color": "green",
						"fillColor": "green",
						"weight": 6,
						"opacity": 0.5
				   });
				} else if ((demandData[polygonIndex]["demand"]) <= 0.84) {
					//yellow
					initialMapLayer.getLayer(polygonIndex + 1).setStyle({ //+1 BECAUSE LAYER ID'S STARTS FROM 1 (SAME AS FEATURE ID'S)
						"color": "yellow",
						"fillColor": "yellow",
						"weight": 6,
						"opacity": 0.5
				   });
				} else {
					//red
					initialMapLayer.getLayer(polygonIndex + 1).setStyle({ //+1 BECAUSE LAYER ID'S STARTS FROM 1 (SAME AS FEATURE ID'S)
						"color": "red",
						"fillColor": "red",
						"weight": 6,
						"opacity": 0.5
				   });
				}
  			}
        },
        error: function () {
         alert('Error');
        }
    });
}