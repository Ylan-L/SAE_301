<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="connexion">

<div class="auth-page-wrapper">
    <div class="auth-container">

        <header class="auth-header">
            <h2><i class="fas fa-user-plus"></i> Inscription</h2>
            <p>Créez votre compte pour accéder à la plateforme.</p>
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


        <form action="frontController.php?action=validerInscription"
              method="POST"
              class="auth-form">

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text"
                       id="username"
                       name="username"
                       placeholder="Votre pseudo"
                       required>
            </div>

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email"
                       id="email"
                       name="email"
                       placeholder="votre@email.com"
                       required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>

                <div class="password-wrapper">
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="********"
                           required>
                
                    <button class="butt" type="button"
                            id="togglePassword"
                            class="toggle-password">Afficher</button>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password"
                       id="confirm_password"
                       name="confirm_password"
                       placeholder="********"
                       required>
            </div>

            <button type="submit" class="btn-submit">
                Créer mon compte
            </button>
        </form>

        <footer class="auth-footer">
            <p>
                Déjà un compte ?
                <a href="frontController.php?action=connexion">Se connecter</a>
            </p>
        </footer>

    </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        this.textContent = 'Masquer';
    } else {
        passwordInput.type = 'password';
        this.textContent = 'Afficher';
    }
});
</script>

</body>
</html>
