var modal2 = document.getElementById("simulationModal");
var btn = document.getElementById("simulationButton");
var closeButton = document.getElementsByClassName("closeModal")[1]; //button that closes poppup


btn.onclick = function() {
    modal2.style.display = "block"; 
  }

closeButton.onclick = function() {
    modal2.style.display = "none";
}

var exactTime;
var exactHours; //to be returned
var exactMins; //to be returned
var offsetTime; //to be returned


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
  if(afterTimeResult == true){
  	if (afterTime >= 1440){
  	afterTimeResult = false;}
  }

  if( emptySet1 == true && emptySet2 == true ) {
		alert("parakalw dwste input");
		return false;}

  if( emptySet1 == true && afterTimeResult == false ){
		alert("parakalw dwste swsta ta lepta sto pedio #2");
		return false;}

  if( emptySet1 == true && afterTimeResult == true ){
		offsetTime = afterTime;
		return;}

  if( inputTimeResult == false && emptySet2 == true ){
		alert("parakalw dwste tin wra se swsti morfi sto pedio #1");
		return false;}
  else if( inputTimeResult == true && emptySet2 == true ){
		exactTime = inputTime.split(/[:.]+/);
		exactHours = exactTime[0];
		exactMins = exactTime[1];
		return;}
  else{
		alert("parakalw symplirwste mono 1 apo ta 2 pedia");
		return false;}

}

//TODO Start simulation after validating data
