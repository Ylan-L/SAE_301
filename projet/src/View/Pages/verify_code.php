<div>
    <h2>Vérification du code</h2>
    <p>Un code de validation vous a été envoyé par e-mail. Veuillez le saisir ci-dessous avec votre nouveau mot de passe.</p>

    <form action="FrontController.php?action=validerReset" method="POST">
        
        <div>
            <label for="code">Code de récupération (6 chiffres) :</label>
            <input type="text" 
                   name="code" 
                   id="code" 
                   placeholder="123456" 
                   maxlength="6" 
                   pattern="[0-9]{6}" 
                   inputmode="numeric"
                   required 
                   autofocus>
        </div>

        <div>
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" 
                   name="password" 
                   id="password" 
                   placeholder="Minimum 8 caractères" 
                   minlength="8" 
                   required>
        </div>

        <button type="submit">Réinitialiser mon mot de passe</button>
    </form>

    <hr>

    <div>
        <p>Code non reçu ? <a href="FrontController.php?action=forgot_password">Renvoyer une demande</a></p>
        <p><a href="FrontController.php?action=connexion">Annuler et revenir à la connexion</a></p>
    </div>
</div>