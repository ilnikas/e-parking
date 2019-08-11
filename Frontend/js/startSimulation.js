var exactTime;
var exactHours;
var exactMins;
var absoluteTime;
var currSimulationTime; //to be returned
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
	alert("curr simul time is: " +currSimulationTime);
	//some AJAX to send "currSimulationTime" variable to server
  }

btn2.onclick = function() {
	modal2.style.display = "block";
  }

btn3.onclick = function() {
    absoluteTime = Number(absoluteTime) + Number(offsetTime);
	if(absoluteTime > 1439){ absoluteTime = absoluteTime - Number(1440);}
	currSimulationTime = absToCurr(absoluteTime);
	alert("curr simul time is: " +currSimulationTime);
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
document.getElementById("simulationButtonL").innerHTML = "Εξομοίωση για " +offsetTime +" λεπτά πριν";
document.getElementById("simulationButtonR").innerHTML = "Εξομοίωση για " +offsetTime +" λεπτά μετά";
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
		alert("curr simul time is: " +currSimulationTime);
		modal2.style.display = "none";
		return false;
		//some AJAX to send "currSimulationTime" variable to server
		}

  if( (afterTimeResult == false && emptySet2 == false) && (emptySet1 == true || inputTimeResult ==true) ){
		alert("parakalw dwste swsta ta lepta sto pedio #2");
		return false;}

  if( emptySet1 == true && afterTimeResult == true ){
		exactHours = today.getHours();
		exactMins = today.getMinutes();
		offsetTime = afterTime;
		setValues();
		leftButton.style = "display: block;";
		rightButton.style = "display: block;";
		absoluteTime = exactHours * 60 + Number(exactMins);
		currSimulationTime = absToCurr(absoluteTime);
		alert("curr simul time is: " +currSimulationTime);
		modal2.style.display = "none";
		return false;
		//some AJAX to send "currSimulationTime" variable to server
		}

  if( inputTimeResult == false && (emptySet2 == true || afterTimeResult ==true) ){
		alert("parakalw dwste tin wra se swsti morfi sto pedio #1");
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
		alert("curr simul time is: " +currSimulationTime);
		modal2.style.display = "none";
		return false;
		//some AJAX to send "currSimulationTime" variable to server
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
		alert("curr simul time is: " +currSimulationTime);
		modal2.style.display = "none";
		return false;
		//some AJAX to send "currSimulationTime" variable to server
		}

  else {
		alert("parakalw dwste tin wra se swsti morfi sta pedia #1 & #2");
		return false;}
}


//TODO Start simulation after validating data
