<!DOCTYPE html>
<html>
<head>
	<title>JD Weather Station</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
		window.onload = function() {
			<?php
				$json_string = file_get_contents("http://api.wunderground.com/api/26a5ba3debf9e70e/geolookup/conditions/q/VT/Randolph.json");
				$json_string_2 = file_get_contents("http://api.wunderground.com/api/26a5ba3debf9e70e/geolookup/astronomy/q/VT/Randolph.json");
				$parsed_json = json_decode($json_string);
				$parsed_json_2 = json_decode($json_string_2);
				$temp = $parsed_json->{'current_observation'}->{'temp_f'};
				$pressure = $parsed_json->{'current_observation'}->{'pressure_in'};
				$humidity = $parsed_json->{'current_observation'}->{'relative_humidity'};
				$wind_mph = $parsed_json->{'current_observation'}->{'wind_mph'};
				$wind_dir = $parsed_json->{'current_observation'}->{'wind_dir'};
				$precip_today_in = $parsed_json->{'current_observation'}->{'precip_today_in'};
				$sunrise_h = $parsed_json_2->{'sun_phase'}->{'sunrise'}->{'hour'};
				$sunrise_m = $parsed_json_2->{'sun_phase'}->{'sunrise'}->{'minute'};
				$sunset_h = $parsed_json_2->{'sun_phase'}->{'sunset'}->{'hour'};
				$sunset_m = $parsed_json_2->{'sun_phase'}->{'sunset'}->{'minute'};	
			?>
		}
	</script>
	<script>
		$(function() {
			$('#dropdown').change(function(){
				$('.graph').hide();
				$('#' + $(this).val()).show();
			});
		});
	</script>
	<script>
		var myValues = localStorage.getItem("storageName");
		var myValues2 = localStorage.getItem("storageName2");
		var myValues3 = localStorage.getItem("storageName3");
		if(myValues == "temp_disconnected" && myValues2 == "press_disconnected" && myValues3 == "wind_disconnected") {
			window.onload = function() {
				document.getElementById("press").innerHTML = "<?php echo $pressure . " in"?>";
				document.getElementById("humid").innerHTML = "<?php echo $humidity?>";
				document.getElementById("windMPH").innerHTML = "<?php echo $wind_mph?>";
				document.getElementById("windDir").innerHTML = "<?php echo $wind_dir?>";
				document.getElementById("largeBold3").innerHTML = "<?php echo $temp . " °F"?>";
				document.getElementById("largeBold4a").innerHTML = "";
				document.getElementById("largeBold4b").innerHTML = "";
				document.getElementById("disclaimer").innerHTML = "*All sensors disconnected, now using Wunderground API data";
			}
		} else if(myValues == "temp_connected" && myValues2 == "press_disconnected" && myValues3 == "wind_disconnected") {
			window.onload = function() {
				document.getElementById("press").innerHTML = "<?php echo $pressure . " in"?>";
				document.getElementById("windMPH").innerHTML = "<?php echo $wind_mph?>";
				document.getElementById("windDir").innerHTML = "<?php echo $wind_dir?>";
				document.getElementById("disclaimer").innerHTML = "*Pressure & wind sensors disconnected, now using Wunderground API data";
			}
		} else if(myValues == "temp_connected" && myValues2 == "press_connected" && myValues3 == "wind_disconnected") {
			window.onload = function() {
				document.getElementById("windMPH").innerHTML = "<?php echo $wind_mph?>";
				document.getElementById("windDir").innerHTML = "<?php echo $wind_dir?>";
				document.getElementById("disclaimer").innerHTML = "*Wind sensors disconnected, now using Wunderground API data";
			}
		} else if(myValues == "temp_disconnected" && myValues2 == "press_disconnected" && myValues3 == "wind_connected") {
			window.onload = function() {
				document.getElementById("humid").innerHTML = "<?php echo $humidity?>";
				document.getElementById("press").innerHTML = "<?php echo $pressure . " in"?>";
				document.getElementById("largeBold3").innerHTML = "<?php echo $temp . " °F"?>";
				document.getElementById("largeBold4a").innerHTML = "";
				document.getElementById("largeBold4b").innerHTML = "";
				document.getElementById("disclaimer").innerHTML = "*Temperature, humidity & pressure sensors disconnected, now using Wunderground API data";
			}
		} else if(myValues == "temp_disconnected" && myValues2 == "press_connected" && myValues3 == "wind_connected") {
			window.onload = function() {
				document.getElementById("humid").innerHTML = "<?php echo $humidity?>";
				document.getElementById("largeBold3").innerHTML = "<?php echo $temp . " °F"?>";
				document.getElementById("largeBold4a").innerHTML = "";
				document.getElementById("largeBold4b").innerHTML = "";
				document.getElementById("disclaimer").innerHTML = "*Temperature & humidity sensor disconnected, now using Wunderground API data";
			}
		} else if(myValues == "temp_connected" && myValues2 == "press_disconnected" && myValues3 == "wind_connected") {
			window.onload = function() {
				document.getElementById("press").innerHTML = "<?php echo $pressure . " in"?>";
				document.getElementById("disclaimer").innerHTML = "*Pressure sensor disconnected, now using Wunderground API data";
			}
		} else if(myValues == "temp_disconnected" && myValues2 == "press_connected" && myValues3 == "wind_disconnected") {
			window.onload = function() {
				document.getElementById("humid").innerHTML = "<?php echo $humidity?>";
				document.getElementById("windMPH").innerHTML = "<?php echo $wind_mph?>";
				document.getElementById("windDir").innerHTML = "<?php echo $wind_dir?>";
				document.getElementById("largeBold3").innerHTML = "<?php echo $temp . " °F"?>";
				document.getElementById("largeBold4a").innerHTML = "";
				document.getElementById("largeBold4b").innerHTML = "";
				document.getElementById("disclaimer").innerHTML = "*Temperature, humidity & wind sensors disconnected, now using Wunderground API data";
			}
		}
	</script>
