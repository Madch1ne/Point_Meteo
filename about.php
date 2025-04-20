<?php
declare(strict_types=1);

$title = 'À propos - Point Météo';
$description = 'Présentation du projet Point Météo, réalisé dans le cadre universitaire.';
require("includes/header.inc.php");

?>
<main>
  <section class="container main-content">
     <h1>À propos</h1>
        <article class="container card">
            <p>
            <strong>Point Météo</strong> est un projet développé dans le cadre de notre cursus universitaire, en binôme.
            Nous avons consacré environ un mois de travail intensif pour concevoir et mettre en place cette application web.
            </p>

            <h2>Contexte du projet</h2>
            <p>
            Ce projet avait pour objectif de nous permettre de mettre en pratique les compétences acquises en développement
            web (PHP, HTML, CSS, JavaScript) ainsi qu’en architecture client‑serveur trois tiers. Nous devions :
            </p>
            <div class="card">
                <ul>
                    <li>Récupérer des données météorologiques via une API externe (prevision‑meteo.ch).</li>
                    <li>Gérer les préférences utilisateur (thème jour/nuit, langue, dernière ville consultée) avec des cookies.</li>
                    <li>Proposer une interface dynamique pour la sélection de régions, départements et villes.</li>
                    <li>Enregistrer et afficher des statistiques de consultation (fichier CSV, génération d’histogramme).</li>
                    <li>Mettre en place un système de géolocalisation par IP (GeoPlugin) comme solution de secours.</li>
                </ul>
            </div>
        </article>
        <article class="container card">
            <h2>Principales technologies utilisées</h2>
            <div class="card">
                <ul>
                    <li><strong>PHP 8</strong> pour la logique serveur et les appels aux APIs.</li>
                    <li><strong>JavaScript</strong> pour la bascule jour/nuit (thème), et charts.</li>
                    <li><strong>HTML &amp; CSS</strong> avec Flexbox et deux feuilles de style (standard et alternatif).</li>
                    <li><strong>APIs météo</strong> : prevision‑meteo.ch pour les prévisions, GeoPlugin pour la géolocalisation IP.</li>
                    <li><strong>CSV</strong> côté serveur pour le suivi des visites et des villes consultées, et Chart.js pour les graphiques.</li>
                </ul>
            </div>
        </article>
        <article class="container card">
            <h2>Organisation du travail</h2>
            <div class="card">
                <ol>
                    <li>Conception de l’architecture et choix des APIs.</li>
                    <li>Développement du backend (récupération et traitement des données JSON/XML).</li>
                    <li>Réalisation du frontend (interface, formulaires dynamiques, gestion du thème).</li>
                    <li>Implémentation du suivi des visites et génération des statistiques.</li>
                    <li>Tests, corrections et déploiement en ligne avec alwaysdata.</li>
                </ol>
            </div>
        </article>

        <article class="container card">
            <h2>Binôme</h2>
            <div class="card">
                <ul>
                    <li><strong>Madi DINGA</strong></li>
                    <li><strong>Abdoulaye DIAGNE</strong></li>
                </ul>
            </div>
            <p>
            Nous remercions notre enseignants <strong>Marc LEMAIRE</strong> pour son encadrement et ses conseils tout au long de ce projet.
            </p>
        </article>
  </section>
</main>

<?php
require("includes/footer.inc.php");
?>
