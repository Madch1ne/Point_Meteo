<?php
	declare(strict_types = 1);
	$title ='Statistiques - Point Météo';
	$description ='';
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
						</div>
					</div>

					<div class="stats-card card">
						<div class="card-header">
							<h2>Répartition par Région</h2>
							<p>Pourcentage de visiteurs par région</p>
						</div>
						<div class="chart-container">
							
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

		<script>
			// Initialize charts with PHP data
			document.addEventListener('DOMContentLoaded', function() {
				// Visitors chart
				const visitorsCtx = document.getElementById('visitors-chart').getContext('2d');
				new Chart(visitorsCtx, {
					type: 'line',
					data: {
						labels: <?php echo json_encode(array_column($count, $count['date'])); ?>,
						datasets: [{
							label: 'Visiteurs',
							data: <?php echo json_encode(array_column($count, $count['counter'])); ?>,
							borderColor: '#3b82f6',
							backgroundColor: 'rgba(var(#3b82f6, 0.1)',
							tension: 0.3,
							fill: true
						}]
					},
					options: {
						responsive: true,
						maintainAspectRatio: false
					}
				});
			});

		</script>

    </main>

<?php
        require("includes/footer.inc.php");
?>