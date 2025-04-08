<?php
declare(strict_types = 1);
    
    // Définition des constantes pour la dimension par défaut
define("DEFAULT_ROWS", 10);
define("DEFAULT_COLS", 10);


/**
 * Fonction qui génère un tableau HTML de multiplication
 *
 * @param int $rows Nombre de lignes (par défaut DEFAULT_ROWS)
 * @param int $cols Nombre de colonnes (par défaut DEFAULT_COLS)
 * @return string Retourne une chaîne HTML contenant la table de multiplication
 */
function multiTable(int $rows = DEFAULT_ROWS, int $cols = DEFAULT_COLS): string {
    $table = "<table style='border-collapse: collapse;'>";
    $table .= "<caption>Table de multiplication {$rows} × {$cols}</caption>";
    $table .= "<thead>
                <tr>
                <th scope='col'>X</th>";

    // Entête des colonnes
    for ($col = 1; $col <= $cols; $col++) {
        $table .= "<th scope='col'>$col</th>";
    }
    $table .= "</tr>
            </thead>
            <tbody>";

    // Contenu du tableau
    for ($row = 1; $row <= $rows; $row++) {
        $table .= "<tr>
                  <th scope='row'>$row</th>"; // Première colonne (indice de ligne)
        for ($col = 1; $col <= $cols; $col++) {
            $table .= "<td>" . ($row * $col) . "</td>";
        }
        $table .= "</tr>";
    }

    $table .= "</tbody>
              </table>";
    return $table;
}  


/**
 * Convertit une couleur RGB en format hexadécimal.
 *
 * @param int $r Composante rouge (0-255)
 * @param int $g Composante verte (0-255)
 * @param int $b Composante bleue (0-255)
 * @return string Couleur hexadécimale sous la forme #RRGGBB
 */
function rgbToHex(int $r, int $g, int $b): string {
    if ($r < 0 || $r > 255 || $g < 0 || $g > 255 || $b < 0 || $b > 255) {
        return "ERROR : Les valeurs RGB doivent être comprises entre 0 et 255.";
    }

    return sprintf("#%02X%02X%02X", $r, $g, $b);
}

/**
 * Convertit une couleur hexadécimale en ses composantes RGB.
 *
 * @param string $hex Couleur hexadécimale (#RRGGBB ou #RGB)
 * @return bool Retourne true si la conversion réussit, sinon false.
 */
function hexToRgb(string $hex, int &$r, int &$g, int &$b): bool {
    $hex = ltrim($hex, '#'); // pour supprimmer le # devant...
    
    //On verifie la longueur pour convertire (3 caracteres 0F8 en 6 00FF88)
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }

    if (strlen($hex) !== 6) {
        return false;  // si ce n'est pas 6 caractères 
    }

    list($r, $g, $b) = sscanf($hex, "%02x%02x%02x"); // On formate les données comme voulu %02x : deux chiffres hexa - converti en decimal

    return true;
}


/**
 * Convertit un nombre en chiffres romains en son équivalent décimal.
 *
 * @param string $roman Chiffres romains à convertir.
 * @return int Valeur décimale correspondante ou -1 si entrée invalide.
 */
function romanToDecimal(string $roman): string {
    // Tableau des valeurs romaines
    $romanValues = [
        'I' => 1, 'V' => 5, 'X' => 10, 'L' => 50,
        'C' => 100, 'D' => 500, 'M' => 1000
    ];

    // Convertir en majuscules pour être insensible à la casse
    $roman = strtoupper($roman);
    $length = strlen($roman);
    $total = 0;
    $previousValue = 0;

    // Parcourir le nombre romain de droite à gauche
    for ($i = $length - 1; $i >= 0; $i--) {
        $currentChar = $roman[$i];

        // Vérifier si le caractère est valide
        if (!isset($romanValues[$currentChar])) {
            return "ERROR : chiffre romain invalide."; // Entrée invalide
        }

        $currentValue = $romanValues[$currentChar];

        // Si la valeur actuelle est inférieure à la précédente, on soustrait
        if ($currentValue < $previousValue) {
            $total -= $currentValue;
        } else {
            // Sinon, on ajoute
            $total += $currentValue;
        }

        // Mettre à jour la valeur précédente
        $previousValue = $currentValue;
    }

    return (string)$total;
}

/**
 * Génère un tableau HTML affichant la table ASCII (caractères de 32 à 127)
 *
 * @return string Tableau HTML formaté.
 */
