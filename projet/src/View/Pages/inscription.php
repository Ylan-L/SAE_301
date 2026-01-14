<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>

    <link rel="stylesheet" href="../../../assets/css/style.css">
    <script src="../../../assets/js/script.js" defer></script>
</head>

<body>

<div class="auth-page-wrapper">
    <div class="auth-container">

        <header class="auth-header">
            <h2><i class="fas fa-user-plus"></i> Inscription</h2>
            <p>Rejoignez l'aventure SAE 301 et accédez à vos données.</p>
        </header>

        <form action="frontController.php?action=validerInscription"
              method="POST"
              id="form"
              class="auth-form">

            <div id="error"></div>

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text"
                       name="username"
                       id="username"
                       placeholder="Ex: SebastienCartier"
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

                <div class="password-wrapper">
                    <input type="password"
                           name="password"
                           id="password"
                           placeholder="Minimum 8 caractères"
                           minlength="8"
                           required>

                    <button type="button"
                            id="togglePassword"
                            class="toggle-password">
                        Afficher
                    </button>
                </div>

                <small class="helper-text">
                    Conseil : Utilisez des lettres, chiffres et symboles.
                </small>
            </div>

            <button type="submit" class="btn-submit">
                Créer mon compte
            </button>
        </form>

        <footer class="auth-footer">
            <p>
                Déjà inscrit ?
                <a href="frontController.php?action=connexion">
                    Se connecter ici
                </a>
            </p>
        </footer>

    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        
        // Bascule entre 'password' et 'text'
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