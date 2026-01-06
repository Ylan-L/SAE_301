<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        $resultat = "";

if (isset($_POST['reponse1'])) {
    if ($_POST['reponse1'] === "B") {
        $resultat = "✅ Bonne réponse ! Le phytoplancton absorbe le CO₂ et produit de l’oxygène.";
    } else {
        $resultat = "❌ Mauvaise réponse. La bonne réponse est : B.";
    }
}
?>
        <h1>QUIZZ</h1>
        <form><p>QUESTION 1: Quel est le principal rôle du phytoplancton dans les océans ? </p>

            <label><type d’entrée="radio" name="question1"> A.  Produire du sel</label><br>
            <label><type d’entrée="radio" name="question1"> B. Absorber le CO₂ et produire de l’oxygène</label><br>
            <label><type d’entrée="radio" name="question1"> C.  Réchauffer l'eau</label><br>
            <label><type d’entrée="radio" name="question1"> D. Augmenter la salinité </label><br>
        <input type="submit" value="Valider">

        <p>QUESTION 2: Pourquoi le phytoplancton est-il utilisé comme indicateur de l’état écologique des océans ? </p>
            <label><type d’entrée="radio" name="Réponse1"> A. Il est visible à l’œil nu</label><br>
            <label><type d’entrée="radio" name="Réponse2"> B. Il réagit rapidement aux changements environnementaux</label><br>
            <label><type d’entrée="radio" name="Réponse3"> C. Il vit uniquement en Méditerranée</label><br>
            <label><type d’entrée="radio" name="Réponse4"> D. Il augmente la température de l’eau</label><br>
        <input type="submit" value="Valider">

        <p>QUESTION 3: Entre l’océan Atlantique et la mer Méditerranée française, où la concentration en phytoplancton est-elle généralement la plus élevée ?</p>
            <label><type d’entrée="radio" name="Réponse1"> A. En Méditerranée</label><br>
            <label><type d’entrée="radio" name="Réponse2"> B. Dans l’Atlantique</label><br>
            <label><type d’entrée="radio" name="Réponse3"> C. Identique dans les deux</label><br>
            <label><type d’entrée="radio" name="Réponse4"> D. Uniquement en été dans les deux </label><br>
        <input type="submit" value="Valider">

        <p>QUESTION 4: Quelle est la température moyenne de surface la plus élevée ? </p>
            <label><type d’entrée="radio" name="Réponse1"> A. Atlantique français</label><br>
            <label><type d’entrée="radio" name="Réponse2"> B. Méditerranée française</label><br>
            <label><type d’entrée="radio" name="Réponse3"> C. Identique toute l’année</label><br>
            <label><type d’entrée="radio" name="Réponse4"> D. Plus élevée en hiver dans l’Atlantique</label><br>
        <input type="submit" value="Valider">

        <p>QUESTION 5: La salinité est :</p>
            <label><type d’entrée="radio" name="Réponse1"> A. La quantité de phytoplancton</label><br>
            <label><type d’entrée="radio" name="Réponse2"> B. La température de l’eau</label><br>
            <label><type d’entrée="radio" name="Réponse3"> C. La concentration de sels dissous dans l’eau</label><br>
            <label><type d’entrée="radio" name="Réponse4"> D. La profondeur de l’océan </label><br>
        <input type="submit" value="Valider">

        <p>QUESTION 6: Dans quelle zone la salinité est-elle la plus élevée ?</p>
            <label><type d’entrée="radio" name="Réponse1"> A. Atlantique français</label><br>
            <label><type d’entrée="radio" name="Réponse2"> B. Méditerranée française</label><br>
            <label><type d’entrée="radio" name="Réponse3"> C. Identique dans les deux</label><br>
            <label><type d’entrée="radio" name="Réponse4"> D. Plus élevée près des pôles</label><br>
        <input type="submit" value="Valider">

        <p> QUESTION 7: Quel lien existe entre température et phytoplancton ?</p>
            <label><type d’entrée="radio" name="Réponse1"> A. Plus l’eau est chaude, plus il y a toujours de phytoplancton</label><br>
            <label><type d’entrée="radio" name="Réponse2"> B. Le phytoplancton disparaît dans l’eau chaude</label><br>
            <label><type d’entrée="radio" name="Réponse3"> C. La température influence la croissance du phytoplancton</label><br>
            <label><type d’entrée="radio" name="Réponse4"> D. Il n’y a aucun lien </label><br>
        <input type="submit" value="Valider">
        </form>
    
    
</body>
</html>