function asciiTable(): string {
    $table = "<table class='ascii-table'>";
    $table .= "<caption>Table ASCII (32-127)</caption>";
    $table .= "<thead>
                    <tr>
                    <th></th>";

    // En-tête des colonnes (0-F en hexadécimal)
    for ($col = 0; $col < 16; $col++) {
        $table .= "<th>" . strtoupper(dechex($col)) . "</th>";
    }
    $table .= "</tr>
               </thead>
               <tbody>";

    // Génération du tableau ASCII
    for ($row = 2; $row < 8; $row++) { // On commence à 32 (0x20 = 32, 2 en hex)
        $table .= "<tr><th>" . strtoupper(dechex($row)) . "</th>";
        for ($col = 0; $col < 16; $col++) {
            $charCode = ($row * 16) + $col;
            if ($charCode > 127) break; // Limite 128 max

            // Remplacement des caractères spéciaux HTML
            $char = chr($charCode);
            if ($char === '<') $char = '&lt;';
            elseif ($char === '>') $char = '&gt;';
            elseif ($char === '&') $char = '&amp;';
            elseif ($charCode === 127) $char = '&#x00A0;'; // 0x7F

            // Détermination de la classe CSS (chiffres, majuscules, minuscules)
            $class = "";
            if ($char >= '0' && $char <= '9') $class = "number";
            elseif ($char >= 'A' && $char <= 'Z') $class = "uppercase";
            elseif ($char >= 'a' && $char <= 'z') $class = "lowercase";

            $table .= "<td class='$class'>$char</td>";
        }
        $table .= "</tr>";
    }

    $table .= "</tbody></table>";
    return $table;
}

//*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*ICI COMMENCE LES FONCTIONS DU TD5*_*_*_*_*_*_*_*_*_*__*_*_*_*_*/

   /**
 * Crée une liste HTML non ordonnée avec 20 éléments.
 * Chaque élément contient "hello numéro i".
 *
 * @return string La liste HTML générée.
 */
function constructlist() : string {
    $list = "<ul>\n";
    for ($i = 1; $i <= 20; $i++) {
        $list = $list."\t<li>hello numéro" .$i."</li>\n";
    }
    $list = $list."</ul>\n";
    return $list;
}

/**
 * Effectue des conversions entre hexadécimal, décimal et ASCII.
 * Affiche les résultats sous forme de liste HTML pour 'A' et '+'.
 *
 * @return void Cette fonction ne retourne rien, elle affiche directement le résultat.
 */
function convert() : void {
    echo"<ul>";
    
    // Conversion pour 'A'
    $hexa ="0x41";
    $convdec = hexdec($hexa);
    $convasc = chr($convdec);
    echo "<li> $hexa = $convdec = '$convasc'</li>";
    $convAsdec = ord($convasc);
    $convDehex = dechex($convAsdec);
    echo "<li> '$convasc' = $convAsdec = 0x$convDehex </li>";
    echo "</ul>";

    // Conversion pour '+'
    echo"<ul>";
    $hexa ="0x2B";
    $convdec = hexdec($hexa);
    $convasc = chr($convdec);
    echo "<li> $hexa = $convdec = '$convasc'</li>";
    $convAsdec = ord($convasc);
    $convDehex = strtoupper(dechex($convAsdec));
    echo "<li>'$convasc' = $convAsdec = 0x$convDehex </li>";
    echo "</ul>";
}

/**
 * Crée une liste HTML non ordonnée avec les chiffres hexadécimaux de 0 à F.
 * Les chiffres sont affichés en majuscules.
 *
 * @return string La liste HTML générée.
 */
function constructlist2() : string {
    $list = "<ul class='hex-list'>\n";
    for ($i = 0; $i <= 15; $i++) {
        $convhexa = dechex($i);
        $list .= "\t<li>".strtoupper($convhexa)."</li>\n";
    }
    $list = $list."</ul>\n";
    return $list;
}

/**
 * Crée une table HTML affichant les nombres de 0 à 17 dans différentes bases : binaire, octal, décimal, hexadécimal.
 * La table inclut une légende et un en-tête.
 *
 * @return string La table HTML générée.
 */
