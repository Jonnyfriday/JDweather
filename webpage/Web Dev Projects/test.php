<?php
  $json_string = file_get_contents("http://api.wunderground.com/api/26a5ba3debf9e70e/geolookup/conditions/q/VT/Randolph.json");
  $parsed_json = json_decode($json_string);
  $location = $parsed_json->{'location'}->{'city'};
  $wind_mph = $parsed_json->{'current_observation'}->{'wind_mph'};
  $wind_dir = $parsed_json->{'current_observation'}->{'wind_dir'};
  $precip_today_in = $parsed_json->{'current_observation'}->{'precip_today_in'};
  echo "Current wind speed in ${location} is: ${wind_mph}<br>";
  echo "Current wind direction in ${location} is: ${wind_dir}<br>";
  echo "Current rainfall in ${location} is: ${precip_today_in}\n";
?>