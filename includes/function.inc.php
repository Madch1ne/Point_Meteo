<?php
declare(strict_types = 1);


//*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*ICI COMMENCE LES FONCTIONS DU PROJET WEB*_*_*_*_*_*_*_*_*_*__*_*_*_*_*/

    /**
     * Lit un fichier du cache.
     *
     * @param string $key       le nom de fichier sans extension(sera la clé unique ).
     * @param int    $seconds   Durée de vie du cache (en secondes).
     * @return mixed            Le contenu décodé du JSON, ou false si absent/périmé.
     */
        function cache_read(string $key, int $seconds) {
            $file = "./util/cache/{$key}.json";
            if (!is_file($file)) {
                return false;
            }
            if (filemtime($file) < time() - $seconds) {
                return false;
            }
            $json = file_get_contents($file);
            return json_decode($json, true);
        }

    /**
     * Écrit du contenu dans le cache JSON.
     *
     * @param string $key   clé unique (nom de fichier).
     * @param mixed  $data  Données à encoder en JSON.
     * @return void
     */
        function cache_write(string $key, $data): void {
            $file ="./util/cache/{$key}.json";
            file_put_contents($file, json_encode($data), LOCK_EX);
        }

        
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
        
        function getApodData(string $apiKey, string $date): array {
            $key    = 'apod_' . $date;
            $cached = cache_read($key, 86400); // cache 24h
            if ($cached !== false) {
                return $cached;
            }
        
            $url  = "https://api.nasa.gov/planetary/apod?api_key={$apiKey}&date={$date}";
            $json = @file_get_contents($url);
            
            //lecture du cahe, si existant
            if ($json === false) {
                $old = cache_read($key, PHP_INT_MAX);
                if ($old !== false) {
                    return $old;
                }
                return ["error" => "Erreur lors de la récupération des données APOD."];
            }
        
            // Décodage du JSON en tableau associatif
            $data = json_decode($json, true);
            if (!is_array($data)) {   
                $old = cache_read($key, PHP_INT_MAX);
                if ($old !== false) {
                    return $old;
                }
                return ["error" => "Données APOD JSON invalides."];
            }
        
            // gestion des type de media
            if (($data['media_type'] ?? '') === 'video') {
                //  Pour une vidéo
                $media = '<iframe width="560" height="315" src="'. $data['url'] . '" frameborder="0" allowfullscreen></iframe>';
            } else {
                //  Pour une image 
                $media = '<img src="' .$data['url'] . '" alt="APOD" style="width:100%;"   />';
            }
        
            $result = [
                "media"       => $media,
                "explanation" => $data['explanation']
            ];
        
            //mise en cache
            cache_write($key, $result);
            return $result;
        }
        
        /**
         * Récupère les informations de géolocalisation au format XML depuis GeoPlugin.
         *
         * Cette fonction interroge l'API GeoPlugin en XML pour l'adresse IP fournie,
         * pour donner un tableau associatif contenant :
         *   - IP, continent, pays, ville, région,...
         * En cas d'échec, elle retourne un tableau avec la clé "error".
         *
         * @param string $geokey la clé d'authentification GeoPlugin.
         * @param string $ip     l'adresse IP à géolocaliser.
         * @return array le tableau associatif 
         *             
         */ 
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
        /**
         * Récupère les informations de géolocalisation via l’API ipinfo.io (format JSON).
         *
         * Cette fonction interroge l'API de ipinfo( https://ipinfo.io/{IP}/geo ) pour obtenir les données
         * de localisation (pays, région, ville, code postal, etc.) associées à une adresse IP.
         *
         * @param string $ip Adresse IP à géolocaliser.
         * @return array Tableau associatif 
         * 
         * 
         */

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
        /**
         * Récupère les informations de géolocalisation via l’API WhatIsMyIP (format XML).
         *
         * https://api.whatismyip.com/ip-address-lookup.php avec clé et IP
         * pour obtenir un flux XML contenant des données sur l’IP, l’ISP, la ville, le pays, etc.
         *
         * @param string $key  Clé API fournie par WhatIsMyIP.
         * @param string $Wip  Adresse IP à interroger.
         * @return array Tableau associatif
         * 
         */
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