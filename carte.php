<?php
        require("includes/header.inc.php");
?>
    <main>
		<section class="container main-content">

			<div class="welcome-section card">
                <h2>Bienvenue sur Point Météo</h2>
                <p>
                    Consultez les prévisions météorologiques pour toutes les régions de France. Utilisez notre carte
                    interactive ou recherchez directement votre ville pour obtenir des prévisions détaillées.
                </p>
            </div>

            <div class="grid-layout">
                <div class="map-container card">
                    <h2>Carte Météo Interactive</h2>
                    <div class="france-map">

                        <?php echo "carte ici !"; ?>
						
                    </div>
                </div>
                <div class="search-container card">
                    <h2>Rechercher une Prévision</h2>
                    <form action="forecast.php" method="GET" class="weather-form">
                        <div class="form-group">
                            <label for="ville">Ville</label>
                            <input type="text" id="ville" name="ville" placeholder="Selectionnez le nom de votre ville">
                        </div>
                        <div class="form-group">
                            <label for="region">Région</label>
                            <select id="region" name="region">
                                <option value="">Sélectionnez votre région</option>
                                <option value="Auvergne-Rhône-Alpes">Auvergne-Rhône-Alpes</option>
                                <option value="Bourgogne-Franche-Comté">Bourgogne-Franche-Comté</option>
                                <option value="Bretagne">Bretagne</option>
                                <option value="Centre-Val de Loire">Centre-Val de Loire</option>
                                <option value="Corse">Corse</option>
                                <option value="Grand Est">Grand Est</option>
                                <option value="Hauts-de-France">Hauts-de-France</option>
                                <option value="Île-de-France">Île-de-France</option>
                                <option value="Normandie">Normandie</option>
                                <option value="Nouvelle-Aquitaine">Nouvelle-Aquitaine</option>
                                <option value="Occitanie">Occitanie</option>
                                <option value="Pays de la Loire">Pays de la Loire</option>
                                <option value="Provence-Alpes-Côte d'Azur">Provence-Alpes-Côte d'Azur</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Voir previsions
                        </button>
                    </form>
                </div>
            </div>
            
        </section>
    </main>

<?php
        require("includes/footer.inc.php");
?>