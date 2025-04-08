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
     * @return int Retourne la valeur mise à jour du compteur.
     */
    function hitCounter($filename = './util/counter.csv') : array {
        // On vérifie si le fichier existe, sinon le créer avec la valeur 0
        if (!file_exists($filename)) {
            file_put_contents($filename, "0", LOCK_EX);
        }
        
        // Lire la valeur actuelle et la convertir en entier
        $counter = (int)file_get_contents($filename);
            
        // Incrémenter le compteur
        $counter++;
        $mois = date("F");
    
        // Préparer la ligne pour formter file_put_contents
        $line = $mois . "," . $counter;

        print_r($counter);

        // Verrouiller le fichier en mode exclusif
        file_put_contents($filename, $line, LOCK_EX);

        return array(
                'counter' => $counter,
                'date' => $mois,            
            );
    }

?>