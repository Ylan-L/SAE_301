<?php
/** @var string|null $jsonStations */
/** @var array|null $stationDetails */
/** @var string|null $jsonStationData */
/** @var string|null $stationRecherchee */
/** @var string $filtre */
/** @var string $dateDebut */
/** @var string $dateFin */
?>
<!-- CHOSES A AMELIORER MARIAM
 - mettre le nom des stations sur la carte comme dans graphique
 - avoir une partie qui montre directement les données disponibles pour une station donnée 
    pour ne pas que ça n'affiche rien
- modifier "type" sur la page 
 - faire en sorte que lorsque l'on fait une recherche pour graphique ça ne monte pas tout en haut
 - proposition de stations lorsque l'on fait une recherche 
 -->

<div class="station-container" style="max-width: 1000px; margin: 20px auto;">

    <!-- ================= RECHERCHE ================= -->
    <h2>&#128269; Rechercher une station</h2>

    <form method="GET" action="frontController.php" style="margin-bottom: 20px;">
        <input type="hidden" name="action" value="station">

        <input
            type="text"
            name="station"
            placeholder="Nom de la station"
            value="<?= htmlspecialchars($stationRecherchee ?? '') ?>"
            required
            style="padding: 8px; width: 60%;"
        >

        <button type="submit" style="padding: 8px 15px;">Rechercher</button>
    </form>

    <!-- ================= CARTE ================= -->
    <div class="map-container">
        <div id="stationMap"></div>
    </div>

    <!-- ================= INFOS STATION ================= -->
    <?php if ($stationDetails !== null): ?>
        <h3><?= htmlspecialchars($stationDetails['nom']) ?></h3>

        <ul style="list-style: none; padding: 0; margin-bottom: 30px;">
            <li><strong>Zone :</strong> <?= htmlspecialchars($stationDetails['zone']) ?></li>
            <li><strong>Entité de classement :</strong> <?= htmlspecialchars($stationDetails['type']) ?></li>
        </ul>
    <?php endif; ?>

    <!-- ================= FILTRES GRAPHIQUE ================= -->
    <?php if ($stationDetails !== null): ?>
        <form method="GET" action="frontController.php"
              style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">

            <input type="hidden" name="action" value="station">
            <input type="hidden" name="station" value="<?= htmlspecialchars($stationRecherchee) ?>">

            <div style="margin-bottom: 10px;">
                <label>Indicateur :</label>
                <button type="submit" name="filtre" value="temperature">Température</button>
                <button type="submit" name="filtre" value="salinite">Salinité</button>
                <button type="submit" name="filtre" value="phytoplanctons">Phytoplanctons</button>
            </div>

            <div>
                <label>
                    Du :
                    <input type="date" name="dateDebut" value="<?= $dateDebut ?>" required>
                </label>
                <label>
                    au :
                    <input type="date" name="dateFin" value="<?= $dateFin ?>" required>
                </label>

                <button type="submit">Actualiser</button>
            </div>
        </form>
    <?php endif; ?>

    <!-- ================= GRAPHIQUE ================= -->
    <?php if ($jsonStationData !== null): ?>
        <div style="position: relative; height: 50vh; width: 100%;">
            <canvas id="stationGraphique"></canvas>
        </div>
    <?php endif; ?>
</div>

<!-- ================= LIBRAIRIES ================= -->
<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<!-- ================= CARTE ================= -->
<script>
    const stations = <?= $jsonStations ?? '[]' ?>;

    const map = L.map('stationMap').setView([46.5, 2.5], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const bounds = [];

    stations.forEach(s => {
        if (!s.lat || !s.lng) return;

        const marker = L.circleMarker([station.lat, station.lng], {
    radius: 6,
    fillOpacity: 0.8
}).addTo(map);

// Au survol
marker.bindTooltip(station.libelle_lieu, {
    permanent: false,
    direction: 'top'
});

// Au clic
marker.bindPopup(`
    <strong>${station.libelle_lieu}</strong><br>
    Zone : ${station.zone}<br>
    Classement : ${station.entite_classement}
`);

        bounds.push([s.lat, s.lng]);
    });

    if (bounds.length > 0) {
        map.fitBounds(bounds, {padding: [20, 20], maxZoom: 7});
    }

    window.addEventListener('load', () => map.invalidateSize());
</script>

<!-- ================= GRAPHIQUE ================= -->
<?php if ($jsonStationData !== null): ?>
<script>
    const ctx = document.getElementById('stationGraphique').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                label: "<?= addslashes($stationDetails['nom']) ?>",
                data: <?= $jsonStationData ?>,
                borderWidth: 2,
                pointRadius: 2,
                tension: 0.2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    type: 'time',
                    time: {unit: 'month'},
                    title: {display: true, text: 'Date'}
                },
                y: {
                    title: {display: true, text: 'Valeur'}
                }
            }
        }
    });
</script>
<?php endif; ?>

<!-- ================= STYLE ================= -->
<style>
    .map-container {
        height: 360px;
        margin-bottom: 20px;
    }

    #stationMap {
        height: 100%;
        width: 100%;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    button {
        padding: 6px 12px;
        margin: 0 5px;
        cursor: pointer;
    }
</style>
