<<?php
declare(strict_types= 1);
    
$style = isset($_GET['style']) ? $_GET['style'] : 'style';
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'fr';

if ($lang === 'en') {
    include 'english.inc.php';
} else {
    include 'french.inc.php';
}

$title = "Meteo";
require "include/header.inc.php";
require "include/function.inc.php";

//j'utilise la fonctions get departement dans function.inc.phpgi
$regions = get_departments();

// Récupération des paramètres
$selectedRegion = isset($_GET['region']) ? $_GET['region'] : '';
$selectedDept = isset($_GET['departement']) ? $_GET['departement'] : '';
$selectedVille = isset($_GET['ville']) ? $_GET['ville'] : '';

// Gérer la soumission du formulaire pour afficher les données météo
$showMeteo = isset($_GET['submit']);

// Carte des régions (correspondant à l'image map)
$regionMap = [
    'Bretagne' => 'Bretagne',
    'Pays de la Loire' => 'Pays de la Loire',
    'Nouvelle-Aquitaine' => 'Nouvelle-Aquitaine',
    'Occitanie' => 'Occitanie',
    'Provence-Alpes-Côte d\'Azur' => 'Provence-Alpes-Côte d\'Azur',
    'Auvergne-Rhône-Alpes' => 'Auvergne-Rhône-Alpes',
    'Grand Est' => 'Grand Est',
    'Bourgogne-Franche-Comté' => 'Bourgogne-Franche-Comté',
    'Centre-Val de Loire' => 'Centre-Val de Loire',
    'Normandie' => 'Normandie',
    'Île-de-France' => 'Île-de-France',
    'Hauts-de-France' => 'Hauts-de-France',
    'Corse' => 'Corse'
];

// Tableau pour stocker les noms des régions selon la carte interactive
$mapRegions = array_keys($regionMap);
?>

