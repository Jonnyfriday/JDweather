<?php
// Get index to accept data from database
// API?
// Graphs?
?>


<html>
<head>
	<title>JD Weather Station</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
	<div id="content">
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
			$dbname = "weather_data";

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
			$sql = "SELECT humidity FROM sensor_data order by date_time desc limit 1";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo $row["humidity"]. "%";
				}
			} else {
				echo "ERROR";
			}
			?><br>
			<br>
			<br>
			Wind Speed: 
			<?php
			$sql = "SELECT wind_speed FROM sensor_data order by date_time desc limit 1";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo $row["wind_speed"]. " mph";
				}
			} else {
				echo "ERROR";
			}
			?><br>
			<br>
			<br>
			Wind Direction: 
			<?php
			$sql = "SELECT wind_direction FROM sensor_data order by date_time desc limit 1";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo $row["wind_direction"];
				}
			} else {
				echo "ERROR";
			}
			?><br>
			<br>
			<br>
			Rainfall: 
			<?php
			$sql = "SELECT rainfall FROM sensor_data order by date_time desc limit 1";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo $row["rainfall"]. " in";
				}
			} else {
				echo "ERROR";
			}
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
				$zenith=90.4;
		
				echo date("h:i", date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, $lat, $long, $zenith) - 60 * 60 * 6) . " " .
				date("A", date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, $lat, $long, $zenith) - 60 * 60 * 6);
			?>
		</div>
		<div id="temperature">
			<span id="largeBold2">Current Temperature:</span>
			<div id="largeBold3">
				<?php
				$sql = "SELECT temperature FROM sensor_data order by date_time desc limit 1";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo $row["temperature"]. " °F";
					}
				} else {
					echo "ERROR";
				}
				?>
			</div>
			<br>
			<span id="largeBold4a">High:
				<?php
				$sql = "SELECT high FROM sensor_data order by date_time desc limit 1";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo $row["high"]. " °F";
					}
				} else {
					echo "ERROR";
				}
				?>
			</span>
			<span id="largeBold4b">Low:
				<?php
				$sql = "SELECT low FROM sensor_data order by date_time desc limit 1";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo $row["low"]. " °F";
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
			$sql = "SELECT date_time FROM sensor_data order by date_time desc limit 1";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo date( "l", strtotime($row["date_time"])) . " at " . date( "h:m", strtotime($row["date_time"])) . " " . date( "A", strtotime($row["date_time"]));
				}
			} else {
				echo "ERROR";
			}
			$conn->close();
			?>
		</div>
		<img id="graph" src="graph.png" alt="image error">
		</div>
	</div>
</body>
</html>