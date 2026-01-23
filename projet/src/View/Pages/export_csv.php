<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Connexion</title>
    </head>
<body class="connexion"></body>
<div class="container-page">
    <h1>Télécharger un indicateur (CSV)</h1>

    <form method="GET" action="frontController.php">
        <input type="hidden" name="action" value="export_csv">

        <label for="indicateur">Choisir un indicateur :</label>

        <select name="indicateur" id="indicateur" required>
            <option value="">-- Sélectionner --</option>
            <option value="temperature">Température</option>
            <option value="salinite">Salinité</option>
            <option value="phytoplanctons">Phytoplanctons</option>
        </select>

        <button type="submit" class="btn-primary">
            Télécharger le CSV
        </button>
    </form>
</div>
</body>
</html>
