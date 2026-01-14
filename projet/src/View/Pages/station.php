<div class="station-container" style="max-width: 1000px; margin: 20px auto; text-align: center;">

    <h2>&#128269; Rechercher une station </h2>

    <form method="GET" action="frontController.php" style="margin-bottom: 20px;">
        <input type="hidden" name="action" value="station">

        <input 
            type="text" 
            name="station"
            placeholder="Nom ou code de la station"
            value="<?php echo htmlspecialchars($stationRecherchee ?? ''); ?>"
            required
            style="padding: 8px; width: 60%;"
        >

        <button type="submit" style="padding: 8px 15px;">Rechercher</button>
    </form>

    <div class="map-container">
        <div id="stationMap">
            <script>
                const stations = <?php echo $jsonStations; ?>;

                const franceBounds = L.latLngBounds([41.2, -5.3], [51.5, 9.7]);
                const map = L.map('stationMap', {
                    maxBounds: franceBounds,
                    maxBoundsViscosity: 1.0,
                    minZoom: 5
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                const bounds = [];

                stations.forEach(station => {
                    if (!Number.isFinite(station.lat) || !Number.isFinite(station.lng)) return;

                    const marker = L.marker([station.lat, station.lng]).addTo(map);
                    marker.bindPopup(station.nom);
                    bounds.push([station.lat, station.lng]);
                });

                if (bounds.length > 0) {
                    map.fitBounds(bounds, { padding: [20, 20], maxZoom: 7 });
                } else {
                    map.setView([46.5, 2.5], 5);
                }

                window.addEventListener('load', () => {
                    map.invalidateSize();
                });
            </script>
        </div>
    </div>

    <?php if (!empty($stationDetails)) : ?>
        <h3><?php echo htmlspecialchars($stationDetails['nom']); ?></h3>

        <ul style="list-style: none; padding: 0;">
            <li><strong>Lieu :</strong> <?php echo htmlspecialchars($stationDetails['libelle_lieu']); ?></li>
            <li><strong>Zone :</strong> <?php echo htmlspecialchars($stationDetails['zone']); ?></li>
            <li><strong>Entité :</strong> <?php echo htmlspecialchars($stationDetails['entite']); ?></li>
            <li><strong>Classement :</strong> <?php echo htmlspecialchars($stationDetails['classement']); ?></li>
        </ul>
    <?php endif; ?>

    <?php if (!empty($jsonStationData)) : ?>
    <div style="position: relative; height: 50vh; width: 100%;">
        <canvas id="stationGraphique"></canvas>
    </div>
    <?php endif; ?>

    
    <script>
        <?php if (!empty($jsonStationData)) : ?>
        const ctx = document.getElementById('stationGraphique').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [{
                    label: '<?php echo addslashes($stationDetails["nom"]); ?>',
                    data: <?php echo $jsonStationData; ?>,
                    borderColor: '#3498db',
                    backgroundColor: '#3498db',
                    pointRadius: 2,
                    borderWidth: 2,
                    tension: 0.2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'time',
                        time: { unit: 'month' },
                        title: { display: true, text: 'Date' }
                    },
                    y: {
                        title: { display: true, text: 'Valeur' }
                    }
                }
            }
        });
        <?php endif; ?>
    </script>

    

</div>