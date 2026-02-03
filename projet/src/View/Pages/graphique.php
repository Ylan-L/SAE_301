<div class="graph-container" style="max-width: 1000px; margin: 20px auto; text-align: center;">
    
    <h2><?php echo $titreGraphique; ?></h2>

    <form method="GET" action="frontController.php" style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <input type="hidden" name="action" value="graphique"> 
        <div style="margin-bottom: 10px;">
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

    <div style="position: relative; height: 50vh; width: 100%; margin-top: 30px;">
        <canvas id="monGraphique"></canvas>
    </div>

    <a href="frontController.php?action=export_csv" class="btn-export">
        Export CSV
    </a>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- 1. CARTE (LEAFLET) ---
    const passages = <?php echo $jsonPassages; ?>;
    const map = L.map('passageMap').setView([46.5, -1], 5); // Centré sur l'Atlantique FR

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    if (passages.length > 0) {
        passages.forEach(p => {
            if(p.lat && p.lng) {
                L.marker([p.lat, p.lng]).addTo(map).bindPopup(p.label);
            }
        });
    }

    window.addEventListener('load', () => {
        map.invalidateSize();
    });

    // --- 2. GRAPHIQUE (CHART.JS - BARRE) ---
    const ctx = document.getElementById('monGraphique').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar', // On utilise des barres
        data: {
            labels: <?php echo $jsonLabels; ?>, // Les noms des stations en bas
            datasets: [{
                label: 'Moyenne sur la période',
                data: <?php echo $jsonData; ?>,
                backgroundColor: 'rgba(52, 152, 219, 0.7)', // Bleu
                borderColor: '#2980b9',
                borderWidth: 1,
                borderRadius: 4 // Coins légèrement arrondis en haut des barres
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false, // false permet de mieux voir les différences (ex: entre 14° et 15°)
                    title: { display: true, text: 'Valeur moyenne' }
                },
                x: {
                    title: { display: true, text: 'Stations' }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' (Moyenne)';
                        }
                    }
                }
            }
        }
    });
</script>

<style>
    body { background-color: rgb(197, 234, 255);}
    .map-container { height: 360px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px; }
    #passageMap { height: 100%; width: 100%; border-radius: 8px; }
    .btn-graph { padding: 8px 15px; margin: 0 5px; cursor: pointer; border: 1px solid #ccc; background: white; border-radius: 4px; }
    .btn-graph:hover { background: #eee; }
    .btn-export { font-size: 18px; font-weight: bold; text-decoration: none; border-bottom: 2px solid #033255; padding-bottom: 2px; transition: color 0.3s;
    }
</style>


