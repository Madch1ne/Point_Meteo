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
?>

<?php
    $ville ="tour";
    $weatherData = prevision($ville);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test onglets CSS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="prevision-tabs">
                <div class="tab-header">
                    <button class="tab-btn" data-tab="daily">Prévisions 3 jours</button>
                    <button class="tab-btn" type="button" data-bs-toggle="collapse" data-bs-target="#hourly" aria-expanded="false" aria-controls="hourly" data-tab="hourly">Prévisions horaires</button>
                </div>
                
                <div class="tab-content">
                    <div id="daily">
                        <div class="daily-prevision">
                            <?php
                            
                           echo "jour de la semaine";
                            ?>
                        </div>
                    </div>

                    
                    <div id="hourly" class="collapse collapse-horizontal">
                        <div class="hourly-prevision">
                            <?php
							echo "heures";             
                            ?>
                        </div>
                    </div>


                </div>
</body>
</html>
