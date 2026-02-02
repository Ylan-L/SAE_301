<?php
// On définit les bonnes réponses
$reponses_correctes = [
    'question1' => 'B1',
    'question2' => 'B2',
    'question3' => 'B3',
    'question4' => 'B4',
    'question5' => 'C5',
    'question6' => 'B6',
    'question7' => 'C7',
    'question8' => 'D8',
    'question9' => 'C9',
    'question10' => 'A10'
];

// Fonction pour générer le message de résultat
function afficherResultat($nomChamp, $correctValue, $lettreB) {
    if (isset($_POST[$nomChamp])) {
        if ($_POST[$nomChamp] === $correctValue) {
            return "<div class='result-box correct'> Bonne réponse !</div>";
        } else {
            return "<div class='result-box wrong'> Mauvaise réponse. La bonne réponse est la $lettreB.</div>";
        }
    }
    return "";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Quizz Océanographique</title>
    </head>
<body>

<div class="container">
    <header class="dashboard-header">
        <h1><i class="fas fa-vial"></i> QUIZZ BIODIVERSITÉ</h1>
        <p>Testez vos connaissances sur le phytoplancton et l'écosystème marin.</p>
    </header>

    <form method="post" class="quizz-form">
        
        <div class="quizz-card">
            <h3>QUESTION 1: Quel est le principal rôle du phytoplancton dans les océans ?</h3>
            <div class="options">
                <label><input type="radio" name="question1" value="A1"> A. Produire du sel</label><br>
                <label><input type="radio" name="question1" value="B1"> B. Absorber le CO₂ et produire de l’oxygène</label><br>
                <label><input type="radio" name="question1" value="C1"> C. Réchauffer l'eau</label><br>
                <label><input type="radio" name="question1" value="D1"> D. Augmenter la salinité</label><br>
            </div>
            <?= afficherResultat('question1', 'B1', 'B') ?>
        </div>

        <div class="quizz-card">
            <h3>QUESTION 2: Pourquoi le phytoplancton est-il utilisé comme indicateur de l’état écologique ?</h3>
            <div class="options">
                <label><input type="radio" name="question2" value="A2"> A. Il est visible à l’œil nu</label><br>
                <label><input type="radio" name="question2" value="B2"> B. Il réagit rapidement aux changements environnementaux</label><br>
                <label><input type="radio" name="question2" value="C2"> C. Il vit uniquement en Méditerranée</label><br>
                <label><input type="radio" name="question2" value="D2"> D. Il augmente la température de l’eau</label><br>
            </div>
            <?= afficherResultat('question2', 'B2', 'B') ?>
        </div>

        <div class="quizz-card">
            <h3>QUESTION 3: Où la concentration en phytoplancton est-elle la plus élevée ?</h3>
            <div class="options">
                <label><input type="radio" name="question3" value="A3"> A. En Méditerranée</label><br>
                <label><input type="radio" name="question3" value="B3"> B. Dans l’Atlantique</label><br>
                <label><input type="radio" name="question3" value="C3"> C. Identique dans les deux</label><br>
                <label><input type="radio" name="question3" value="D3"> D. Uniquement en été</label><br>
            </div>
            <?= afficherResultat('question3', 'B3', 'B') ?>
        </div>

        <div class="quizz-card">
            <h3>QUESTION 4: Quelle est la température moyenne de surface la plus élevée ?</h3>
            <div class="options">
                <label><input type="radio" name="question4" value="A4"> A. Atlantique français</label><br>
                <label><input type="radio" name="question4" value="B4"> B. Méditerranée française</label><br>
                <label><input type="radio" name="question4" value="C4"> C. Identique toute l’année</label><br>
                <label><input type="radio" name="question4" value="D4"> D. Plus élevée en hiver dans l’Atlantique</label><br>
            </div>
            <?= afficherResultat('question4', 'B4', 'B') ?>
        </div>

        <div class="quizz-card">
            <h3>QUESTION 5: La salinité est :</h3>
            <div class="options">
                <label><input type="radio" name="question5" value="A5"> A. La quantité de phytoplancton</label><br>
                <label><input type="radio" name="question5" value="B5"> B. La température de l’eau</label><br>
                <label><input type="radio" name="question5" value="C5"> C. La concentration de sels dissous dans l’eau</label><br>
                <label><input type="radio" name="question5" value="D5"> D. La profondeur de l’océan</label><br>
            </div>
            <?= afficherResultat('question5', 'C5', 'C') ?>
        </div>

        <div class="quizz-card">
            <h3>QUESTION 6: Dans quelle zone la salinité est-elle la plus élevée ?</h3>
            <div class="options">
                <label><input type="radio" name="question6" value="A6"> A. Atlantique français</label><br>
                <label><input type="radio" name="question6" value="B6"> B. Méditerranée française</label><br>
                <label><input type="radio" name="question6" value="C6"> C. Identique dans les deux</label><br>
                <label><input type="radio" name="question6" value="D6"> D. Plus élevée près des pôles</label><br>
            </div>
            <?= afficherResultat('question6', 'B6', 'B') ?>
        </div>

        <div class="quizz-card">
            <h3>QUESTION 7: Quel lien existe entre température et phytoplancton ?</h3>
            <div class="options">
                <label><input type="radio" name="question7" value="A7"> A. Plus l’eau est chaude, plus il y a de phytoplancton</label><br>
                <label><input type="radio" name="question7" value="B7"> B. Le phytoplancton disparaît dans l’eau chaude</label><br>
                <label><input type="radio" name="question7" value="C7"> C. La température influence la croissance du phytoplancton</label><br>
                <label><input type="radio" name="question7" value="D7"> D. Il n’y a aucun lien</label><br>
            </div>
            <?= afficherResultat('question7', 'C7', 'C') ?>
        </div>

        <div class="quizz-card">
            <h3>QUESTION 8: Quel facteur influence le plus la répartition du phytoplancton ?</h3>
            <div class="options">
                <label><input type="radio" name="question8" value="A8"> A. La profondeur des fonds marins</label><br>
                <label><input type="radio" name="question8" value="B8"> B.  La vitesse des courants atmosphériques</label><br>
                <label><input type="radio" name="question8" value="C8"> C. La salinité uniquement</label><br>
                <label><input type="radio" name="question8" value="D8"> D. La disponibilité en nutriments</label><br>
            </div>
            <?= afficherResultat('question8', 'D8', 'D') ?>
        </div>

        <div class="quizz-card">
            <h3>QUESTION 9: Quelle est la température moyenne de surface en été en Méditerranée ?</h3>
            <div class="options">
                <label><input type="radio" name="question9" value="A9"> A. 10-15 °C</label><br>
                <label><input type="radio" name="question9" value="B9"> B. 16-20 °C</label><br>
                <label><input type="radio" name="question9" value="C9"> C. 22-28 °C</label><br>
                <label><input type="radio" name="question9" value="D9"> D. 30-35 °C</label><br>
            </div>
            <?= afficherResultat('question9', 'C9', 'C') ?>
        </div>

        <div class="quizz-card">
            <h3>QUESTION 10: Pourquoi la salinité de la Méditerranée est-elle plus élevée que celle de l’Atlantique ?</h3>
            <div class="options">
                <label><input type="radio" name="question10" value="A10"> A. À cause d’une forte évaporation et faibles précipitations</label><br>
                <label><input type="radio" name="question10" value="B10"> B. À cause des apports fluviaux importants</label><br>
                <label><input type="radio" name="question10" value="C10"> C. À cause des courants froids venant du nord</label><br>
                <label><input type="radio" name="question10" value="D10"> D. À cause d’une activité volcanique sous-marine</label><br>
            </div>
            <?= afficherResultat('question10', 'A10', 'A') ?>
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <button type="submit" class="btn-main">
                <i class="fas fa-check-circle"></i> Valider toutes mes réponses
            </button>
        </div>

    </form>
</div>
<style>
    /* Le fond bleu */
    body {
        background-color: rgb(197, 234, 255);
    }
</style>