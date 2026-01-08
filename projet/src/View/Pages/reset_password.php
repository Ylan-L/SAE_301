<div class="auth-page-wrapper">
    <div class="auth-container">
        
        <header class="auth-header">
            <h2><i class="fas fa-key"></i> Réinitialisation</h2>
            <p>Choisissez un nouveau mot de passe sécurisé pour votre compte.</p>
        </header>

        <form action="frontController.php?action=update_password" method="POST" class="auth-form">
            <div id="error"></div>

            <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       placeholder="Minimum 8 caractères" 
                       minlength="8" 
                       required 
                       autofocus>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input type="password" 
                       name="password_confirm" 
                       id="password_confirm" 
                       placeholder="Retapez votre mot de passe" 
                       minlength="8" 
                       required>
            </div>

            <button type="submit" class="btn-submit">
                Mettre à jour le mot de passe
            </button>
        </form>

        <footer class="auth-footer">
            <p>Retour à la <a href="frontController.php?action=connexion">Connexion</a></p>
        </footer>
        
    </div>
</div>