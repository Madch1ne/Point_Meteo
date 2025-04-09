<?php
declare(strict_types= 1);
    
$style = isset($_GET['style']) ? $_GET['style'] : 'style';
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'fr';


if ($lang === 'en') {
    include 'english.inc.php';
} else {
    include 'french.inc.php';
}

$title="TECH";
require "include/header.inc.php";
require "include/function.inc.php";



// Clé API NASA 
$api_key = "DEMO_KEY";

// Récupération des données
$nasaData = getNasaApod($api_key);
$locationData = getUserLocation();
?>
<html>
<body>
    <h1> Page Tech - APIs </h1>

    <!-- Image du jour NASA -->
    <section>
        <h2> Image du Jour (NASA APOD)</h2>
        <h3><?= $nasaData["title"] ?></h3>
            <img src="<?= $nasaData["image_url"] ?>" alt="Image du jour" width="600">
            <p><?= $nasaData["explanation"] ?></p>
    </section>

    <!-- Localisation par IP -->
    <section>
        <h2>📍 Votre localisation estimée</h2>
        <p>Ville : <?= $locationData["city"] ?></p>
        <p>Pays : <?= $locationData["country"] ?></p>
        <p>Latitude : <?= $locationData["latitude"] ?>, Longitude : <?= $locationData["longitude"] ?></p>
    </section>
</body>
</html>
<?php
require "include/footer.inc.php";
?>
