<div class="profile-container">
    <div class="profile-header">
        <h2>Paramètres du Profil</h2>
        <p>Gérez vos informations personnelles et la sécurité de votre compte.</p>
    </div>

    <form action="frontController.php?action=modifierProfil" method="POST">
        
        <div class="form-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" 
                   value="<?= htmlspecialchars($_SESSION['username'] ?? '') ?>" 
                   required>
        </div>

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" id="email" name="email" 
                   value="<?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>" 
                   disabled>
            <small>L'adresse email ne peut pas être modifiée pour des raisons de sécurité.</small>
        </div>

        <hr>

        <div class="form-group">
            <label for="password">Changer le mot de passe</label>
            <input type="password" name="password" id="password" 
                   placeholder="Nouveau mot de passe" minlength="8">
            <small>Laissez vide pour conserver votre mot de passe actuel.</small>
        </div>
        
        <div class="profile-actions">
            <button type="submit" class="btn-save">
                Enregistrer les modifications
            </button>
            <a href="frontController.php?action=dashboard" class="btn-cancel">
                Annuler
            </a>
        </div>
    </form>
</div>