<!DOCTYPE html>
<html>
<head>
	<title>Configuration Page</title>
	<link rel="stylesheet" href="stylesheet_conf.css">
</head>
<body>
	<div id="title">
		JD Weather Station Configuration Tool
	</div>
	<form id="sensors" action="">
		<select id="dropdown" name="sensor">
			<option value="" diable selected>-- Connected Sensors --</option>
			<option value="temperature">Temperature Sensor</option>
			<option value="humidity">Humidity Sensor</option>
			<option value="pressure">Pressure Sensor</option>
			<option value="windSpeed">Wind Speed Sensor</option>
			<option value="windDirection">Wind Direction Sensor</option>
		</select>
		<br><br>
		<input type="submit" value="Add sensor">
		<span id="padding"><input type="submit" value="Remove sensor"></span>
	</form>
	<form id="databases" action="">
		<select id="dropdown" name="database">
			<option value="" diable selected>-- Connected Database --</option>
			<option value="main">Main Database</option>
			<option value="backup">Backup Database</option>
		</select>
		<br><br>
		<input type="submit" value="Configure">
	</form>
	<form id="slider" action="">
		<input id="sliderLength" type="range" id="myRange" value="90">
		<br><br>
		<input type="submit" value="Set recording interval">
	</form>
</body>
</html>
