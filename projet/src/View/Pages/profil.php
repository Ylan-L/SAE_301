<div>
    <div>
        <h2>Paramètres du Profil</h2>
        <p>Gérez vos informations personnelles et la sécurité de votre compte.</p>

        <form action="frontController.php?action=modifierProfil" method="POST">
            
            <div>
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" 
                       value="<?= htmlspecialchars($_SESSION['username'] ?? '') ?>" 
                       required>
            </div>

            <div>
                <label for="email">Adresse Email</label>
                <input type="email" id="email" name="email" 
                       value="<?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>" 
                       disabled>
                <p>
                    <small>L'adresse email ne peut pas être modifiée pour des raisons de sécurité.</small>
                </p>
            </div>

            <hr>

            <div>
                <label for="password">Changer le mot de passe</label>
                <p>
                    <small>Laissez vide pour conserver votre mot de passe actuel.</small>
                </p>
                <input type="password" name="password" id="password" 
                       placeholder="Nouveau mot de passe" minlength="8">
            </div>
            
            <div style="margin-top: 20px;">
                <button type="submit">
                    Enregistrer les modifications
                </button>
                <a href="frontController.php?action=dashboard">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>