<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Connexion</title>
    </head>
<body class="connexion">
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
    - le signet sur la carte station
    - une couleur grisé lorsque ce n'est pas l'indicateur en qst
 -->

<div class="station-container" style="max-width: 1000px; margin: 20px auto;">

    <!-- ================= RECHERCHE ================= -->
    <h2>🔍 Rechercher une station</h2>

    <form method="GET" action="frontController.php" style="margin-bottom: 20px;">
        <input type="hidden" name="action" value="station">

        <input
            type="text"
            name="station"
            id="station-input"               
            list="liste-stations"             
            placeholder="Nom de la station"
            value="<?= htmlspecialchars($stationRecherchee ?? '') ?>"
            required
            style="padding: 8px; width: 60%;"
        >
        <datalist id="liste-stations">
            <?php foreach ($listeStations as $s): ?>
                <option value="<?= htmlspecialchars($s['libelle_lieu']) ?>">
            <?php endforeach; ?>
        </datalist>

        <button type="submit" style="padding: 8px 15px;">Rechercher</button>
    </form>

    <!-- AUTOCOMPLETE -->
    <datalist id="liste-stations">
        <?php foreach ($listeStations as $s): ?>
            <option value="<?= htmlspecialchars($s['libelle_lieu']) ?>">
        <?php endforeach; ?>
    </datalist>

    <!-- ================= CARTE ================= -->
    <div class="map-container">
        <div id="stationMap"></div>
    </div>
    
    <!-- ================= INFOS STATION ================= -->
    <a id="graphique"></a>
    <?php if ($stationDetails !== null): ?>
        <h3><?= htmlspecialchars($stationDetails['nom']) ?></h3>

        <ul style="list-style: none; padding: 0; margin-bottom: 30px;">
            <li><strong>Zone :</strong> <?= htmlspecialchars($stationDetails['zone']) ?></li>
            <li><strong>Entité de classement :</strong> <?= htmlspecialchars($stationDetails['type']) ?></li>
        </ul>
    <?php endif; ?>

    <?php if ($stationDetails !== null): ?>
    <section style="margin-top: 30px; padding: 15px; border: 1px solid #ddd;">
        <h4>📊 Données disponibles pour cette station</h4>

        <?php if (empty($disponibilites)): ?>
            <p>Aucune donnée n’est disponible pour cette station.</p>
        <?php else: ?>
            <ul>
                <?php
                    $indicateursAutorises = [
                        'Température de l\'eau' => 'Température de l’eau',
                        'Salinité' => 'Salinité',
                        'Chlorophylle a' => 'Phytoplanctons'
                    ];
                ?>
                <?php foreach ($disponibilites as $d): ?>
                    <?php if (!array_key_exists($d['indicateur'], $indicateursAutorises)) continue; ?>

                    <strong><?= $indicateursAutorises[$d['indicateur']] ?></strong> :
                    du <?= htmlspecialchars($d['date_debut']) ?>
                    au <?= htmlspecialchars($d['date_fin']) ?>
                    (<?= (int)$d['nb_valeurs'] ?> mesures) <br>
                <?php endforeach; ?>

            </ul>
        <?php endif; ?>
    </section>
<?php endif; ?>


    <!-- ================= FILTRES GRAPHIQUE ================= -->

    <?php if ($stationDetails !== null): ?>
        <form method="GET" action="frontController.php#graphique"
              style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">

            <input type="hidden" name="action" value="station">
            <input type="hidden" name="station" value="<?= htmlspecialchars($stationRecherchee) ?>">
            <input type="hidden" name="filtre" value="<?= htmlspecialchars($filtre) ?>">

            <div style="margin-bottom: 10px;">
                <label>Indicateur :</label>
                <button type="submit" onclick="changerIndicateur('temperature')" id="btn-temperature">Température (°C)</button>
                <button type="submit" onclick="changerIndicateur('salinite')" id="btn-salinite">Salinité (sans unité)</button>
                <button type="submit" onclick="changerIndicateur('phytoplanctons')" id="btn-phytoplanctons">Phytoplanctons (µg.l-1)</button>

                <input type="hidden" name="filtre" id="filtre-input" value="<?= $filtre ?>">
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
    const disponibilites = <?= $jsonDisponibilites ?? '{}' ?>;
    const stations = <?= $jsonStations ?? '[]' ?>;

    const map = L.map('stationMap').setView([46.5, 2.5], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const bounds = [];

    stations.forEach(station => {

    if (!Number.isFinite(station.lat) || !Number.isFinite(station.lng)) {
        return; // on ignore la station
    }

    const marker = L.marker([station.lat, station.lng]).addTo(map);


    marker.bindTooltip(station.libelle_lieu, {
        direction: 'top'
    });

    marker.bindPopup(`
        <strong>${station.libelle_lieu}</strong><br>
        Classement : ${station.entite_classement}
        <button onclick="selectionnerStation('${station.libelle_lieu.replace(/'/g, "\\'")}')">
            Voir cette station
        </button>
    `);

});

    if (bounds.length > 0) {
        const boundsAtlantique = L.latLngBounds(
            [43.2, -6], // sud-ouest
            [51.5, 2]   // nord-est
        );

        map.fitBounds(boundsAtlantique);

    }

    window.addEventListener('load', () => map.invalidateSize());
</script>

<script>
    function selectionnerStation(nomStation) {
        const input = document.getElementById('station-input');
        if (!input) return;

        input.value = nomStation;

        // on soumet le formulaire automatiquement
        input.form.submit();
    }
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
                    min: '<?= $dateDebut ?>',
                    max: '<?= $dateFin ?>',
                    time: {
                        unit: 'month'
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
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

<!-- ================= Fonctions pour le graphique ================= -->
<script>
    function changerIndicateur(indicateur) {
        document.getElementById('filtre-input').value = indicateur;

        if (disponibilites[indicateur]) {
            document.querySelector('input[name="dateDebut"]').value =
                disponibilites[indicateur].dateDebut;
            document.querySelector('input[name="dateFin"]').value =
                disponibilites[indicateur].dateFin;
        }

        mettreEnEvidence(indicateur);
    }

    function mettreEnEvidence(indicateurActif) {
        ['temperature', 'salinite', 'phytoplanctons'].forEach(ind => {
            const btn = document.getElementById('btn-' + ind);
            if (!btn) return;

            btn.style.backgroundColor =
                (ind === indicateurActif) ? '#007bff' : '#e0e0e0';
            btn.style.color =
                (ind === indicateurActif) ? 'white' : 'black';
        });
    }

    // Mise en évidence automatique au chargement
    window.addEventListener('load', () => {
        mettreEnEvidence("<?= $filtre ?>");
    });
</script>
</body>
</html>

