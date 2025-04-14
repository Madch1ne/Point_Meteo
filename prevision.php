<?php
    declare(strict_types = 1);
    $title ='Prévisions Météorologiques - Point Météo';
    $description ='';
    require("includes/header.inc.php");
    require("includes/weather_api.php");

    // Récupération des paramètres d'URL
    $ville = isset($_GET['ville']) ? $_GET['ville'] : 'Paris';
    $region = isset($_GET['region']) ? $_GET['region'] : 'Île-de-France';

    // Normalisation du nom de la ville (première lettre en majuscule, reste en minuscule)
    $ville = ucfirst(strtolower($ville));
     
    // Enregistrement de la visite pour cette ville
    visitVille($ville);
     
    // Récupération des données météo depuis l'API
    $weatherData = prevision($ville);
?>
    <main>
        <div class="container">
            <div class="page-header">
                 <a href="carte.php" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1>Prévisions Météo</h1>
            </div>
                                
            <div class="current-weather card">
                <div class="weather-header">
                    <div>
                        <h2><?php echo htmlspecialchars($ville); ?></h2> 
                        <p><?php echo htmlspecialchars($region); ?>, France</p>
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

<?php require ("includes/footer.inc.php"); ?>