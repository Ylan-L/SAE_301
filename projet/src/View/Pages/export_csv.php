<div class="export-page-container">
    
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

        <button type="submit" class="btn-download">Télécharger le CSV</button>
    </form>

</div>

<style>
    /* 1. On force le fond bleu clair (comme les autres pages) */
    body {
        background-color: rgb(197, 234, 255);
    }

    /* 2. VOTRE CSS ADAPTÉ */
    /* J'ai repris vos règles Flexbox pour l'alignement */
    
    .export-page-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 40px; /* Votre marge */
        text-align: center;
    }

    /* Le Titre */
    .export-page-container h1 {
        margin: 0 0 25px 0; /* Votre marge */
        font-size: 2.2rem;
        /* J'ai mis bleu foncé au lieu de blanc, car sur le fond bleu clair, le blanc est illisible */
        color: #033255; 
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }

    /* Le Formulaire */
    .export-page-container form {
        display: flex;      /* Votre flexbox */
        align-items: center;
        gap: 15px;          /* Votre espace entre les éléments */
        
        /* Petit bonus : un fond blanc translucide pour faire ressortir le formulaire */
        background-color: rgba(255, 255, 255, 0.6);
        padding: 20px;
        border-radius: 10px;
    }

    /* Le Label */
    .export-page-container label {
        font-size: 1.1rem;
        color: #033255; /* Bleu foncé pour la lisibilité */
        font-weight: bold;
    }

    /* Style des champs et boutons */
    select {
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    .btn-download {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: 0.3s;
    }

    .btn-download:hover {
        background-color: #218838;
    }
</style>
