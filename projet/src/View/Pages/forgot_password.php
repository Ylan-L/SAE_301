<div class="auth-page-wrapper">
    <div class="auth-container forgot-container">
        <header class="auth-header">
            <h2><i class="fas fa-unlock-alt"></i> Mot de passe oublié</h2>
            <p>
                Saisissez votre adresse email pour recevoir un lien de réinitialisation.
            </p>
        </header>

        <form method="POST" action="frontController.php?action=send_reset_link" class="auth-form">
            <div class="form-group">
                <label for="email">Votre adresse email</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       placeholder="nom@exemple.com" 
                       required 
                       autofocus>
                <small class="helper-text">
                    Un email contenant un lien sécurisé vous sera envoyé.
                </small>
            </div>

            <button type="submit" class="btn-submit">
                Envoyer le lien
            </button>
        </form>

        <footer class="auth-footer">
            <a href="frontController.php?action=connexion" class="back-link">
                <i class="fas fa-arrow-left"></i> Retour à la connexion
            </a>
        </footer>
    </div>
</div>