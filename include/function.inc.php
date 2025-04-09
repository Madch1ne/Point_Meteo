<?php
// function.inc.php

/**
 * Récupère l'image du jour de la NASA APOD via une API REST en JSON
 * @param string $api_key Clé API NASA
 * @return array Données contenant l'image, le titre et l'explication
 */
function getNasaApod($api_key) {
    $date = date("Y-m-d");
    $url = "https://api.nasa.gov/planetary/apod?api_key=" .urlencode($api_key). "&date=".urlencode($date);

    $response = file_get_contents($url,true);
    if(!$response){
        return["error" => "probleme  d'url"];
    }
    $data = json_decode($response, true);
    // print_r($data);

    return array(
        "image_url" => $data["url"] ?? "error.jpg",
        "title" => $data["title"] ?? "Erreur",
        "explanation" => $data["explanation"] ?? "Données non disponibles.");
        
}

/**
 * Récupère la localisation approximative d'un utilisateur via son IP (XML)
 * @return array Données de localisation (ville, pays, latitude, longitude)
 */
function getUserLocation() {
    $ip = "193.54.115.235"; //$_SERVER['REMOTE_ADDR']; // Récupération de l'IP utilisateur
    $url = "http://www.geoplugin.net/php.gp?ip=$ip";

    $xml = simplexml_load_file($url);

    return [
        "city" => $xml->geoplugin_city ?? "Ville inconnue",
        "country" => $xml->geoplugin_countryName ?? "Pays inconnu",
        "latitude" => $xml->geoplugin_latitude ?? "N/A",
        "longitude" => $xml->geoplugin_longitude ?? "N/A",
        "region"=> $xml->geoplugin_region??"N/A"
    ];
}

     


function get_departments() : array
    {
        $depFile = fopen("ressources/v_departement_2024.csv", "r");
        $regionFile = fopen("ressources/v_region_2024.csv", "r");
        $cityFile = fopen("ressources/cities.csv", "r");

        $regionCodes = [];
        $regions = [];

        fgetcsv($regionFile);
        while (($regionData = fgetcsv($regionFile)) !== FALSE) {
            $regionCode = $regionData[0];
            $regionName = $regionData[5];

            $regionCodes[$regionCode] = $regionName;
        }

        fclose($regionFile);

        fgetcsv($depFile);
        while (($depData = fgetcsv($depFile)) !== FALSE) {
            $regionCode = $depData[1];
            $depNumber = $depData[0];
            $depName = $depData[6];

            if (isset($regionCodes[$regionCode])) {
                $regionName = $regionCodes[$regionCode];

                $regions[$regionName][] = ['num' => $depNumber, 'name' => $depName, 'cities' => []];
            }
        }

        fclose($depFile);

        fgetcsv($cityFile);
        while (($cityData = fgetcsv($cityFile)) !== FALSE) {
            $cityCode = $cityData[3];
            $cityName = $cityData[4];
            $cityDep = $cityData[1];

            foreach ($regions as &$department) {
                foreach ($department as &$dep) {
                    if ($dep['num'] == $cityDep) {
                        $dep['cities'][] = ['name' => $cityName, 'code' => $cityCode];
                    }
                }
            }
        }
        fclose($cityFile);

        return $regions;
    }