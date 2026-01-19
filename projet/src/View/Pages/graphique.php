<div class="graph-container" style="max-width: 1000px; margin: 20px auto; text-align: center;">
    
    <h2><?php echo $titreGraphique; ?></h2>

    <form method="GET" action="frontController.php" style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <input type="hidden" name="action" value="graphique"> <div style="margin-bottom: 10px;">
            <label>Indicateur : </label>
            <button type="submit" name="filtre" value="temperature" class="btn-graph">Température</button>
            <button type="submit" name="filtre" value="salinite" class="btn-graph">Salinité</button>
            <button type="submit" name="filtre" value="phytoplanctons" class="btn-graph">Phytoplanctons</button>
        </div>

        <div>
            <label>Période du : <input type="date" name="dateDebut" value="<?php echo $dateDebut; ?>" required></label>
            <label>au : <input type="date" name="dateFin" value="<?php echo $dateFin; ?>" required></label>
            <button type="submit" style="background: #28a745; color: white; border: none; padding: 5px 15px; border-radius: 4px; cursor: pointer;">Actualiser</button>
        </div>
    </form>

    <div class="map-container">
        <div id="passageMap"></div>
    </div>

    <div style="position: relative; height: 50vh; width: 100%;">
        <canvas id="monGraphique"></canvas>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<script>
    const passages = <?php echo $jsonPassages; ?>;
    const franceBounds = L.latLngBounds([41.2, -5.3], [51.5, 9.7]);
    const map = L.map('passageMap', {
        maxBounds: franceBounds,
        maxBoundsViscosity: 1.0,
        minZoom: 5
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    if (passages.length > 0) {
        const bounds = [];
        passages.forEach((passage) => {
            if (!Number.isFinite(passage.lat) || !Number.isFinite(passage.lng)) {
                return;
            }
            const marker = L.marker([passage.lat, passage.lng]).addTo(map);
            if (passage.label) {
                marker.bindPopup(passage.label);
            }
            bounds.push([passage.lat, passage.lng]);
        });

        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [20, 20], maxZoom: 7 });
            map.setMaxBounds(franceBounds);
        } else {
            map.setView([46.5, 2.5], 5);
        }
    } else {
        map.setView([46.5, 2.5], 5);
    }

    window.addEventListener('load', () => {
        map.invalidateSize();
    });

    const ctx = document.getElementById('monGraphique').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [
                {
                    label: 'Atlantique / Manche',
                    data: <?php echo $jsonAtl; ?>,
                    borderColor: '#3498db', // Bleu
                    backgroundColor: '#3498db',
                    pointRadius: 2,
                    borderWidth: 2,
                    tension: 0.2
                },
                {
                    label: 'Méditerranée',
                    data: <?php echo $jsonMed; ?>,
                    borderColor: '#e74c3c', // Rouge
                    backgroundColor: '#e74c3c',
                    pointRadius: 2,
                    borderWidth: 2,
                    tension: 0.2
                }
            ]
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
                    beginAtZero: false,
                    title: { display: true, text: 'Valeur' }
                }
            },
            plugins: {
                legend: { position: 'top' }
            }
        }
    });
</script>

<style>
    .map-container { height: 360px; margin-bottom: 20px; }
    #passageMap { height: 100%; width: 100%; border: 1px solid #ddd; border-radius: 8px; }
    .btn-graph { padding: 8px 15px; margin: 0 5px; cursor: pointer; border: 1px solid #ccc; background: white; border-radius: 4px; }
    .btn-graph:hover { background: #eee; }
</style>

<a href="frontController.php?action=export_csv">Export CSV</a>

