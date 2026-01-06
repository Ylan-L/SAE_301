<div>
    <h2>Mot de passe oublié</h2>

    <p>
        Saisissez votre adresse email pour recevoir un lien vous permettant
        de réinitialiser votre mot de passe.
    </p>

    <form method="POST" action="/sae3_auth/web/FrontController.php?action=send_reset_link">
        <div>
            <label for="email">Votre adresse email :</label>
            <input type="email" 
                   name="email" 
                   id="email" 
                   placeholder="nom@exemple.com" 
                   required 
                   autofocus>
            <p>
                <small>
                    Un email contenant un lien pour modifier votre mot de passe vous sera envoyé.
                </small>
            </p>
        </div>

        <button type="submit">
            Envoyer le lien
        </button>
    </form>

    <hr>

    <div>
        <p>
            <a href="FrontController.php?action=connexion">
                Retour à la connexion
            </a>
        </p>
    </div>
</div>
