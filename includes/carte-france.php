<svg viewBox="0 0 600 600" class="france-svg-map" xmlns="http://www.w3.org/2000/svg">
    <!-- Île-de-France -->
    <path
        d="M300 200 L330 180 L360 200 L350 230 L320 240 L290 230 Z"
        class="region"
        data-region="ile-de-france"
        data-name="Île-de-France"
    />
    
    <!-- Normandie -->
    <path
        d="M220 150 L300 170 L290 230 L240 220 L200 180 Z"
        class="region"
        data-region="normandie"
        data-name="Normandie"
    />
    
    <!-- Bretagne -->
    <path
        d="M100 180 L180 160 L200 180 L180 220 L120 230 Z"
        class="region"
        data-region="bretagne"
        data-name="Bretagne"
    />
    
    <!-- Pays de la Loire -->
    <path
        d="M180 220 L240 220 L260 280 L200 300 L160 270 Z"
        class="region"
        data-region="pays-de-la-loire"
        data-name="Pays de la Loire"
    />
    
    <!-- Nouvelle-Aquitaine -->
    <path
        d="M160 270 L200 300 L220 400 L180 450 L120 400 L140 320 Z"
        class="region"
        data-region="nouvelle-aquitaine"
        data-name="Nouvelle-Aquitaine"
    />
    
    <!-- Occitanie -->
    <path
        d="M180 450 L220 400 L300 420 L350 450 L320 500 L220 480 Z"
        class="region"
        data-region="occitanie"
        data-name="Occitanie"
    />
    
    <!-- Provence-Alpes-Côte d'Azur -->
    <path
        d="M350 450 L400 420 L450 450 L430 500 L380 520 L320 500 Z"
        class="region"
        data-region="provence-alpes-cote-d-azur"
        data-name="Provence-Alpes-Côte d'Azur"
    />
    
    <!-- Auvergne-Rhône-Alpes -->
    <path
        d="M300 300 L380 280 L420 320 L400 420 L350 450 L300 420 L280 350 Z"
        class="region"
        data-region="auvergne-rhone-alpes"
        data-name="Auvergne-Rhône-Alpes"
    />
    
    <!-- Bourgogne-Franche-Comté -->
    <path
        d="M320 240 L400 220 L420 260 L380 280 L300 300 Z"
        class="region"
        data-region="bourgogne-franche-comte"
        data-name="Bourgogne-Franche-Comté"
    />
    
    <!-- Grand Est -->
    <path
        d="M350 230 L400 220 L450 180 L480 220 L450 260 L420 260 Z"
        class="region"
        data-region="grand-est"
        data-name="Grand Est"
    />
    
    <!-- Hauts-de-France -->
    <path
        d="M300 170 L350 150 L400 160 L450 180 L400 220 L350 230 L330 180 Z"
        class="region"
        data-region="hauts-de-france"
        data-name="Hauts-de-France"
    />
    
    <!-- Centre-Val de Loire -->
    <path
        d="M240 220 L290 230 L320 240 L300 300 L280 350 L260 280 Z"
        class="region"
        data-region="centre-val-de-loire"
        data-name="Centre-Val de Loire"
    />
    
    <!-- Corse -->
    <path
        d="M480 450 L500 470 L490 500 L470 490 Z"
        class="region"
        data-region="corse"
        data-name="Corse"
    />
</svg>

<div id="region-info" class="region-info-box">
    <p class="region-name"></p>
    <p class="region-hint">Cliquez pour voir les prévisions</p>
</div>

<script>
    document.querySelectorAll('.region').forEach(region => {
        region.addEventListener('mouseenter', function() {
            const regionName = this.getAttribute('data-name');
            const regionInfo = document.getElementById('region-info');
            regionInfo.querySelector('.region-name').textContent = regionName;
            regionInfo.style.display = 'block';
        });
        
        region.addEventListener('mouseleave', function() {
            document.getElementById('region-info').style.display = 'none';
        });
        
        region.addEventListener('click', function() {
            const regionId = this.getAttribute('data-region');
            window.location.href = `forecast.php?region=${encodeURIComponent(this.getAttribute('data-name'))}`;
        });
    });
</script>