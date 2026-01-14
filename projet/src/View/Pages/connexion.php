<div class="auth-page-wrapper">
    
    <div class="auth-container">
        <header class="auth-header">
            <h2><i class="fas fa-sign-in-alt"></i> Connexion</h2>
            <p>Heureux de vous revoir ! Connectez-vous pour accéder à votre espace.</p>
        </header>
        <?php if (!empty($message_erreur)) : ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($message_erreur) ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['message_flash'])) : ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['message_flash']) ?>
            </div>
            <?php unset($_SESSION['message_flash']); ?>
        <?php endif; ?>
        <form action="frontController.php?action=validerConnexion" method="POST" class="auth-form">
            
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       placeholder="votre@email.com" 
                       required 
                       autofocus>
            </div>

           <div class="form-group">
    <div class="label-row">
        <label for="password">Mot de passe</label>
        <a href="frontController.php?action=forgot_password" class="link-forgot">Oublié ?</a>
    </div>
    <div class="password-container">
        <input type="password" 
               id="password" 
               name="password" 
               placeholder="********" 
               required>
        <i class="fas fa-eye" id="togglePassword"></i>
    </div>
</div>

            <button type="submit" class="btn-submit">
                Se connecter
            </button>
            
        </form>

        <footer class="auth-footer">
            <p>Pas encore de compte ? 
                <a href="frontController.php?action=inscription">S'inscrire gratuitement</a>
            </p>
        </footer>
        
    </div>
</div>