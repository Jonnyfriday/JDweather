<!DOCTYPE html>
<html>
<head>
	<title>Configuration Page</title>
	<link rel="stylesheet" href="stylesheet_conf.css">
	<script>
		function myFunction() {
			var getInput = document.getElementById('tcon').value;
			localStorage.setItem("storageName",getInput);
		}
		function myFunction2() {
			var getInput = document.getElementById('tdis').value;
			localStorage.setItem("storageName",getInput);
		}
		function myFunction3() {
			var getInput = document.getElementById('pcon').value;
			localStorage.setItem("storageName2",getInput);
		}
		function myFunction4() {
			var getInput = document.getElementById('pdis').value;
			localStorage.setItem("storageName2",getInput);
		}
	</script>
</head>
<body>
	<div id="title">
		JD Weather Station Configuration Tool
	</div>
	
<form id="sensors" action="">
<br><br>
Temperature / Humidity
<br><br>
<button id="tcon" value="temp_connected" onclick="myFunction()">Add Sensor</button>
<button id="tdis" value="temp_disconnected" onclick="myFunction2()">Remove Sensor</button>
<br><br><br>
Pressure
<span id="padding">
<br><br>
<button id="pcon" value="press_connected" onclick="myFunction3()">Add Sensor</button>
<button id="pdis" value="press_disconnected" onclick="myFunction4()">Remove Sensor</button>
<br><br><br><br>
Wind Speed / Direction
<span id="padding">
<br><br>
<input type="submit" value="Add sensor">
<input type="submit" value="Remove sensor">
</span>
</form>
<a href="index.php">Home</a>
</body>
</html>