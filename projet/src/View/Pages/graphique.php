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

    <div style="position: relative; height: 50vh; width: 100%;">
        <canvas id="monGraphique"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<script>
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
    .btn-graph { padding: 8px 15px; margin: 0 5px; cursor: pointer; border: 1px solid #ccc; background: white; border-radius: 4px; }
    .btn-graph:hover { background: #eee; }
</style>