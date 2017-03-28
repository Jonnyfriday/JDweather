function sunrise_sunset {
	var xhr = new XMLHttpRequest();
	xhr.open("GET", "http://api.sunrise-sunset.org/json", false);
	xhr.send();

	console.log(xhr.statusText);
}