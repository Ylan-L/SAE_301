<div class="container">
    <div class="dashboard-header">
        <h2><i class="fas fa-tachometer-alt"></i> Tableau de Bord</h2>
    </div>

    <div class="dashboard-card">
        <div class="welcome-section">
            <h3>
                Bienvenue, <?= htmlspecialchars($_SESSION['username'] ?? 'Utilisateur') ?> !
            </h3>
            <p>
                Heureux de vous revoir sur la plateforme <strong>SAE 301</strong>.
            </p>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <span class="info-label">Statut</span>
                <strong class="info-value">
                    <i class="fas fa-user-shield"></i>
                    <?= ucfirst(htmlspecialchars($_SESSION['user_role'] ?? 'Membre')) ?>
                </strong>
            </div>

            <div class="info-box">
                <span class="info-label">Dernière connexion</span>
                <span class="info-value">
                    <i class="fas fa-clock"></i>
                    <?= htmlspecialchars($_SESSION['derniere_connexion'] ?? 'Première fois !') ?>
                </span>
            </div>
        </div>

        <div class="actions-section">
            <a href="FrontController.php?action=profil" class="button btn-submit">
                <i class="fas fa-user-edit"></i> Modifier mon profil
            </a>

            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="FrontController.php?action=admin_users" class="button btn-admin">
                    <i class="fas fa-users-cog"></i> Administration
                </a>
            <?php endif; ?>

            <a href="FrontController.php?action=deconnexion" class="button btn-danger">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </div>
    </div>
</div>
