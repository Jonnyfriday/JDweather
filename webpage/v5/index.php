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
			$json_string_2 = file_get_contents("http://api.wunderground.com/api/26a5ba3debf9e70e/geolookup/astronomy/q/VT/Randolph.json");
			$parsed_json = json_decode($json_string);
			$parsed_json_2 = json_decode($json_string_2);
			$location = $parsed_json->{'location'}->{'city'};
			$wind_mph = $parsed_json->{'current_observation'}->{'wind_mph'};
			$wind_dir = $parsed_json->{'current_observation'}->{'wind_dir'};
			$precip_today_in = $parsed_json->{'current_observation'}->{'precip_today_in'};
			$sunrise_h = $parsed_json_2->{'sun_phase'}->{'sunrise'}->{'hour'};
			$sunrise_m = $parsed_json_2->{'sun_phase'}->{'sunrise'}->{'minute'};
			$sunset_h = $parsed_json_2->{'sun_phase'}->{'sunset'}->{'hour'};
			$sunset_m = $parsed_json_2->{'sun_phase'}->{'sunset'}->{'minute'};
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

			$sql = "SELECT pressure FROM bmp180 order by date desc limit 1";
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
		<img id="graph" src="simpleplot.php" alt="can't load graph">
		</div>
	</div>
</body>
</html>