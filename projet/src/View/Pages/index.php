<div class="container-blanc">
    <div class="hero">
        <h1>Accueil</h1>
        <p>Squelette pour la page de connexion et contact.</p>
        
        <div class="action-area">
            <?php if(!isset($_SESSION['user_id'])): ?>
                <a href="frontController.php?action=inscription" class="btn-main">
                    Démarrer l'expérience
                </a>
            <?php else: ?>
                <a href="frontController.php?action=dashboard" class="btn-main">
                    Aller au Tableau de Bord
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <h3>Authentification</h3>
            <p>Système complet de connexion, inscription et récupération de mot de passe sécurisé.</p>
        </div>

        <div class="feature-card">
            <h3>Communication</h3>
            <p>Intégration de PHPMailer pour les tests d'envoi d'emails.</p>
        </div>
    </div>

    <footer>
        <p>Utilisez le menu de navigation pour explorer les fonctionnalités.</p>
        <p>&copy; <?= date('Y') ?> - SAE 301</p>
    </footer>
</div>