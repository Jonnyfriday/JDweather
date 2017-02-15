<?php
 
session_start();
$username = "";
$pwd = "";

$username = $_POST["username"];
$password = $_POST["password"];

if ($username&&$password) {
	
$connect = mysql_connect("localhost", "root", "", "login") or die("Could not Connect to Host<br><br>"); 
mysql_select_db("login") or die("<br><br>Couldn't Access Database<br><br>");
}
else die("Cannot Complete Request, Please Try Again<br><br>");

$query = mysql_query("SELECT * FROM users WHERE username='$username'");

$numrows = mysql_num_rows($query);

if ($numrows!=0)
{
	while ($row = mysql_fetch_assoc($query)) {
		$dbusername = $row["username"];
		$dbpassword = $row["password"];
	}
	if ($username==$dbusername&&$password==$dbpassword) {
		$_SESSION["$username"]=$dbusername;
		header("location: config.php");
	
	}
	else echo "<br><br><br>Invalid Password, Please Hit the [BACK] Button and Try Again<br><br>";
}
else die("<br><br><br>Invalid User Name, " . $username .". Please Hit the [BACK] Button and Try Again<br><br>");

?>

