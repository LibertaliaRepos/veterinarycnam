<?php


$data = array(
    'address' => 'route de gap, 05400, VEYNES',
    'key' => 'AIzaSyDxTE-vsnAFqupCpWG9D3Q7e-l0-3Yh_Gs'
);

$url = 'https://maps.googleapis.com/maps/api/geocode/json?'. http_build_query($data);

var_dump($url);

$json = json_decode(file_get_contents($url), true);

var_dump($json['results'][0]['geometry']['location']);