</head>
<body>
	<div id="content">
		<div id="info">
			<div id="largeBold1">JD Weather Station</div>
			<span id="smallFont1">Randolph, VT</span>
		</div>
		<div id="sidebar">
			Pressure:
			<span id="press">
			<?php
			error_reporting(0);
				
			$servername = "localhost";
			$username = "root";
			$password = "toor";
			$dbname = "raspberry";

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			$sql = "SELECT pressure FROM bmp180 order by date desc limit 1";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo (round($row["pressure"] /3386.38816, 2)). " in";
				}
			} else {
				echo "ERROR";
			}
			?></span><br>
			<br>
			<br>
			Humidity:
			<span id="humid">
			<?php
			$sql = "SELECT hum FROM dht11 order by time desc limit 1";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo $row["hum"]. "%";
				}
			} else {
				echo "ERROR";
			}
			?></span><br>
			<br>
			<br>
			Wind Speed:
			<span id="windMPH">
			<?php
				echo "${wind_mph} mph";
			?></span><br>
			<br>
			<br>
			Wind Direction: 
			<span id="windDir">
			<?php
				echo "${wind_dir}";
			?></span><br>
			<br>
			<br>
			Rainfall: 
			<?php
				echo "${precip_today_in} in";
			?><br>
			<br>
			<br>
			Sunrise:
			<?php
				echo "${sunrise_h}".":"."${sunrise_m}"." "."AM";
			?>
			<br>
			<br>
			<br>
			Sunset:
			<?php
				$format = "${sunset_h}".":"."${sunset_m}";
				echo date('h:i', strtotime($format))." "."PM";
			?>
		</div>
		<div id="temperature">
			<span id="largeBold2">Current Temperature:</span>
			<div id="largeBold3">
				<?php
				$sql = "SELECT temp FROM dht11 order by time desc limit 1";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo (($row["temp"]*1.8) + 32). " °F";
					}
				} else {
					echo "ERROR";
				}
				?>
			</div>
			<br>
			<span id="largeBold4a">High:
				<?php
				$sql = "SELECT temp FROM dht11 order by temp desc limit 1";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo (($row["temp"] * 1.8) + 32). " °F";
					}
				} else {
					echo "ERROR";
				}
				?>
			</span>
			<span id="largeBold4b">Low:
				<?php
				$sql = "SELECT temp FROM dht11 order by temp asc limit 1";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo (($row["temp"] * 1.8) + 32). " °F";
					}
				} else {
					echo "ERROR";
				}
				?>
			</span><br>
			<br>
			<br>
			Last updated on
			<?php
			$sql = "SELECT time FROM dht11 order by time desc limit 1";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo date( "l", strtotime($row["time"])) . " at " . date( "h:i", strtotime($row["time"])) . " " . date( "A", strtotime($row["time"]));
				}
			} else {
				echo "ERROR";
			}
			$conn->close();
			?>
		</div>

<span id="configButtonPosition"><a href="conf_login.html"><button id="configButtonSizeColor">Configure</button></a></span>
<span id="disclaimer"> </span>
		<div id="select">
			<select id="dropdown" name="graph">
				<option value="" disable selected>-- Select a Graph --</option>
				<option value="temp">Temperature</option>
				<option value="temp24">Temperature - 24 hours</option>
				<option value="temp48">Temperature - 48 hours</option>
				<option value="pressure">Pressure</option>
				<option value="pressure24">Pressure - 24 hours</option>
				<option value="pressure48">Pressure - 48 hours</option>
				<option value="windSpeed">Wind Speed</option>
				<option value="windSpeed24">Wind Speed - 24 hours</option>
				<option value="windSpeed48">Wind Speed - 48 hours</option>
			</select>
		</div>
		<img id="temp" class="graph" src="temperature.php" alt="can't load graph">
		<img id="temp24" class="graph" src="temperature24.php" alt="can't load graph">
		<img id="temp48" class="graph" src="temperature48.php" alt="can't load graph">
		<img id="pressure" class="graph" src="pressure.php" alt="can't load graph" style="display:none">
		<img id="pressure24" class="graph" src="pressure24.php" alt="can't load graph" style="display:none">
		<img id="pressure48" class="graph" src="pressure48.php" alt="can't load graph" style="display:none">
		<img id="windSpeed" class="graph" src="windSpeed.php" alt="can't load graph" style="display:none">
		<img id="windSpeed24" class="graph" src="windSpeed24.php" alt="can't load graph" style="display:none">
		<img id="windSpeed48" class="graph" src="windSpeed48.php" alt="can't load graph" style="display:none">
	</div>

</body>
</html>