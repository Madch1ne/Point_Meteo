<?php
declare(strict_types = 1);


   /**
     * recupere la méteo actuelle ainsi que les données des previsions prochaine selon la localité (JSON)
     * 
     * @param string $ville  nom de la ville
     * @return array tableau des données méteo 
     */
function prevision($ville) : array{
    $url = "http://www.prevision-meteo.ch/services/json/{$ville}";
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
        
        // le mois stocké dans le fichier
        $moisEng = date("F");
        // Si le mois stocké est différent du mois en cours, réinitialiser le compteur
        $currentMonth = date("F");
        if ($moisEng !== $currentMonth) {
            $storedCounter = 0;
            $moisEng = $currentMonth;
        }
        
        // Incrémenter le compteur
        $storedCounter++;
        
        // Préparer la ligne CSV à réécrire
        $ligne = $moisEng . "," . $storedCounter;
        file_put_contents($filename, $ligne, LOCK_EX);
        
        // Retourner les valeurs sous forme de tableau associatif
        return [
            'counter' => $storedCounter,
            'dates' => $moisEng
        ];
    }

    function visitVille($ville) {
        // Nom du fichier pour stocker les visites
        $file = './util/villes.csv';
        
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
    
    function villeStats() {
        $file = './util/villes.csv';
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

    function displayCitiesHistogram() {
        $stats = villeStats();
    
        // Trouver le maximum pour normaliser la largeur des barres
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