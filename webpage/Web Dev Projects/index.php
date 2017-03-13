<!DOCTYPE html>
<html>
<head>
	<title>JD Weather Station</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
	<div id="content">
		<?php
			$json_string = file_get_contents("http://api.wunderground.com/api/26a5ba3debf9e70e/geolookup/conditions/q/VT/Randolph.json");
			$parsed_json = json_decode($json_string);
			$location = $parsed_json->{'location'}->{'city'};
			$wind_mph = $parsed_json->{'current_observation'}->{'wind_mph'};
			$wind_dir = $parsed_json->{'current_observation'}->{'wind_dir'};
			$precip_today_in = $parsed_json->{'current_observation'}->{'precip_today_in'};
		?>
		<div id="info">
			<div id="largeBold1">[insert name]'s Weather Station</div>
			<span id="smallFont1">Randolph, VT</span>
		</div>
		<div id="sidebar">
			Pressure: 
			<?php
			error_reporting(0);
				
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "raspberry";

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			$sql = "SELECT pressure FROM sensor_data order by date_time desc limit 1";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo $row["pressure"]. " in";
				}
			} else {
				echo "ERROR";
			}
			?><br>
			<br>
			<br>
			Humidity: 
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
			?><br>
			<br>
			<br>
			Wind Speed: 
			<?php
				echo "${wind_mph} mph";
			?><br>
			<br>
			<br>
			Wind Direction: 
			<?php
				echo "${wind_dir}";
			?><br>
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
				//Randolph, VT
				$lat = 43.92474459999999;    // North
				$long = -72.66569479999998;    // East
				$zenith=90.4;
		
				echo date("h:i", date_sunrise(time(), SUNFUNCS_RET_TIMESTAMP, $lat, $long, $zenith) - 60 * 60 * 6) . " " .
				date("A", date_sunrise(time(), SUNFUNCS_RET_TIMESTAMP, $lat, $long, $zenith) - 60 * 60 * 6);
			?>
			<br>
			<br>
			<br>
			Sunset:
			<?php
				//Randolph, VT
				$lat = 43.92474459999999;    // North
				$long = -72.66569479999998;    // East
				$zenith=90.5;
		
				echo date("h:i", date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, $lat, $long, $zenith) - 60 * 60 * 6) . " " .
				date("A", date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, $lat, $long, $zenith) - 60 * 60 * 6);
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
						echo (($row["temp"]*1.8) + 32). " °F";
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
						echo (($row["temp"]*1.8) + 32). " °F";
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
		<img id="graph" src="simpleplot.php" alt="can't load graph">
		</div>
	</div>
</body>
</html>