function creatable() : string {
    $table = "<table style='border-collapse: collapse;'>\n";
    $table .= "<caption>Illustration: Conversion bases 2,8,16</caption>";
    $table .= "<thead>
                  <tr>
                    <th>Binaire</th>
                    <th>Octal</th>
                    <th>Décimal</th>
                    <th>Hexadécimal</th>
                  </tr>
                 </thead>\n";
    
    $table .= "<tbody>\n";
    for ($i = 0; $i <= 17; $i++) {
        $decimal = sprintf("%02d",$i);
        $binaire = sprintf("%08b", $i);
        $octal = sprintf("%02o", $i);
        $hexa = sprintf("%02X", $i);
        $table .= "<tr>
                        <td>$binaire</td>
                        <td>$octal</td>
                        <td>$decimal</td>
                        <td>$hexa</td>
                     </tr>\n";
    }
    $table .= "</tbody>";
    $table .= "</table>";
    return $table;
}

//*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*ICI COMMENCE LES FONCTIONS DU TD7*_*_*_*_*_*_*_*_*_*__*_*_*_*_*/

   /**
     * Génère une liste HTML des regions de France sous forme de liste à puce(ul) ou numeroté(ol)
     * 
     * @param array $regions Tableau des regions de France.
     * 
     * @param string $listType le type de liste avec (ul) comme liste par défaut.
     * 
     * @return string liste HTML formaté.
     */
    function region(string $listType ='ul') : string {
        $regions =["Guadeloupe", "Martinique", "Guyane", "La Réunion", "Mayotte", "Île-de-France",
                   "Centre-Val de Loire", "Bourgogne-Franche-Comté", "Normandie", "Hauts-de-France",
                   "Grand Est", "Pays de la Loire", "Bretagne", "Nouvelle-Aquitaine", "Occitanie", 
                   "Auvergne-Rhône-Alpes", "Provence-Alpes-Côte d’Azur", "Corse"];

        //verification du type de liste
        $listType = ($listType === 'ol') ? 'ol' : 'ul';

        $list = "<$listType>\n";

        foreach ($regions as $region){
            $list = $list.
                   "<li>".$region."</li>\n";
        }
        $list = $list."</$listType>\n";

        return $list;
    }
  
   /**
     * Obtient les origines étymologiques du jour et du mois actuels.
     *
     * @param array $jours Tableau associatif des jours de la semaine et leur origine étymologique
     * 
     * @param array $mois Tableau associatif des mois de l'année et leur origine étymologique
     * 
     * @return array Tableau contenant l'origine du jour et du mois.
     */

     function dateOrigin() : array {
        $days = ["monday" => "Lune",
                  "tuesday" => "Mars",
                  "wednesday" => "Mercure",
                  "thursday" => "Jupiter",
                  "friday" => "Vénus",
                  "saturday" => "Saturne",
                  "sunday" => "Soleil"];

      
        $months = [
            1 => "Janus (dieu romain des commencements)",
            2 => "Februa (fête de purification romaine)",
            3 => "Mars (dieu de la guerre)",
            4 => "Apru (nom étrusque de Vénus)",
            5 => "Maia (déesse romaine de la fertilité)",
            6 => "Junon (déesse protectrice des femmes)",
            7 => "Jules César (réformateur du calendrier)",
            8 => "Auguste (empereur romain)",
            9 => "Septem (septième mois du calendrier romain)",
            10 => "Octo (huitième mois du calendrier romain)",
            11 => "Novem (neuvième mois du calendrier romain)",
            12 => "Decem (dixième mois du calendrier romain)"];

            // Récupérer la date actuelle
            $date = new DateTime();
            $day = strtolower($date->format('l')); // Nom du jour en minuscule
            //$jour = strtolower($date('l'));
            $monthNum = (int) date('n'); // Numéro du mois (1 à 12)
         

        // Vérifier si les clés existent
        $dayorigin = $days[$day] ?? "Inconnu";
        $monthorigin = $months[$monthNum] ?? "Inconnu";

        return ["day" => $dayorigin, "month" => $monthorigin];
    }

   /**
     * Fonction pour récupérer le navigateur de l'utilisateur.
     *
     * @return string Nom du navigateur détecté.
     */
    function get_navigateur(string $type="") : string {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        
        if($type == "format"){ 
            if (strpos($userAgent, 'Firefox') !== false) {
                return "Mozilla Firefox";
            } elseif (strpos($userAgent, 'Chrome') !== false && strpos($userAgent, 'Edg') === false) {
                return "Google Chrome";
            } elseif (strpos($userAgent, 'Edg') !== false) {
                return "Microsoft Edge";
            } elseif (strpos($userAgent, 'Safari') !== false && strpos($userAgent, 'Chrome') === false) {
                return "Apple Safari";
            } elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
                return "Opera";
            } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident/') !== false) {
                return "Internet Explorer";
            }
        }

        return $userAgent;
        
    }

