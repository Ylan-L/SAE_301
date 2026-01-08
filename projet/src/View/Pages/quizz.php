<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <?php
        $resultat1 = "";

if (isset($_POST['question1'])) {
    if ($_POST['question1'] === "B1") {
        $resultat1 = "Bonne réponse ! ";
    } else {
        $resultat1 = " Mauvaise réponse. La bonne réponse est la B.";
    }
}
?>
        <h1>QUIZZ</h1>
        <form method="post"><h3>QUESTION 1: Quel est le principal rôle du phytoplancton dans les océans ? </h3>
            <input type="radio" id="A" name="question1" value="A1">
            <label for="A1">A.  Produire du sel</label><br>

            <input type="radio" id="B" name="question1" value="B1">
            <label for="B1">B. Absorber le CO₂ et produire de l’oxygène</label><br>

            <input type="radio" id="C" name="question1" value="C1">
            <label for="C1">C.  Réchauffer l'eau</label><br>
            
            <input type="radio" id="D" name="question1" value="D1">
            <label for="D1">D. Augmenter la salinité</label><br>
            
        <input type="submit" value="Valider"> <br>
        <?= $resultat1 ?>
<?php
        $resultat2 = "";

if (isset($_POST['question2'])) {
    if ($_POST['question2'] === "B2") {
        $resultat2 = "Bonne réponse ! ";
    } else {
        $resultat2 = " Mauvaise réponse. La bonne réponse est la B.";
    }
}
?>
        <h3>QUESTION 2: Pourquoi le phytoplancton est-il utilisé comme indicateur de l’état écologique des océans ? </h3>
            <input type="radio" id="A" name="question2" value="A2">
            <label for="A2">A. Il est visible à l’œil nu</label><br>

            <input type="radio" id="B" name="question2" value="B2">
            <label for="B2">B. Il réagit rapidement aux changements environnementaux</label><br>

            <input type="radio" id="C" name="question2" value="C2">
            <label for="C2"> C. Il vit uniquement en Méditerranée</label><br>
            
            <input type="radio" id="D" name="question2" value="D2">
            <label for="D2"> D. Il augmente la température de l’eau</label><br>
            
        <input type="submit" value="Valider">
         <?= $resultat2 ?>

         <?php
        $resultat3 = "";

if (isset($_POST['question3'])) {
    if ($_POST['question3'] === "B3") {
        $resultat3 = "Bonne réponse ! ";
    } else {
        $resultat3 = " Mauvaise réponse. La bonne réponse est la B.";
    }
}
?>
        <h3>QUESTION 3: Entre l’océan Atlantique et la mer Méditerranée française, où la concentration en phytoplancton est-elle généralement la plus élevée ?</h3>
             <input type="radio" id="A" name="question3" value="A3">
            <label for="A3">A. En Méditerranée</label><br>

            <input type="radio" id="B" name="question3" value="B3">
            <label for="B3">B. Dans l’Atlantique</label><br>

            <input type="radio" id="C" name="question3" value="C3">
            <label for="C3">C. Identique dans les deux</label><br>

            <input type="radio" id="D" name="question3" value="D3">
            <label for="D3"> D. Uniquement en été dans les deux</label><br>

            <input type="submit" value="Valider">
            <?= $resultat3 ?>

                    <?php
        $resultat4 = "";

if (isset($_POST['question4'])) {
    if ($_POST['question4'] === "B4") {
        $resultat4 = "Bonne réponse ! ";
    } else {
        $resultat4 = " Mauvaise réponse. La bonne réponse est la B.";
    }
}
?>
        <h3>QUESTION 4: Quelle est la température moyenne de surface la plus élevée ? </h3>
            <input type="radio" id="A" name="question4" value="A4">
            <label for="A4"> A. Atlantique français</label><br>

            <input type="radio" id="B" name="question4" value="B4">
            <label for="B4">  B. Méditerranée française</label><br>

            <input type="radio" id="C" name="question4" value="C4">
            <label for="C4">  C. Identique toute l’année</label><br>

            <input type="radio" id="D" name="question4" value="D4">
            <label for="D4">  D. Plus élevée en hiver dans l’Atlantique</label><br>

        <input type="submit" value="Valider">
        <?= $resultat4 ?>

        <?php
        $resultat5 = "";

if (isset($_POST['question5'])) {
    if ($_POST['question5'] === "C5") {
        $resultat5 = "Bonne réponse ! ";
    } else {
        $resultat5 = " Mauvaise réponse. La bonne réponse est la C.";
    }
}
?>
        <h3>QUESTION 5: La salinité est :</h3>
            <input type="radio" id="A" name="question5" value="A5">
            <label for="A5"> A. La quantité de phytoplancton</label><br>

            <input type="radio" id="B" name="question5" value="B5">
            <label for="B5"> B. La température de l’eau</label><br>

            <input type="radio" id="C" name="question5" value="C5">
            <label for="C5"> C. La concentration de sels dissous dans l’eau</label><br>

            <input type="radio" id="D" name="question5" value="D5">
            <label for="D5"> D. La profondeur de l’océan</label><br>
            
        <input type="submit" value="Valider">
        <?= $resultat5 ?>

              <?php
        $resultat6 = "";

if (isset($_POST['question6'])) {
    if ($_POST['question6'] === "B6") {
        $resultat6 = "Bonne réponse ! ";
    } else {
        $resultat6 = " Mauvaise réponse. La bonne réponse est la B.";
    }
}
    ?>
        <h3>QUESTION 6: Dans quelle zone la salinité est-elle la plus élevée ?</h3>
            <input type="radio" id="A" name="question6" value="A6">
            <label for="A6">A. Atlantique français</label><br>

            <input type="radio" id="N" name="question7" value="B6">
            <label for="B6">B. Méditerranée française</label><br>

            <input type="radio" id="C" name="question7" value="C6">
            <label for="C6">C. Identique dans les deux</label><br>

            <input type="radio" id="D" name="question7" value="D6">
            <label for="D6">D. Plus élevée près des pôles</label><br>
        
        <input type="submit" value="Valider">
         <?= $resultat6 ?>

         <?php
        $resultat7 = "";

if (isset($_POST['question7'])) {
    if ($_POST['question7'] === "C7") {
        $resultat7 = "Bonne réponse ! ";
    } else {
        $resultat7 = " Mauvaise réponse. La bonne réponse est la C.";
    }
}
    ?>
        <h3> QUESTION 7: Quel lien existe entre température et phytoplancton ?</h3>
            <input type="radio" id="A" name="question7" value="A7">
            <label for="A7">A. Plus l’eau est chaude, plus il y a toujours de phytoplancton</label><br>

            <input type="radio" id="B" name="question7" value="B7">
            <label for="B7">B. Le phytoplancton disparaît dans l’eau chaude</label><br>

            
            <input type="radio" id="C" name="question7" value="C7">
            <label for="C7">C. La température influence la croissance du phytoplancton</label><br>

            
            <input type="radio" id="D" name="question7" value="D7">
            <label for="D7">D. Il n’y a aucun lien</label><br>

        <input type="submit" value="Valider">
        <?= $resultat7 ?>
        </form>
    
    
</body>
</html>