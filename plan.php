<?php
declare(strict_types = 1);
    $lang  = isset($_GET['lang']) ? $_GET['lang'] : 'fr';
	$title ='Plan du site - Point Météo';
	$description ='Cette page affiche le plan du site';
		require("includes/header.inc.php");
		
         
?>
    <main>
        <section class="container card">
                <h1>Plan du site</h1>
                <p>Retrouvez ci-dessous la structure complète de notre site web pour faciliter votre navigation.</p>
                
                <article class="grid-layout">
                    <div>
                        <h2><i class="fas fa-home"></i> Pages principales</h2>
                        <ul>
                            <li>
                                <a href="index.php">Accueil</a>
                                <p>Page d'accueil présentant les fonctionnalités du site</p>
                            </li>
                            <li>
                                <a href="prevision.php">Prévisions</a>
                                <p>Consultez les prévisions météorologiques détaillées</p>
    
                            </li>
                            <li>
                                <a href="carte.php">Carte interactive</a>
                                <p>Explorez la météo par région sur notre carte interactive de la France</p>
                            </li>
                            <li>
                                <a href="statistics.php">Statistiques</a>
                                <p>Consultez les statistiques météorologiques et les tendances</p>
                                
                            </li>
                        </ul>
                    </div>
                    
                    <div class="sitemap-category">
                        <h2><i class="fas fa-info-circle"></i> Informations</h2>
                        <ul>
                            <li>
                                <a href="about.php">À propos</a>
                                <p>En savoir plus sur notre service météorologique</p>
                            </li>
                        </ul>
                    </div>
                    
                </article>
               
            
        </section>
    </main>
<?php 
require("includes/footer.inc.php");
?>