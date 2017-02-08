<!DOCTYPE html>
<html lang="en">

<head>

<title>JD Weather Station Login</title>
<meta charset="utf-8">
<style>
body {
	background:url(lightning.jpg)no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	background-size: cover;
}

a:link {
    color: black;
}

a:hover {
    color: green;
}

table {   border-radius: 25px;
	background: silver;
    border: 10px solid #002DB3;
    padding: 20px; 
    width: 200px;
    height: 400px;  
}

input {
	text-align: center;
}

::-webkit-input-placeholder {
   text-align: center;
}

:-moz-placeholder { /* Firefox 18- */
   text-align: center;  
}

::-moz-placeholder {  /* Firefox 19+ */
   text-align: center;  
}

:-ms-input-placeholder {  
   text-align: center; 
}


</style>
</head>

<body style="background-color:#bfbfbf;  padding: 45px;" align=center>

<form action='jdconnect.php' method='POST'> 
<table align=center> 

<tr><td colspan=3><h3>Login</h3><h3>JD Weather Station</h3></td></tr> 
<tr><td>Username:</td><td> 
<input type="text" name="username" maxlength="40" placeholder="* Username *" required> 
</td></tr> <br>
<tr><td>Password:</td><td> 
<input type="password" name="pwd" maxlength="50" placeholder="* Password *" required> 
</td></tr> <br>
<tr><td> 
<input type="submit" name="submit" value="&nbsp;&nbsp;&nbsp; Login &nbsp;&nbsp;&nbsp;"></td> 
</tr> 
<br>
<tr><td>
</table></form>



</body>

</html>