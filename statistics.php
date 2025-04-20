<?php
	declare(strict_types = 1);
	$title ='Statistiques - Point Météo';
	$description ='La page dedié aux statistiques notamment des villes les plus consultées.';
		require("includes/header.inc.php");
		require("includes/weather_api.php");

		$count= hitCounter(); 
?>
    <main>
        <section class="container main-content">
			<div class="container">
				<div class="page-header">
					<h1>Statistiques du Site</h1>
				</div>

				<div class="stats-grid">
					<div class="stats-card card">
						<div class="card-header">
							<h2>Visiteurs</h2>
						</div>
						<div class="chart-container">
							<p>Mois:  <?= $count['dates']; ?></p>
							<p>Nombre total de visiteurs:  <?= $count['counter']; ?></p>
							<?php 
								if (isset($_COOKIE['lastCity'])) {
								$lastCityData = json_decode($_COOKIE['lastCity'], true);
								$lastCity = $lastCityData['ville'];
								$lastVisit = $lastCityData['date'];

								
									if ($lastCity !== '' && $lastVisit !== '') {
										echo '<p>Dernière ville consultée : '.$lastCity. ' le ' .$lastVisit. '</p>';			
									}
							    }
							?>
						</div>
					</div>

					<div class="stats-card card">
						<div class="card-header">
							<h2>Villes les Plus Recherchées</h2>
							<p>Histogramme des villes les plus consultées</p>
						</div>
						<div class="chart-container">

							<?php displayCitiesHistogram(); ?>

						</div>
					</div>
				</div>
			</div>
        </section>
    </main>

<?php
        require("includes/footer.inc.php");
?>