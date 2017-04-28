<?php
	error_reporting(0);
	
	/* Attempt MySQL server connection. Assuming you are running MySQL
	server with default setting (user 'root' with no password) */
	$link = mysqli_connect("localhost", "root", "toor", "raspberry");
 
	// Check connection
	if($link === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
 
	// Attempt select query execution
	$sql = "SELECT * FROM wind order by date desc limit 20";
	$data = array();
	if($result = mysqli_query($link, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				$data[] = $row['windspeed'];
				$time[] = $row['date'];
			}
			// Free result set
			mysqli_free_result($result);
		} else {
			echo "ERROR";
		}
	}
	
	//Include the code
	require_once 'phplot.php';
	
	//Define the object
	$plot = new PHPlot(1000, 225);
	$plot->SetImageBorderType('plain');

	//Define some data
	$temperature_data = array(
		array(date('h:i A', strtotime($time[0])),$data[0]),
		array(date('h:i A', strtotime($time[1])),$data[1]),
		array(date('h:i A', strtotime($time[2])),$data[2]),
		array(date('h:i A', strtotime($time[3])),$data[3]),
		array(date('h:i A', strtotime($time[4])),$data[4]),
		array(date('h:i A', strtotime($time[5])),$data[5]),
		array(date('h:i A', strtotime($time[6])),$data[6]),
		array(date('h:i A', strtotime($time[7])),$data[7]),
		array(date('h:i A', strtotime($time[8])),$data[8]),
		array(date('h:i A', strtotime($time[9])),$data[9]),
		array(date('h:i A', strtotime($time[10])),$data[10]),
		array(date('h:i A', strtotime($time[11])),$data[11]),
		array(date('h:i A', strtotime($time[12])),$data[12]),
		array(date('h:i A', strtotime($time[13])),$data[13]),
		array(date('h:i A', strtotime($time[14])),$data[14]),
		array(date('h:i A', strtotime($time[15])),$data[15]),
		array(date('h:i A', strtotime($time[16])),$data[16]),
		array(date('h:i A', strtotime($time[17])),$data[17]),
		array(date('h:i A', strtotime($time[18])),$data[18]),
		array(date('h:i A', strtotime($time[19])),$data[19]),
	);
	$plot->SetDataValues($temperature_data);
	
	$plot->SetYTickIncrement(5);
	
	//Set titles
	$plot->SetTitle("Wind Speed Readings");
	$plot->SetYTitle("MPH");
	$plot->SetXTitle('Time of Reading');
	
	//Select a plot area and force ticks to nice values:
	$plot->SetPlotAreaWorld(NULL, 0, NULL, 30);
	
	//Turn off X axis ticks and labels because they get in the way:
	$plot->SetXTickLabelPos('none');
	$plot->SetXTickPos('none');

	
	$plot->SetMarginsPixels(60, 40, 50, 50);
	
	$plot->SetDataColors(array('green'));
	//$plot->SetLegend(array('Wind Speed'));
	$plot->SetLegendPosition(0, 0, 'image', 0, 0, 25, 160);

	//Draw it
	$plot->DrawGraph();
	
	// Close connection
	mysqli_close($link);
?>