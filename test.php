<?php
include 'includes/function.inc.php';
include 'includes/weather_api.php';
include 'includes/header.inc.php';

$key = "36d7bf6d3ef04cdea4953d1fea19de1c";
$Wip = "193.54.115.192";
$result = getGeoWData($key,$Wip); // Les valeurs passées ne sont pas utilisées ici car elles sont écrasées dans la fonction.

echo "<pre>";
print_r($result);
echo "</pre>";


echo"<pr>";
$geokey = "cbf9e49b-7461-4ae9-a349-91f6e70bd452";
$ip = "193.54.115.192";

$geo = getGeoPData($geokey,$ip);

echo "<pre>";
print_r($geo);
echo "</pre>";


echo"<pr>";
$apiKey = "r4Nt17r1iUV59i8ry0f4zmM6Wv8xUHQ7fdA7nQ9Q"; // clé personnelle
$date = date("Y-m-d"); //affichera "2025-03-15"


$apod = getApodData($apiKey, $date);

echo "<pre>";
print_r($apod);
echo "</pre>";


echo"<pr>";
$ville ="paris";
$meteo = prevision($ville);

echo "<pre>";
print_r($meteo);
echo "</pre>";



$count= hitCounter(); 
echo"<pr>";
echo"<pre>";
print_r($count);
echo"<pre>";
// echo $count['counter'];
?>

