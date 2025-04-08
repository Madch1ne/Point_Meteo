<?php
declare(strict_types = 1);

// Sélection de la langue (par défaut: français)
$lang = isset($_GET['lang']) && $_GET['lang'] === 'en' ? 'english.inc.php' : 'french.inc.php';

// Sélection du style (mode jour/nuit)
$style = isset($_GET['style']) && $_GET['style'] === 'alternatif' ? 'style_alternatif.css' : 'styles.css';

$description = "Ce site est un travail demnandé en classe de developpement web, à l'université de Cergy pour se familiariser avec le language PHP";
$title = "PHP: technique";
$h1 = "Page techinque";
  require("includes/function.inc.php");
  require("includes/header.inc.php");

// Récupérer les données de l'API APOD
$apiKey = "r4Nt17r1iUV59i8ry0f4zmM6Wv8xUHQ7fdA7nQ9Q"; // clé personnelle
$date = date("Y-m-d"); //affichera "2025-03-15"
$result = getApodData($apiKey, $date);

// Récupérer les données géographiques 
     //geoplugin
$geokey = "cbf9e49b-7461-4ae9-a349-91f6e70bd452";
$ip = "193.54.115.192";//$_SERVER['REMOTE_ADDR'];// affichera "193.54.115.192";
$geopData = getGeoPData($geokey, $ip);

    //ipinfo
$infoIp = "193.54.115.192";
$geoIData = getGeoIData($infoIp);

   //Whatsmyip
$key = "36d7bf6d3ef04cdea4953d1fea19de1c";
$Wip = "193.54.115.192"; //$_SERVER['REMOTE_ADDR'];// affichera "193.54.115.192";
$geoWData = getGeoWData($key, $Wip);

?>     

<main id="main-central">
        <section id ="APOD">
            <h1 class ="tlt"> <?= $h1 ?> </h1>
            <article>
                <h2 class ="tlt">Astronomy Picture of the Day (APOD)</h2>
                <?php
                
                    echo $result['media'];
                    echo "<p>" . $result['explanation'] . "</p>";
                ?>
                
                    
            </article>

        </section>
        <section id="geo">
            <h1 class ="tlt"> Geolocalisation par l'addresse IP</h1>
            <article id="geoplugin">
                <h2 class ="tlt">Votre position géographique approximative(geoplugin)</h2>
                <div>
                    
                    <p> Votre IP : <?= $geopData['IP'] ?> </p>
                    <p> Votre continent : <?= $geopData['continent'] ?> </p>
                    <p> Le code du continent : <?= $geopData['continentCode'] ?> </p>
                    <p> Votre pays : <?= $geopData['pays'] ?> </p>
                    <p> Le code du pays : <?= $geopData['paysCode'] ?> </p>
                    <p> Votre ville : <?= $geopData['ville'] ?> </p>
                    <p> Le code postal  : <?= $geopData['postCode'] ?> </p>
                    <p> Votre région : <?= $geopData['region'] ?> </p>
                    <p> Le code de la région : <?= $geopData['regionCode'] ?> </p>
                    <p> Latitude : <?= $geopData['latitude'] ?> </p>
                    <p> Longitude : <?= $geopData['longitude'] ?> </p>
                </div>
            </article>

            <article id="Ipinfo">
                <h2 class ="tlt">Votre position géographique approximative(Ipinfo)</h2>
                <div>              
                    <p> Votre IP : <?= $geoIData['IP'] ?> </p>
                    <p> Hote utilisateur : <?= $geoIData['Hote'] ?> </p>
                    <p> Le code du pays : <?= $geoIData['paysCode'] ?> </p>
                    <p> Votre ville : <?= $geoIData['ville'] ?> </p>
                    <p> Le code postal  : <?= $geoIData['postCode'] ?> </p>
                    <p> Votre région : <?= $geoIData['region'] ?> </p>
                    <p> Localisation : <?= $geoIData['loc'] ?> </p>
                    <p> Fuseau Horraire : <?= $geoIData['time'] ?> </p>
                </div>
            </article>

            <article id="WhatsMyIp">
                <h2 class ="tlt">Votre position géographique approximative(WhatsMyIp)</h2>
                <div> 
                    <p><?php $geoWData ?> </p>             
                    <p> Votre IP : <?= $geoWData['IP'] ?> </p>
                    <p> Hote utilisateur : <?= $geoWData['hote'] ?> </p>
                    <p> Le code du pays : <?= $geoWData['paysCode'] ?> </p>
                    <p> Votre ville : <?= $geoWData['ville'] ?> </p>
                    <p> Le code postal  : <?= $geoWData['postCode'] ?> </p>
                    <p> Votre région : <?= $geoWData['region'] ?> </p>
                    <p> Latitude : <?= $geoWData['latitude'] ?> </p>
                    <p> Longitude : <?= $geoWData['longitude'] ?> </p>
                    <p> Fuseau Horraire : <?= $geoWData['time'] ?> </p>
                </div>
            </article>
        </section>
   
</main>



<?php
   require("includes/footer.inc.php");
?>