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
	
	//Include the code
	require_once 'phplot.php';
	
	//Define the object
	$plot = new PHPlot(1000, 145);

	//Define some data
	$temperature_data = array(
		array('3/4',40,50,30),
		array('3/5',13,25,7),
		array('3/6',15,21,12),
		array('3/7',31,37,26),
		array('3/8',22,29,19),
	);
	$plot->SetDataValues($temperature_data);
	
	$plot->SetYTickIncrement(10);
	
	//Turn off X axis ticks and labels because they get in the way:
	$plot->SetXTickLabelPos('none');
	$plot->SetXTickPos('none');

	
	$plot->SetMarginsPixels(140);
	
	$plot->SetDataColors(array('green', 'red', 'blue'));
	$plot->SetLegend(array('Temperature', 'High', 'Low'));
	$plot->SetLegendPosition(0, 0, 'image', 0, 0, 10, 30);

	//Draw it
	$plot->DrawGraph();
?>