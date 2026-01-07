<div class="auth-container">
    <div class="auth-header" style="text-align: center; margin-bottom: 20px;">
        <h2><i class="fas fa-sign-in-alt"></i> Connexion</h2>
        <p>Heureux de vous revoir ! Connectez-vous pour accéder à votre espace.</p>
    </div>
    
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
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <label for="password">Mot de passe</label>
                <a href="/sae3_auth/web/frontController.php?action=forgot_password">Oublié ?</a>


            </div>
            <input type="password" 
                   id="password" 
                   name="password" 
                   placeholder="********" 
                   required>
        </div>

        <button type="submit" class="btn-submit" style="margin-top: 10px;">
            Se connecter
        </button>
    </form>

    <div class="auth-footer" style="margin-top: 25px; text-align: center; border-top: 1px solid #eee; padding-top: 15px;">
        <p>Pas encore de compte ? 
            <a href="frontController.php?action=inscription" style="font-weight: bold; color: #6665ee;">S'inscrire gratuitement</a>
        </p>
    </div>
</div>