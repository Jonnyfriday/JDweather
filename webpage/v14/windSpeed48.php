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
	$sql = "SELECT * FROM wind order by date desc limit 320";
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
		array(date('h:i A', strtotime($time[144])),$data[144]),
		array(date('h:i A', strtotime($time[288])),$data[288]),
		array(date('h:i A', strtotime($time[360])),$data[360]),
		array(date('h:i A', strtotime($time[432])),$data[432]),
	);
	$plot->SetDataValues($temperature_data);
	
	$plot->SetYTickIncrement(5);
	
	//Set titles
	$plot->SetTitle("Wind Speed Readings - 48 Hours");
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