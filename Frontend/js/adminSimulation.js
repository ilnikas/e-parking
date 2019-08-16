var exactTime;
var exactHours;
var exactMins;
var absoluteTime;
var currSimulationTime = ""; //to be returned
var offsetTime;
var today = new Date();

var modal2 = document.getElementById("simulationModal");
var btn1 = document.getElementById("simulationButtonL");
var btn2 = document.getElementById("simulationButtonM");
var btn3 = document.getElementById("simulationButtonR");
var closeButton = document.getElementsByClassName("closeModal")[1]; //button that closes poppup


btn1.onclick = function() {
	absoluteTime = Number(absoluteTime) - Number(offsetTime);
	if(absoluteTime < 0){ absoluteTime = absoluteTime + Number(1440);}
	currSimulationTime = absToCurr(absoluteTime);
	//alert("curr simul time is: " +currSimulationTime);
	currSimulationTime = "" + currSimulationTime;
	simulate(currSimulationTime);
  }

btn2.onclick = function() {
	modal2.style.display = "block";
  }

btn3.onclick = function() {
    absoluteTime = Number(absoluteTime) + Number(offsetTime);
	if(absoluteTime > 1439){ absoluteTime = absoluteTime - Number(1440);}
	currSimulationTime = absToCurr(absoluteTime);
	//alert("curr simul time is: " +currSimulationTime);
    currSimulationTime = "" +currSimulationTime;
	simulate(currSimulationTime);
  }

closeButton.onclick = function() {
    modal2.style.display = "none";
}

exactHours = today.getHours();
exactMins = today.getMinutes();

function absToCurr(absTime){
	var currSimTime;
	var exHours = ~~(absTime / 60);
	var exMins = absTime % 60;
		if( (exHours < 10) && (exMins < 10) ){
		currSimTime = "0" + exHours + "0" + exMins;}
		else if( exHours < 10 ) {currSimTime = "0" + exHours + exMins;}
		else if( exMins < 10 ) {currSimTime = "" + exHours + "0" + exMins;}
		else {currSimTime = "" + exHours + exMins;}
	return currSimTime;
}

function setValues(){
document.getElementById("simulationButtonL").innerHTML = "Simulation before " +offsetTime +" minutes";
document.getElementById("simulationButtonR").innerHTML = "Simulation after " +offsetTime +" minutes";
}

function validate_simul()
{
  var inputTime = document.getElementById('settime').value;
  var inputTimeRGEX = /^([01]\d|2[0-3])([:.])([0-5]\d)$/;

  var emptyRGEX = /^$/;

  var inputTimeResult = inputTimeRGEX.test(inputTime);
  var emptySet1 = emptyRGEX.test(inputTime);

  var afterTime = document.getElementById('aftertime').value;
  var afterTimeRGEX = /^\d+$/;
  var afterTimeResult = afterTimeRGEX.test(afterTime);
  var emptySet2 = emptyRGEX.test(afterTime);

  var leftButton = document.getElementById("simulationButtonL");
  var rightButton = document.getElementById("simulationButtonR");
  if(afterTimeResult == true){
  	if ( afterTime <= 0 || afterTime >= 181 ){
  	afterTimeResult = false;}
  }

  if( emptySet1 == true && emptySet2 == true ) {
		exactHours = today.getHours();
		exactMins = today.getMinutes();
		offsetTime = 15;
		setValues();
		leftButton.style = "display: block;";
		rightButton.style = "display: block;";
		absoluteTime = exactHours * 60 + Number(exactMins);
		currSimulationTime = absToCurr(absoluteTime);
		//alert("curr simul time is: " +currSimulationTime);
		modal2.style.display = "none";
        currSimulationTime = "" +currSimulationTime;
		simulate(currSimulationTime);
        return false;
		}

  if( (afterTimeResult == false && emptySet2 == false) && (emptySet1 == true || inputTimeResult ==true) ){
		alert("Please make sure your input in second field is correct");
		return false;}

  if( emptySet1 == true && afterTimeResult == true ){
		today = new Date();
		exactHours = today.getHours();
		exactMins = today.getMinutes();
		offsetTime = afterTime;
		setValues();
		leftButton.style = "display: block;";
		rightButton.style = "display: block;";
		absoluteTime = exactHours * 60 + Number(exactMins);
		currSimulationTime = absToCurr(absoluteTime);
		//alert("curr simul time is: " +currSimulationTime);
		modal2.style.display = "none";
	    currSimulationTime = "" +currSimulationTime;
		simulate(currSimulationTime);
		return false;
		}

  if( inputTimeResult == false && (emptySet2 == true || afterTimeResult ==true) ){
		alert("Please make sure your input in the first field is correct");
		return false;}

  else if( inputTimeResult == true && emptySet2 == true ){
		exactTime = inputTime.split(/[:.]+/);
		exactHours = exactTime[0];
		exactMins = exactTime[1];
		offsetTime = 15;
		setValues();
		leftButton.style = "display: block;";
		rightButton.style = "display: block;";
		absoluteTime = exactHours * 60 + Number(exactMins);
		currSimulationTime = absToCurr(absoluteTime);
		//alert("curr simul time is: " +currSimulationTime);
		modal2.style.display = "none";
	    currSimulationTime = "" +currSimulationTime;
		simulate(currSimulationTime);
        return false;
		}

  else if( inputTimeResult == true && afterTimeResult == true ){
		exactTime = inputTime.split(/[:.]+/);
		exactHours = exactTime[0];
		exactMins = exactTime[1];
		offsetTime = afterTime;
		setValues();
		leftButton.style = "display: block;";
		rightButton.style = "display: block;";
		absoluteTime = exactHours * 60 + Number(exactMins);
		currSimulationTime = absToCurr(absoluteTime);
		//alert("curr simul time is: " +currSimulationTime);
		modal2.style.display = "none";
	    currSimulationTime = "" +currSimulationTime;
		simulate(currSimulationTime);
		return false;
		}

  else {
		alert("Please make sure your input in both fields is correct");
		return false;}
}

//________________________________________STARTING SIMULATION FOR SPECIFIED TIME____________________________________



