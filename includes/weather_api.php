<?php
declare(strict_types = 1);
require_once("includes/function.inc.php");

// Fonction pour obtenir les coordonnées d'une région 
/**
 * Retourne les coordonnées de la région pour une image map en format chaîne CSV.
 *
 * @param string $region Nom de la région (ex. "Bretagne").
 * @return string Coordonnées à passer dans l’attribut coords de <area>.
 *                Si la région n’existe pas, retourne une chaîne vide.
 */
function get_region_coords(string $region): string {
    $coords = [
        'Bretagne' => '47,184,59,172,72,170,93,174,109,169,135,166,142,183,157,188,177,187,198,186,218,199,231,201,227,219,229,232,221,243,210,243,197,247,183,259,162,267,130,251,88,232,65,232',//
        'Pays de la Loire' => '239,203,308,213,326,234,319,259,297,268,283,291,277,305,252,309,233,311,239,329,241,353,227,365,207,362,178,331,171,299,155,278,199,253,230,242',//
        'Nouvelle-Aquitaine' => '246,320,264,314,291,320,311,330,336,370,361,374,390,369,399,382,410,396,399,409,407,432,398,445,384,456,378,473,354,464,340,475,332,494,318,502,312,515,311,534,289,541,251,543,241,567,251,581,245,601,237,622,216,612,189,599,177,580,197,536,203,500,218,490,207,477,214,429,239,472,241,444,224,410,228,377,251,364',//
        'Occitanie' => '377,480,353,476,327,507,331,525,311,545,261,548,254,563,266,581,244,629,279,635,316,626,353,645,375,668,432,667,420,629,439,605,469,598,503,584,530,558,513,532,494,538,483,518,471,501,444,495,436,511,421,490,405,507,385,506',//
        'Provence-Alpes-Côte d\'Azur' => '533,533,535,547,539,564,515,592,532,599,558,607,586,619,630,615,643,602,659,587,681,577,680,557,652,540,646,513,654,501,636,482,620,474,622,491,606,501,584,514,583,531,592,551,566,553,551,539',//
        'Auvergne-Rhône-Alpes' => '412,379,407,368,429,350,455,356,477,361,493,388,530,394,550,376,571,381,595,384,587,397,606,403,620,388,634,388,638,402,649,411,635,424,653,451,631,470,605,471,610,485,593,492,581,505,566,521,578,542,571,546,556,533,547,531,546,518,535,516,530,527,516,529,493,524,481,492,456,478,433,488,419,474,401,495,387,487,390,462,415,453,414,437,412,415,422,393',//
        'Grand Est' => '535,89,515,108,508,123,501,145,493,159,479,172,469,192,469,217,484,237,517,251,530,248,549,257,553,272,571,272,586,257,601,249,651,262,663,282,673,284,680,276,678,255,687,235,689,205,708,181,693,173,657,167,639,167,615,147,600,147,576,141,559,131,545,119',//
        'Bourgogne-Franche-Comté' => '445,232,450,227,464,229,471,242,487,259,519,260,537,267,539,279,553,289,572,287,585,275,596,263,617,259,646,273,653,288,643,301,649,313,628,327,597,362,583,366,563,358,546,356,536,369,517,373,507,379,495,361,483,342,466,339,453,337,451,308,441,287,441,265,449,251',//
        'Centre-Val de Loire' => '333,192,350,189,363,176,367,185,367,193,379,209,385,221,393,228,406,225,410,233,423,241,437,239,441,248,428,269,435,277,429,287,441,306,445,336,418,341,412,351,401,361,364,360,352,361,343,361,319,321,307,315,296,310,287,295,300,275,318,268,331,247,333,227,338,215,339,201',//
        'Normandie' => '202,109,211,135,219,196,321,201,322,185,349,185,358,169,378,145,375,99,331,103,309,112,306,125,322,131,295,135,284,148,244,134,230,114',//
        'Île-de-France' => '402,156,367,163,369,176,373,183,375,194,385,208,395,215,415,218,419,229,425,227,437,228,443,214,457,215,457,187,445,172',//
        'Hauts-de-France' => '462,189,449,162,403,151,379,151,387,112,369,88,383,81,381,38,425,13,505,73,508,102,493,142', //
        'Corse' => '712,576,712,618,713,645,704,670,701,687,685,680,676,649,673,617,685,602,705,600'
    ];
    return $coords[$region] ?? '';
}

   /**
     * Construit le tableau des régions, départements et villes à partir de 3 fichiers CSV.
     *
     * Lit successivement :
     *  - v_region_2024.csv  pour obtenir le code et le nom des régions,
     *  - v_departement_2024.csv pour associer chaque département à sa région,
     *  - cities.csv          pour rattacher chaque ville à son département.
     *
     * @return array Tableau associatif où chaque clé est un nom de région et la valeur est un tableau de départements lui-meme contenant les villes.
     *               
     */
