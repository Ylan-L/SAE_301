<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="auth-page-wrapper">
    <div class="auth-container">

        <header class="auth-header">
            <h2><i class="fas fa-sign-in-alt"></i> Connexion</h2>
            <p>Heureux de vous revoir, connectez-vous pour accéder à votre espace.</p>
        </header>

        <?php if (!empty($message_erreur)) : ?>
            <div class="alert alert-error"><?= htmlspecialchars($message_erreur) ?></div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['message_flash'])) : ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message_flash']) ?></div>
            <?php unset($_SESSION['message_flash']); ?>
        <?php endif; ?>

        <form action="frontController.php?action=validerConnexion"
              method="POST"
              id="form"
              class="auth-form">

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email"
                       id="email"
                       name="email"
                       placeholder="votre@email.com"
                       required
                       autofocus>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>

                <div class="password-wrapper">
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="********"
                           required>

                    <button type="button"
                            id="togglePassword"
                            class="toggle-password">
                        Afficher
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                Se connecter
            </button>
        </form>

        <footer class="auth-footer">
            <p>
                Pas encore de compte ?
                <a href="frontController.php?action=inscription">S'inscrire gratuitement</a>
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
