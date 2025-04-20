<?php
	declare(strict_types = 1);
    $lang  = isset($_GET['lang']) ? $_GET['lang'] : 'fr';
	$title ='Prévisions Météorologiques - Point Météo';
	$description ='Cette affiche les prévisions météo actuelles et horaires pour la ville choisie';
        require("includes/function.inc.php");
		require("includes/header.inc.php");
		require("includes/weather_api.php");
         

        // Pour la Ville
        if (!empty($_GET['ville'])) {
            $ville = ucfirst(strtolower($_GET['ville']));
        }
        elseif (isset($_COOKIE['lastCity'])) {
            $last   = json_decode($_COOKIE['lastCity'], true);
            $ville  = ucfirst(strtolower($last['ville'])) ?? '';
        }
        else {
            $geokey = 'cbf9e49b-7461-4ae9-a349-91f6e70bd452'; 
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
            $geo = getGeoPData($geokey, $ip);
            $ville = ucfirst(strtolower($geo['ville'])) ?? '';
        }
        if (empty($ville)) {
            $ville = 'Paris';
        }
        
        // Pour la Région
        if (!empty($_GET['region'])) {
            $region = ucfirst(strtolower($_GET['region']));
        }
        elseif (isset($last['region'])) {
            $region = ucfirst(strtolower($last['region']));
        }
        else {
            // getGeoPData renvoie 'region'
            $region = isset($geo) ? ucfirst(strtolower($geo['region'])) : '';
        }
        if (empty($region)) {
            $region = 'Île-de-France';
        }
        
        // 3) Enregistrer le cookie lastCity
        $cookieValue = json_encode([
            'ville'  => $ville,
            'region' => $region,
            'date'   => date("Y-m-d H:i:s")
        ]);
        setcookie('lastCity', $cookieValue, time() + 86400 * 30, '/');
        
        //sauvegarde de la ville 
        visitVille($ville);
		
		 // Récupération des données météo depuis l'API
		 $weatherData = prevision($ville);
?>
    <main>
        <div class="container">
            <div class="page-header">
                 <a href="carte.php" class="back-button"> <!-- il faut voir le lien ici avec la page accueil -->
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1><?= $lang === 'fr' ? 'Prévisions Météo' : 'Weather Forecast' ?></h1>
            </div>
								
            <div class="current-weather card">
                <div class="weather-header">              
                    <div>								<!-- ucfirst pour métre la premiere lettre en majiscule -->
                        <h2><?php echo htmlspecialchars(ucfirst(strtolower($ville))); ?></h2> 
                        <p><?php echo htmlspecialchars(ucfirst(strtolower($region))); ?>, France</p>
                    </div>
                    <div class="current-temp">
                        <span><?php echo isset($weatherData['current']['temp']) ? round($weatherData['current']['temp']) : '18'; ?>°C</span>
                        <img src="<?php echo $weatherData['current']['icon'] ?? 'Cloudy windy rainy'; ?>"/>
                    </div>
                </div>
                <div class="weather-details">
                    <div class="weather-detail">
                        <i class="fas fa-tint"></i>
                        <div>
							<label><?= $lang === 'fr' ? 'Humidité' : 'Humidity' ?></label>
                            <p class="detail-value"><?php echo isset($weatherData['current']['humidity']) ? $weatherData['current']['humidity'] : '10'; ?>%</p>
                        </div>
                    </div>
                    <div class="weather-detail">
                        <i class="fas fa-wind"></i>
                        <div>
                            <label><?= $lang === 'fr' ? 'Vent' : 'Wind' ?></label>
                            <p class="detail-value"><?php echo isset($weatherData['current']['wind']) ? $weatherData['current']['wind'] : '10'; ?> km/h</p>
                        </div>
                    </div>
                    <div class="weather-detail">
                        <i class="fas fa-sun"></i>
                        <div>
                            <label><?= $lang === 'fr' ? 'Levé du soleil' : 'Sunrise' ?></label>
                            <p class="detail-value"><?php echo isset($weatherData['current']['rise']) ? $weatherData['current']['rise'] : '10'; ?></p>
                        </div>
                    </div>
					<div class="weather-detail">
                        <i class="far fa-sun"></i>
                        <div>
                            <label><?= $lang === 'fr' ? 'Couché du soleil' : 'Sunset' ?></label>
                            <p class="detail-value"><?php echo isset($weatherData['current']['set']) ? $weatherData['current']['set'] : '10'; ?></p>
                        </div>
                    </div>
                    <div class="weather-detail">
                       
                        <div>
                           
                            <p class="detail-value-cond"><?php echo isset($weatherData['current']['condition']) ? $weatherData['current']['condition'] : 'windy Cloudy snowy'; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="prevision-tabs">
                <div class="tab-header">
					<a id="day" class="tab-btn" href="#daily"><?= $lang === 'fr' ? 'Prévisions 4 jours' : '4 days Forecast' ?></a>
					<a class="tab-btn" href="#hourly"><?= $lang === 'fr' ? 'Prévisions horaires' : 'Hourly Forecast' ?></a>
                </div>
                
                <div class="tab-content">
                    <div id="daily" class="tab-pane">
                        <div class="daily-prevision">
                            <?php
                            
								$daily = $weatherData['daily'];
								foreach ($daily as $day) {
									echo '<div class="prevision-card">';
									echo '<div class="prevision-day">' . $day['day'] . '</div>';
									echo '<img src="'. $day['icon'] .'"/>';
									echo '<div class="prevision-temp">' . $day['tempMin'] . '°C</div>';
									echo '<div class="prevision-temp">' . $day['tempMax'] . '°C</div>';
									echo '<div class="prevision-condition">' . $day['condition'] . '</div>';
									echo '</div>';
								}
                            ?>
                        </div>
                    </div>

                    
                    <div id="hourly" class="collapse collapse-horizontal tab-pane">
                        <div class="hourly-prevision">
                            <?php
								$hourly = $weatherData['hourly'];
								foreach($hourly as $hour => $hourData){
									echo '<div class="prevision-card">';
										echo '<div class="prevision-hour">' . $hour . '</div>';
										echo '<img src="'. $hourData['ICON'] .'"/>';
										echo '<div class="prevision-temp">' . $hourData['TMP2m'] . '°C</div>';
										echo '<div class="prevision-condition">' . $hourData['CONDITION'] . '</div>';
									echo '</div>';
								}                    
                            ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </main>


<?php require("includes/footer.inc.php"); ?>