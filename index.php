<?php
declare(strict_types = 1);
$title ='Accueil - Point Météo';
	$description ='Cette page affiche les prévisions météo actuelles et horaires pour les villes selectionnées.';
		require("includes/header.inc.php");
		require("includes/weather_api.php");

$randomImage = images();
?>
<main>
    <section class="container main-content">
        <article class="grid-layout">
            
            <div class="welcome-section card">
                <div class="slider">
                    <!-- Image qui changera toutes les 15 secondes -->
                    <img id="sliderImage" src="<?php echo $randomImage; ?>" alt="Image aléatoire"/>
                    
                    <div class="card-overlay">
                        <h2>Bienvenue sur Point Météo</h2>
                        <p>
                            Consultez les prévisions météorologiques pour toutes les régions de France.
                            Utilisez notre carte interactive pour recherchez votre ville et obtenir des prévisions détaillées.
                        </p>
                        <div class="button-group">
                            <a href="carte.php" class="btn btn-primary">Aller sur la carte Interactive</a>
                            <a href="statistics.php" class="btn btn-outline">Consulter les Statistiques</a>
                        </div>
                    </div>
                </div>
            </div>
             
        </article>
    </section>
    <section class="container">

        <article class="grid-layout">
            <div class="welcome-section card">
                <h2>À propos de notre site </h2>
                <p>
                    Notre plateforme fournit des données météorologiques précises et actualisées pour toutes les régions de France.
                    Grâce à notre interface intuitive, trouvez facilement les prévisions détaillées pour vous aider à planifier vos activités au quotidien en toute sérénité.
                </p>
                    
            </div>
       
            <div class="welcome-section card">
                <h2>En savoir plus sur notre service météo</h2>
                <p>
                    Avec des outils avancés et une équipe dévouée, nous mettons à votre disposition les dernières informations météo
                    pour vous aider à préparer votre journée. Explorez notre site et profitez d'une expérience utilisateur optimisée.
                </p>
            </div>
        </article>
    </section>
</main>

<?php
require("includes/footer.inc.php");
?>