//*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*ICI COMMENCE LES FONCTIONS DU TD8*_*_*_*_*_*_*_*_*_*__*_*_*_*_*/

// define("currentUrl", $_SERVER['HTTP_USER_AGENT']);
 
   /**
     * Analyse une URL et en extrait plusieurs informations :
     *  - protocole (http, https)
     *  - host complet (ex. www.cyu.fr)
     *  - domaine (ex. cyu)
     *  - sous-domaine (ex. www, ou vide si absent)
     *  - TLD (avec description, ex. "France" pour "fr")
     *  
     * Si aucune URL n'est fournie, la fonction reconstruit l'URL actuelle à partir de $_SERVER.
     *
     * @param string $url L'URL à analyser. (Optionnel)
     * @return array Tableau associatif contenant les clés: protocol, host, domain, subdomain, tld, ip.
     */
    function infoUrl(string $url ="") : array {
        $currentUrl = $_SERVER['HTTP_REFERER'];

        if( $url == ""){
            $url = $currentUrl;
        }
            // Tableau associatif pour formater les TLD valid
            $tldMap = ["com" => "commercial",
                        "org" => "Organization",
                        "net" => "Network",
                        "fr" => "France"];
        
            // On parse_url pour découper l'URL
            $parsedUrl = parse_url($url);
        
            if (!$parsedUrl || !isset($parsedUrl['host']) || !isset($parsedUrl['scheme'])) {
                return []; // Retourne [vide] si l'URL n'est pas valide
            }
        
            // On fait la séparation de l'hôte
            $hostParts = explode('.', $parsedUrl['host']); 
        
            //******** Extraction des éléments *******
            $tld = $hostParts[2];
            $domain = $hostParts[1];
            $subdomain = $hostParts[0];
        
            // On vérifi le TLD dans le tableau associatif
            $tldDescription = isset($tldMap[$tld]) ? $tldMap[$tld] : "Inconnu";
        
            // Retour du résultat sous forme de tableau associatif
            return [
                "protocol" => $parsedUrl['scheme'],
                "host" => $currentUrl,
                "domain"   => $domain,
                "subdomain"=> $subdomain,
                "tld"      => $tldDescription
            ];
    }

   /**
     * Convertit une valeur octale chmod (000-777) en représentation textuelle (rwx).
     *
     * @param int $octal Valeur octale des permissions (000 à 777).
     * @return string Représentation des permissions en "rwx rwx rwx".
     */
    function chmodLike(int $octal): string {
                // Vérifier que le nombre est bien compris entre 000 et 777
            if ($octal < 0 || $octal > 777) {
                return "Valeur octale invalide";
            }

            // Tableau associatif pour convertir chaque chiffre octal en "rwx"
            $permissionsMap = [
                0 => "---",
                1 => "--x",
                2 => "-w-",
                3 => "-wx",
                4 => "r--",
                5 => "r-x",
                6 => "rw-",
                7 => "rwx"
            ];

            $octalStr = (string)$octal; 

            // Extraire chaque chiffre et convertir en texte
            $owner = $permissionsMap[$octalStr[0]];
            $group = $permissionsMap[$octalStr[1]];
            $others = $permissionsMap[$octalStr[2]];

            // Retourner le format "rwx rwx rwx"
            return "$owner $group $others";
    }