<div class="container">
    <h1><?= $lang === 'fr' ? 'Météo France' : 'Weather France' ?></h1>
    
    <div class="row">
        <div class="col-md-8">
            <!-- Image Map avec les régions -->
            <div class="map-container">
                <h2><?= $lang === 'fr' ? 'Sélectionnez une région sur la carte' : 'Select a region on the map' ?></h2>
                <!-- Image Map Generated by http://www.image-map.net/ -->
                <img src="images/france carte.png" usemap="#image-map" class="img-fluid">

                <map name="image-map">
                    <?php foreach ($mapRegions as $region): ?>
                    <area target="" alt="<?= $region ?>" title="<?= $region ?>" href="meteo.php?region=<?= urlencode($region) ?>&lang=<?= $lang ?>&style=<?= $style ?>" 
                        <?php 
                        // Les coordonnées restent les mêmes que dans votre code original
                        switch($region) {
                            case 'Bretagne':
                                echo 'coords="188,364,63,332,31,307,54,304,45,287,27,279,78,237,109,237,133,224,171,260,198,246,225,241,250,248,263,264,284,263,287,308,270,337,235,339,212,358"';
                                break;
                            case 'Pays de la Loire':
                                echo 'coords="272,486,201,414,220,412,204,401,184,382,207,363,242,340,272,341,288,315,290,261,311,266,334,263,346,257,357,274,383,263,414,295,401,343,377,350,362,396,300,415,313,460,316,477,306,480"';
                                break;
                            case 'Nouvelle-Aquitaine': // Ancien "Aquitaine Limousin Poitou-Charentes"
                                echo 'coords="321,840,259,813,235,780,283,561,260,512,310,484,318,460,306,418,359,399,383,417,403,414,443,474,517,472,538,513,526,531,531,574,505,612,462,612,408,708,344,720,340,756,358,777,350,803"';
                                break;
                            case 'Occitanie': // Ancien "Languedoc-Roussilllon"
                                echo 'coords="337,833,404,848,405,832,435,844,457,853,480,864,500,880,531,882,575,869,604,787,648,769,679,743,692,712,667,684,641,681,611,628,594,617,569,650,550,627,527,652,511,651,503,624,472,612,445,643,409,712,369,718,350,724,342,743,357,772"';
                                break;
                            case 'Provence-Alpes-Côte d\'Azur': // Ancien "Provence-Alpes"
                                echo 'coords="652,773,698,780,726,783,731,797,777,812,819,800,840,770,868,749,897,710,890,699,850,694,840,671,848,647,843,632,827,615,817,605,796,608,797,620,777,634,769,637,754,656,750,669,753,693,742,704,720,693,705,688,690,687,693,716,680,747"';
                                break;
                            case 'Auvergne-Rhône-Alpes': // Ancien "Auvergne-Rhones-alpes"
                                echo 'coords="856,573,834,541,849,518,836,501,834,474,795,484,777,498,783,475,756,488,736,486,716,468,691,494,681,487,663,493,639,499,633,494,634,467,610,440,585,447,558,435,550,441,541,455,519,469,538,497,541,518,529,531,536,574,517,599,506,619,517,643,547,624,563,638,585,615,610,617,643,673,667,677,687,682,703,682,722,670,723,683,736,690,736,671,745,658,756,647,766,633,782,627,790,613,789,599,819,601,834,598,852,588"';
                                break;
                            case 'Grand Est': // Inclut l'ancien "Alsace"
                                echo 'coords="868,373,890,357,931,214,785,164,698,128,694,97,659,116,638,176,617,180,600,229,598,270,620,298,632,316,681,312,707,329,722,349,750,351,760,328,774,322,782,318,799,324,811,326,839,337,849,351,849,366"';
                                break;
                            case 'Bourgogne-Franche-Comté': // Ancien "Bourgogne"
                                echo 'coords="709,460,752,478,787,466,807,436,823,407,847,379,847,363,815,322,792,323,774,323,753,346,734,350,723,348,706,341,690,325,697,317,679,312,659,314,638,317,622,305,600,287,604,275,589,267,581,274,572,286,579,306,570,329,565,354,565,372,575,431,592,441,610,434,637,480,646,489,669,487,688,486,939,464,773,465"';
                                break;
                            case 'Centre-Val de Loire': // Ancien "Val de Loire"
                                echo 'coords="513,464,573,422,565,387,559,351,573,315,554,300,529,301,530,282,504,283,493,271,479,255,464,236,454,231,431,239,423,254,427,274,418,291,418,319,395,349,387,354,367,392,385,413,403,409,424,440,441,458,454,465,462,469"';
                                break;
                            case 'Normandie':
                                echo 'coords="223,134,270,140,279,179,368,147,398,124,456,106,474,128,471,157,480,170,473,182,460,202,450,214,446,227,430,228,417,241,414,252,410,264,408,280,357,264,334,251,310,258,287,256,271,256,256,244"';
                                break;
                            case 'Île-de-France': // Ancien "Ile de France"
                                echo 'coords="558,295,573,277,590,263,596,255,596,235,584,214,580,201,565,202,548,203,534,198,513,195,497,193,482,195,464,205,463,218,469,236,487,259,497,275"';
                                break;
                            case 'Hauts-de-France': // Ancien "Nord-Pas-Calais"
                                echo 'coords="459,100,468,20,535,1,580,31,614,68,649,81,652,101,650,132,643,144,639,162,617,176,601,197,598,216,575,198,559,198,477,189,493,187"';
                                break;
                            case 'Corse':
                                echo 'coords="963,931,957,885,1000,842,1013,817,1015,854,1017,913,1014,944,1010,968,995,980,982,967,972,954"';
                                break;
                        }
                        ?>
                        shape="poly">
                    <?php endforeach; ?>
                </map>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Formulaire de sélection -->
            <form action="meteo.php" method="GET" class="meteo-form">
                <input type="hidden" name="lang" value="<?= $lang ?>">
                <input type="hidden" name="style" value="<?= $style ?>">
                
                <!-- Sélection de la région -->
                <div class="form-group">
                    <label for="region"><?= $lang === 'fr' ? 'Région' : 'Region' ?>:</label>
                    <select name="region" id="region" class="form-control" onchange="this.form.submit()">
                        <option value=""><?= $lang === 'fr' ? 'Sélectionnez une région' : 'Select a region' ?></option>
                        <?php foreach ($regions as $regionName => $departements): ?>
                            <option value="<?= $regionName ?>" <?= $selectedRegion === $regionName ? 'selected' : '' ?>><?= $regionName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <?php if ($selectedRegion && isset($regions[$selectedRegion])): ?>
                <!-- Sélection du département -->
                <div class="form-group">
                    <label for="departement"><?= $lang === 'fr' ? 'Département' : 'Department' ?>:</label>
                    <select name="departement" id="departement" class="form-control" onchange="this.form.submit()">
                        <option value=""><?= $lang === 'fr' ? 'Sélectionnez un département' : 'Select a department' ?></option>
                        <?php foreach ($regions[$selectedRegion] as $dept): ?>
                            <option value="<?= $dept['num'] ?>" <?= $selectedDept === $dept['num'] ? 'selected' : '' ?>><?= $dept['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                
                <?php if ($selectedDept && $selectedRegion && isset($regions[$selectedRegion])): ?>
                    <?php 
                    // Trouver le département sélectionné dans la région
                    $selectedDeptData = null;
                    foreach ($regions[$selectedRegion] as $dept) {
                        if ($dept['num'] === $selectedDept) {
                            $selectedDeptData = $dept;
                            break;
                        }
                    }
                    
                    if ($selectedDeptData && !empty($selectedDeptData['cities'])): 
                    ?>
                    <!-- Sélection de la ville -->
                    <div class="form-group">
                        <label for="ville"><?= $lang === 'fr' ? 'Ville' : 'City' ?>:</label>
                        <select name="ville" id="ville" class="form-control">
                            <option value=""><?= $lang === 'fr' ? 'Sélectionnez une ville' : 'Select a city' ?></option>
                            <?php foreach ($selectedDeptData['cities'] as $ville): ?>
                                <option value="<?= $ville['code'] ?>" <?= $selectedVille === $ville['code'] ? 'selected' : '' ?>><?= $ville['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" name="submit" value="1" class="btn btn-primary mt-3">
                        <?= $lang === 'fr' ? 'Afficher la météo' : 'Show weather' ?>
                    </button>
                    <?php else: ?>
                    <!-- Message si aucune ville n'est disponible pour ce département -->
                    <div class="alert alert-info">
                        <?= $lang === 'fr' ? 'Aucune ville disponible pour ce département dans notre base de données.' : 'No cities available for this department in our database.' ?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </form>
        </div>
    </div>
    
    <?php if ($showMeteo && $selectedVille): ?>
    <!-- Affichage des données météo -->
    <div class="meteo-results mt-4">
        <?php
        // Trouver le nom de la ville sélectionnée
        $selectedVilleName = "";
        if ($selectedRegion && $selectedDept) {
            foreach ($regions[$selectedRegion] as $dept) {
                if ($dept['num'] === $selectedDept) {
                    foreach ($dept['cities'] as $ville) {
                        if ($ville['code'] === $selectedVille) {
                            $selectedVilleName = $ville['name'];
                            break;
                        }
                    }
                    break;
                }
            }
        }
        ?>
        <h2><?= $lang === 'fr' ? 'Météo pour ' : 'Weather for ' ?> <?= htmlspecialchars($selectedVilleName) ?></h2>
        <div class="card">
            <div class="card-body">
                <!-- Simule des données météo aléatoires -->
                <?php
                    $conditions = [
                        'fr' => ['Ensoleillé', 'Nuageux', 'Partiellement nuageux', 'Pluvieux', 'Orageux'],
                        'en' => ['Sunny', 'Cloudy', 'Partly cloudy', 'Rainy', 'Thunderstorm']
                    ];
                    $conditionIndex = array_rand($conditions[$lang]);
                    $temperature = rand(5, 30);
                    $humidite = rand(30, 90);
                    $vent = rand(0, 50);
                    $precipitation = rand(0, 100);
                    
                    // Déterminer l'icône météo
                    $weatherIcon = 'sunny.png';
                    if ($conditionIndex == 1) $weatherIcon = 'cloudy.png';
                    else if ($conditionIndex == 2) $weatherIcon = 'partly-cloudy.png';
                    else if ($conditionIndex == 3) $weatherIcon = 'rainy.png';
                    else if ($conditionIndex == 4) $weatherIcon = 'thunderstorm.png';
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <img src="images/weather-icons/<?= $weatherIcon ?>" alt="<?= $conditions[$lang][$conditionIndex] ?>" class="weather-icon">
                            <h3><?= $temperature ?>°C</h3>
                            <p><?= $conditions[$lang][$conditionIndex] ?></p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h4><?= $lang === 'fr' ? 'Prévisions' : 'Forecast' ?></h4>
                        <table class="table">
                            <tr>
                                <td><?= $lang === 'fr' ? 'Humidité' : 'Humidity' ?></td>
                                <td><?= $humidite ?>%</td>
                            </tr>
                            <tr>
                                <td><?= $lang === 'fr' ? 'Vent' : 'Wind' ?></td>
                                <td><?= $vent ?> km/h</td>
                            </tr>
                            <tr>
                                <td><?= $lang === 'fr' ? 'Précipitation' : 'Precipitation' ?></td>
                                <td><?= $precipitation ?>%</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
require "include/footer.inc.php";
?>