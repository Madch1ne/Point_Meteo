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
    //print_r($data);

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
            'date' => $storedMonth
        ];
    }

    function visitVille($ville) {
        // Nom du fichier pour stocker les visites
        $file = 'villes.csv';
        
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
    
    

?>