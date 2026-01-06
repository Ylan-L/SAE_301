<div class="container-blanc">
  <div class="section-header">
    <h2>Réinitialisation</h2>
    <p class="subtitle">Choisissez un nouveau mot de passe.</p>
  </div>

  <form action="/sae3_auth/web/FrontController.php?action=update_password" method="POST" id="form">
    <div id="error"></div>

    <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <div class="form-group">
      <label for="password">Nouveau mot de passe</label>
      <input type="password" name="password" id="password" placeholder="Minimum 8 caractères" minlength="8" required>
    </div>

    <div class="form-group">
      <label for="password_confirm">Confirmer le mot de passe</label>
      <input type="password" name="password_confirm" id="password_confirm" placeholder="Retapez votre mot de passe" minlength="8" required>
    </div>

    <button type="submit" class="btn-main">Mettre à jour le mot de passe</button>
  </form>

  <div class="auth-footer-simple">
    <p>Retour : <a href="/sae3_auth/web/FrontController.php?action=connexion">Connexion</a></p>
  </div>
</div>
