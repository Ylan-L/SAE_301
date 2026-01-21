<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Mon profil</title>
    </head>
<body class="connexion">

<body class="connexion">
<div class="container-page"> <div class="profile-container container-blanc">
        
        <header class="profile-header">
            <h2><i class="fas fa-user-circle"></i> Paramètres du Profil</h2>
            <p>Gérez vos informations personnelles et la sécurité de votre compte.</p>
        </header>

        <form action="frontController.php?action=modifierProfil" method="POST" class="auth-form">
            
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
                       disabled class="input-disabled">
                <small class="helper-text">L'adresse email ne peut pas être modifiée pour des raisons de sécurité.</small>
            </div>

            <div class="separator"></div>

            <div class="form-group">
                <label for="password">Changer le mot de passe</label>
                <input type="password" name="password" id="password" 
                       placeholder="Nouveau mot de passe" minlength="8">
                <small class="helper-text">Laissez vide pour conserver votre mot de passe actuel.</small>
            </div>
            
            <div class="profile-actions">
                <button type="submit" class="btn-submit btn-save">
                    Enregistrer les modifications
                </button>
                <a href="frontController.php?action=dashboard" class="btn-back">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>