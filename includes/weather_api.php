<?php
declare(strict_types = 1);




function get_departments() : array {
    
        $depFile = fopen("util/v_departement_2024.csv", "r");
        $regionFile = fopen("utilv_region_2024.csv", "r");
        $cityFile = fopen("util/cities.csv", "r");

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

   /**
     * recupere la méteo actuelle ainsi que les données des previsions prochaine selon la localité (JSON)
     * 
     * @param string $ville  nom de la ville
     * @return array tableau des données méteo 
     */
function prevision($ville) : array{
    $url = "https://www.prevision-meteo.ch/services/json/{$ville}";
    $json = file_get_contents($url);

    if ($json === false) {
        return ["error" => "Erreur lors de la récupération des données"];
    }
    
    // Décodage du JSON en tableau associatif
    $data = json_decode($json, true);
    if($data === false){
        return ["error" => "Erreur lors de la récupération des données"];
    }

    return array(
        'current' => [
            'temp' => $data['current_condition']['tmp'],
            'condition' => $data['current_condition']['condition'],
            'humidity' => $data['current_condition']['humidity'],
            'wind' => $data['current_condition']['wnd_spd'],
            'rise' => $data['city_info']['sunrise'],
            'set' => $data['city_info']['sunset'],
            'icon' => $data['current_condition']['icon_big'],
        ],
        'daily' => [
            [
             'day' => $data['fcst_day_1']['day_long'], 
             'tempMax' => $data['fcst_day_1']['tmax'], 
             'tempMin' => $data['fcst_day_1']['tmin'], 
             'condition' => $data['fcst_day_1']['condition'],
             'icon' => $data['fcst_day_1']['icon']
            ],
            [
             'day' => $data['fcst_day_2']['day_long'], 
             'tempMax' => $data['fcst_day_2']['tmax'], 
             'tempMin' => $data['fcst_day_2']['tmin'], 
             'condition' => $data['fcst_day_2']['condition'],
             'icon' => $data['fcst_day_2']['icon']
            ],
            [
             'day' => $data['fcst_day_3']['day_long'], 
             'tempMax' => $data['fcst_day_3']['tmax'], 
             'tempMin' => $data['fcst_day_3']['tmin'], 
             'condition' => $data['fcst_day_3']['condition'],
             'icon' => $data['fcst_day_3']['icon']
            ],
            [
                'day' => $data['fcst_day_4']['day_long'], 
                'tempMax' => $data['fcst_day_4']['tmax'], 
                'tempMin' => $data['fcst_day_4']['tmin'], 
                'condition' => $data['fcst_day_4']['condition'],
                'icon' => $data['fcst_day_4']['icon']
               ],
        ],
        'hourly' => $data['fcst_day_0']['hourly_data'], 

    );

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
    
    

?>