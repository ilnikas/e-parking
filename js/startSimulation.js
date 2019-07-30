var modal2 = document.getElementById("simulationModal");
var btn = document.getElementById("simulationButton");
var closeButton = document.getElementsByClassName("closeModal")[1]; //button that closes poppup


btn.onclick = function() {
    modal2.style.display = "block"; 
  }

closeButton.onclick = function() {
    modal2.style.display = "none";
}

function validate_simul()
{
  var inputTime = document.getElementById('settime').value;
  var inputTimeRGEX = /^([01]\d|2[0-3]):?([0-5]\d)$/;

  var emptyRGEX = /^$/;

  var inputTimeResult = inputTimeRGEX.test(inputTime);
  var emptySet1 = emptyRGEX.test(inputTime);

  var afterTime = document.getElementById('aftertime').value;
  var afterTimeRGEX = /^\d+$/;
  var afterTimeResult = afterTimeRGEX.test(afterTime);
  var emptySet2 = emptyRGEX.test(afterTime);
  if(afterTimeResult == true){
  	if (afterTime >= 1440){
  	afterTimeResult = false;}
  }

  if( inputTimeResult ? !afterTimeResult : afterTimeResult ) { // inputTimeResult XOR afterTimeResult, only one of the 2 fields must be filled
  if( inputTimeResult == true && emptySet2 == true){
  	//send exact time to backend and call php script
	}
  else if ( afterTimeResult == true && emptySet1 == true ) {
	//send minutes of simulations to backend and call php script
	}
  }else {alert("please give correct simulation input: either exact time or minutes");}
}

//TODO Start simulation after validating data