//*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*ICI COMMENCE LES FONCTIONS DU PROJET WEB*_*_*_*_*_*_*_*_*_*__*_*_*_*_*/
        
   /**
     * Récupère les données de l'API APOD de la NASA (JSON).
     *
     * La fonction effectue une requête GET sur l'API APOD et retourne un tableau associatif contenant
     * soit le média (balise <img> ou <iframe> selon le type de média), soit un message d'erreur en cas d'échec.
     *
     * @param string $apiKey Clé API pour accéder à l'API APOD.
     * @param string $date   La date du jour pour récupérer les données.
     * @return array         Tableau associatif avec "media" et "explanation", ou une "error" en cas de problème.
     */
        function getApodData($apiKey, $date) : array {
            $url = "https://api.nasa.gov/planetary/apod?api_key={$apiKey}&date={$date}";
            
            // recuperation et verification si contenu ou non 
            $json = file_get_contents($url);
            if ($json === false) {
                return ["error" => "Erreur lors de la récupération des données APOD."];
            }

            // Décodage du JSON en tableau associatif
            $data = json_decode($json, true);
            if (!$data){
                return ["error" => "Erreur lors de la récupération des données APOD."];
            }

            // gestion des type de media
            if ($data['media_type'] === 'video'){ 
                    //  Pour une vidéo, on peut utiliser une balise <iframe> 
                    $media = '<iframe width="560" height="315" src="'.$data['url'].'" frameborder="0" allowfullscreen></iframe>';
                }else {
                    // Pour une image 
                    $media = '<img src="'. $data['url'] .'" alt="APOD" style="width: 100%;">';
                }
            
            $text = $data['explanation'];
                
                // tableau associatif contenant média et l'explication
            return array(
                "media" => $media,
                "explanation" => $text
                    );
        }
        
        
        // Fonction pour récupérer les données de geoplugin (XML) 
        function getGeoPData($geokey,$ip) : array {
            $url = "http://www.geoplugin.net/xml.gp?ip={$ip}&auth={$geokey}";
            
            //verification du contenu
            $xml = file_get_contents($url);
            if ($xml === false) {
                return ["error" => "Erreur lors de la récupération des données de géolocalisation."];
            }

            //Decodage du contenu XML 
            $doc = simplexml_load_string($xml);
            if(!$doc){
                return ["error" => "Erreur lors de la récupération des données de géolocalisation."];
            }
            // print_r($doc);
            return array(
                "IP" => (string)$doc->geoplugin_request,      //en xml on accède aux donnée differement ce ne sont pas des attributs
                "continent" =>  (string)$doc->geoplugin_continentName,
                "continentCode" => (string)$doc->geoplugin_continentCode,
                "pays" => (string)$doc->geoplugin_countryName,
                "paysCode" => (string)$doc->geoplugin_countryCode,
                "ville" =>  (string)$doc->geoplugin_city,
                "region" => (string)$doc->geoplugin_region,
                "regionCode" => (string)$doc->geoplugin_regionCode,
                "postCode" => (string)$doc->geoplugin_postal_code,
                "latitude" =>  (string)$doc->geoplugin_latitude,
                "longitude" => (string)$doc->geoplugin_longitude
                );
        }
        
        // Fonction pour récupérer les données de ipinfo (Json)
        function getGeoIData($ip) : array {
            $url = "https://ipinfo.io/" . urlencode($ip) . "/geo";
            
            //verification du contenu
            $json = file_get_contents($url);
            if ($json === false) {
                return ["error" => "Erreur lors de la récupération des données de géolocalisation."];
            }

            //Decodage du contenu json 
            $data = json_decode($json, true);
            if(!$data){
                return ["error" => "Erreur lors de la récupération des données de géolocalisation."];
            }
            //print_r($data);
            return array(
                "IP" => $data['ip'],      
                "Hote" => $data['hostname'],
                "paysCode" => $data['country'] ,
                "ville" => $data['city']  ,
                "region" => $data['region'] ,
                "loc" => $data['loc'],
                "postCode" => $data['postal'],
                "time" => $data['timezone']
                );
        }

        // Fonction pour récupérer les données de whatsmyip : 36d7bf6d3ef04cdea4953d1fea19de1c (XML) 
        function getGeoWData($key,$Wip): array {
            $url = "https://api.whatismyip.com/ip-address-lookup.php?key={$key}&input={$Wip}&output=xml";
                
            //verification du contenu
            $xml = file_get_contents($url);
            if ($xml === false) {
                return ["error" => "Erreur lors de la récupération des données de géolocalisation. 1"];
            }

            //Decodage du contenu XML 
            $doc = simplexml_load_string($xml);
            //   print_r($doc);
            //   print_r($url);
        
            if(!$doc){
                return ["error" => "Erreur lors de la récupération des données de géolocalisation.2"];
            }
            
            return array(
                "IP" => (string)$doc->server_data->ip,      //en xml on accède aux donnée differement ce ne sont pas des attributs
                "hote" =>  (string)$doc->server_data->isp,
                "paysCode" => (string)$doc->server_data->country,
                "ville" =>  (string)$doc->server_data->city,
                "region" => (string)$doc->server_data->region,
                "postCode" => (string)$doc->server_data->postalcode,
                "latitude" =>  (string)$doc->server_data->latitude,
                "longitude" => (string)$doc->server_data->longitude,
                "time" => (string)$doc->server_data->time
                );
        }
    
        
?>