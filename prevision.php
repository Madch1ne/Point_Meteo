<?php
	declare(strict_types = 1);
	$title ='Prévisions Météorologiques - Point Météo';
	$description ='';
		require("includes/header.inc.php");
		require("includes/weather_api.php");

		// Récupération de la ville et de la région depuis l'URL (avec des valeurs par défaut)

		 $ville = isset($_GET['ville']) ? ucfirst(strtolower($_GET['ville'])) : 'Paris'; //git Si la variable existe, on la transforme en minuscule
		 $region = isset($_GET['region']) ? ucfirst(strtolower($_GET['region'])) : 'île-de-france';
		//  $ville = $_GET['ville'] ?? 'paris';
		//  $region = $_GET['region'] ?? 'île-de-france';
		 
		// Cookie pour stocker la dernière ville consultée et la date de consultation
			$cookieValue = json_encode([
				'ville' => $ville,
				'date' => date("Y-m-d H:i:s")
			]);

			// le cookie pour 30 jours 
			setcookie('lastCity', $cookieValue, time() + (86400 * 30), "/");

		 visitVille($ville) ;
		//  $ville =ucfirst(strtolower('tOuRs'));
		 // Récupération des données météo depuis l'API
		 $weatherData = prevision($ville);
?>
    <main>
        <div class="container">
            <div class="page-header">
                 <a href="carte.php" class="back-button"> <!-- il faut voir le lien ici avec la page accueil -->
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1>Prévisions Météo</h1>
            </div>
								
            <div class="current-weather card">
                <div class="weather-header">              <!-- a changer en prod -->
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
							<label>Humidité</label>
                            <p class="detail-value"><?php echo isset($weatherData['current']['humidity']) ? $weatherData['current']['humidity'] : '10'; ?>%</p>
                        </div>
                    </div>
                    <div class="weather-detail">
                        <i class="fas fa-wind"></i>
                        <div>
                            <label>Vent</label>
                            <p class="detail-value"><?php echo isset($weatherData['current']['wind']) ? $weatherData['current']['wind'] : '10'; ?> km/h</p>
                        </div>
                    </div>
                    <div class="weather-detail">
                        <i class="fas fa-sun"></i>
                        <div>
                            <label>Levé du soleil</label>
                            <p class="detail-value"><?php echo isset($weatherData['current']['rise']) ? $weatherData['current']['rise'] : '10'; ?></p>
                        </div>
                    </div>
					<div class="weather-detail">
                        <i class="far fa-sun"></i>
                        <div>
                            <label>Couché du soleil</label>
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
					<a id="day" class="tab-btn" href="#daily">Prévisions 4 jours</a>
					<a class="tab-btn" href="#hourly">Prévisions horaires</a>
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