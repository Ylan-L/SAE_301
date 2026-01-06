<div class="container-blanc">
    <div class="section-header">
        <h2>Inscription</h2>
        <p class="subtitle">Rejoignez.</p>
    </div>

    <form action="FrontController.php?action=validerInscription" method="POST" id="form">
        <div id="error"></div>

        <div class="form-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" 
                   name="username" 
                   id="username" 
                   placeholder="Ex: JeanDupont" 
                   minlength="3"
                   maxlength="25"
                   required>
        </div>

        <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="email" 
                   name="email" 
                   id="email" 
                   placeholder="votre@email.com" 
                   required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" 
                   name="password" 
                   id="password" 
                   placeholder="Minimum 8 caractères" 
                   minlength="8"
                   required>
            <p style="margin-top: 8px;">
                <small style="color: var(--text-muted);">Conseil : Utilisez des lettres, des chiffres et des symboles.</small>
            </p>
        </div>

        <button type="submit" class="btn-main">
            Créer mon compte
        </button>
    </form>

    <div class="auth-footer-simple">
        <p>Déjà inscrit ? <a href="FrontController.php?action=connexion">Se connecter ici</a></p>
    </div>
</div>