function get_departments() : array {
    
        $depFile = fopen("./util/ressources/v_departement_2024.csv", "r");
        $regionFile = fopen("./util/ressources/v_region_2024.csv", "r");
        $cityFile = fopen("./util/ressources/cities.csv", "r");

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

                $regions[$regionName][] = [
                    'num' => $depNumber, 
                    'name' => $depName, 
                    'cities' => []];   // les seront ajouté aprés
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

   /**
     * recupere la méteo actuelle ainsi que les données des previsions prochaine selon la localité (JSON)
     * 
     * @param string $ville  nom de la ville
     * @return array tableau des données méteo 
     */
    function prevision(string $ville): array {
        $key      = 'prevision_' . strtolower($ville);
        $cached   = cache_read($key, 3600); // cache 1h
        if ($cached !== false) {
            return $cached;
        }
    
        $url  = "https://www.prevision-meteo.ch/services/json/{$ville}";
        $json = file_get_contents($url);
        if ($json === false) {
            // en cas d’erreur, retombe sur cache périmé
            $old = cache_read($key, PHP_INT_MAX);
            if ($old !== false) {
                return $old;
            }
            return ["error" => "Erreur lors de la récupération des données météo."];
        }
    
        $data = json_decode($json, true);
        if (!is_array($data)) {
            $old = cache_read($key, PHP_INT_MAX);
            if ($old !== false) {
                return $old;
            }
            return ["error" => "Données météo JSON invalides."];
        }
    
        $result = [
            'current' => [
                'temp'      => $data['current_condition']['tmp'] ?? null,
                'condition' => $data['current_condition']['condition'] ?? null,
                'humidity'  => $data['current_condition']['humidity'] ?? null,
                'wind'      => $data['current_condition']['wnd_spd'] ?? null,
                'rise'      => $data['city_info']['sunrise'] ?? null,
                'set'       => $data['city_info']['sunset'] ?? null,
                'icon'      => $data['current_condition']['icon_big'] ?? null,
            ],
            'daily' => [
                [
                    'day'       => $data['fcst_day_1']['day_long']  ?? null,
                    'tempMax'   => $data['fcst_day_1']['tmax']      ?? null,
                    'tempMin'   => $data['fcst_day_1']['tmin']      ?? null,
                    'condition' => $data['fcst_day_1']['condition'] ?? null,
                    'icon'      => $data['fcst_day_1']['icon']      ?? null,
                ],
                [
                    'day'       => $data['fcst_day_2']['day_long'],
                    'tempMax'   => $data['fcst_day_2']['tmax'],
                    'tempMin'   => $data['fcst_day_2']['tmin'],
                    'condition' => $data['fcst_day_2']['condition'],
                    'icon'      => $data['fcst_day_2']['icon'],
                ],
                [
                    'day'       => $data['fcst_day_3']['day_long'] ,
                    'tempMax'   => $data['fcst_day_3']['tmax'] ,
                    'tempMin'   => $data['fcst_day_3']['tmin'],
                    'condition' => $data['fcst_day_3']['condition'],
                    'icon'      => $data['fcst_day_3']['icon'],
                ],
                [
                    'day'       => $data['fcst_day_4']['day_long'] ,
                    'tempMax'   => $data['fcst_day_4']['tmax'] ,
                    'tempMin'   => $data['fcst_day_4']['tmin'],
                    'condition' => $data['fcst_day_4']['condition'],
                    'icon'      => $data['fcst_day_4']['icon'],
                ],
            ],
            'hourly' => $data['fcst_day_0']['hourly_data']
        ];
    
        cache_write($key, $result);
        return $result;
    }
   /**
     * Met à jour le compteur de fréquentation stocké dans un fichier texte.
     *
     * Cette fonction vérifie si le fichier spécifié existe. S'il n'existe pas, il est créé avec une valeur initiale de 0.
     *
     * @param string $filename Le chemin vers le fichier compteur. Par défaut, "counter.txt".
     * @return array Retourne un tableau de valeur mise à jour du compteur.
     */
    
    function hitCounter($filename = './util/counter.csv') : array {
        // Si le fichier n'existe pas, le créer avec une ligne initiale "Mois,0"
        if (!file_exists($filename)) {
            $initialLine = date("F") . ",0";
            file_put_contents($filename, $initialLine, LOCK_EX);
        }
        
        // Lire le contenu du fichier
        $contents = file_get_contents($filename);
        $contents = trim($contents);
        
        // S'il y a une virgule, on s'attend à un format "mois,counter"
        if (strpos($contents, ',') !== false) {
            list($storedMonth, $storedCounter) = explode(',', $contents);
            $storedCounter = (int)$storedCounter;
        } else {
            // Si le fichier contient juste un nombre, on le traite comme tel et on utilise le mois courant
            $storedCounter = (int)$contents;
            $storedMonth = date("F");
        }
        $storedMonth = date("F");
        // Si le mois stocké est différent du mois en cours, réinitialiser le compteur
        $currentMonth = date("F");
        if ($storedMonth !== $currentMonth) {
            $storedCounter = 0;
            $storedMonth = $currentMonth;
        }
        
        // Incrémenter le compteur
        $storedCounter++;
        
        // Préparer la ligne CSV à réécrire
        $line = $storedMonth . "," . $storedCounter;
        file_put_contents($filename, $line, LOCK_EX);
        
        // Retourner les valeurs sous forme de tableau associatif
        return [
            'counter' => $storedCounter,
            'dates' => $storedMonth
        ];
    }



   /**
     * Enregistre les villes vistées dans un fichier CSV.
     *
     * Cette fonction récupère la date et le nom de la ville passée en paramètre,
     * puis ajoute une ligne dans le fichier CSV ('./util/villes.csv'). Chaque ligne
     *  est dans le format [date, ville].
     *
     * @param string $ville Le nom des villes consultée.
     * @return void
     */
    function visitVille($ville) : void {
        // Nom du fichier pour stocker les visites
        $file = './util/stats/villes.csv';
        
        // date et l'heure actuelle
        $dateTime = date("Y-m-d H:i:s");
        
        // les lignes dans le fichier 
        $ligne = [$dateTime, $ville];
        
        // Ouvrir le fichier en mode ajout ('a')
        $ecrit = fopen($file, 'a');
            // Écriture de la ligne dans le fichier en utilisant fputcsv
            fputcsv($ecrit, $ligne);
            fclose($ecrit);
    }
    


   /**
     * Analyse le fichier CSV des visites et calcule les statistiques par ville.
     *
     * Cette fonction lit le fichier CSV (./util/villes.csv) ligne par ligne en supposant que chaque
     * ligne a pour structure [dateTime, ville]. Elle génère un tableau associatif où la clé est le nom de la ville
     * et la valeur correspond au nombre de visites enregistrées pour cette ville.
     *
     * @return array Un tableau associatif [nom de la ville => nombre de visites].
     */
    function villeStats() : array {
        $file = './util/stats/villes.csv';
        $stats = [];  // Tableau associatif : [nom de la ville => nombre de visites]
        
        
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                // Chaque ligne est formaté comme [dateTime, ville]
                $ville = $data[1] ?? '';
                if ($ville != '') {
                    if (!isset($stats[$ville])) {
                        $stats[$ville] = 0;
                    }
                    $stats[$ville]++;
                }
            }
            fclose($handle);
        }
        return $stats;
    }

    
   /**
     * Affiche un histogramme des villes les plus consultées.
     *
     * Cette fonction utilise les statistiques de la fonction villeStats().
     * Pour déterminer la valeur maximale (nombre de visites)la largeur des barres d'histogramme.
     *
     * @return void
     */
    function displayCitiesHistogram() : void {
        $stats = villeStats();
    
        // Trouver le maximum pour la largeur des barres
        $max = max($stats);
        
        echo '<ul style="list-style: none; padding: 0;">';
        foreach ($stats as $city => $count) {
            // Calcule la largeur en pourcentage (par exemple, maximum = 100%)
            $width = ($max > 0) ? ($count / $max * 100) : 0;
            echo '<li style="margin: 0.5rem 0;">';
            echo '<strong>' . htmlspecialchars($city) . ' (' . $count . ' visites)</strong>';
            echo '<div style="background: #3b82f6; height: 20px; width: ' . $width . '%;"></div>';
            echo '</li>';
        }
        echo '</ul>';
    }

   /**
     * Retourne le chemin d’une image aléatoire parmi une liste prédéfinie.
     *
     * @return string le chemin relatif vers l'image.
     */
    function images() : string {
        // tableau avec les chemins vers les images 
            $imagesLink = [
                "./image/random/plage.jpg",
                "./image/random/milan.jpg",
                "./image/random/lune.jpg",
                "./image/random/finistere.jpg",
                "./image/random/nocturne.jpg",
                "./image/random/cascade.jpg",
                "./image/random/eclair.jpg",
                "./image/random/ladefense.jpg",
                "./image/random/atlantique.jpg",
                "./image/random/ciel.jpg",
                "./image/random/sky.jpg"

            ];

        return $imagesLink[array_rand($imagesLink)];
    }
    
    

?>