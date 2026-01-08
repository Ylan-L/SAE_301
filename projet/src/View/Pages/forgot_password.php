<div class="forgot-container">
    <h2>Mot de passe oublié</h2>

    <p>
        Saisissez votre adresse email pour recevoir un lien vous permettant
        de réinitialiser votre mot de passe.
    </p>

    <form method="POST" action="frontController.php?action=send_reset_link" class="forgot-form">
        <div class="forgot-form-group">
            <label for="email">Votre adresse email :</label>
            <input type="email" 
                   name="email" 
                   id="email" 
                   placeholder="nom@exemple.com" 
                   required 
                   autofocus>
            <small>
                Un email contenant un lien pour modifier votre mot de passe vous sera envoyé.
            </small>
        </div>

        <button type="submit" class="btn-reset">
            Envoyer le lien
        </button>
    </form>

    <hr>

    <div class="footer-links">
        <p>
            <a href="frontController.php?action=connexion" class="back-link">
                Retour à la connexion
            </a>
        </p>
    </div>
</div>