<div class="logout-page-wrapper">

    <div class="logout-container">
        <div class="logout-icon">
            <i class="fas fa-sign-out-alt"></i>
        </div>

        <h2>Déconnexion</h2>
        <p>Voulez-vous vraiment quitter votre session ?</p>

        <div class="logout-actions">
            <button class="btn-confirm-logout" onclick="window.location.href='frontController.php?action=deconnexion'">
                Oui, me déconnecter
            </button>
            
            <a href="frontController.php?action=dashboard" class="btn-cancel">
                Non, rester sur le site
            </a>
        </div>
        
    </div>

</div>