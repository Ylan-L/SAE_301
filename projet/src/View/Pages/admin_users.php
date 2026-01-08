<div>
    <header>
        <div>
            <h2>Gestion des Utilisateurs</h2>
            <p>Interface de modération sécurisée pour les administrateurs.</p>
        </div>
        <a href="frontController.php?action=dashboard">
            Retour au Dashboard
        </a>
    </header>

    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>Identifiant</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td>
                            #<?= htmlspecialchars($u['id_utilisateur']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($u['username']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($u['email']) ?>
                        </td>

                        <td>
                            <?= strtoupper(htmlspecialchars($u['role'] ?? 'user')) ?>
                        </td>

                        <td>
                            <?php 
                            $current_user_id = $_SESSION['user_id'] ?? null;
                            if ($u['id_utilisateur'] != $current_user_id): ?>
                                <a href="frontController.php?action=supprimerUser&id=<?= $u['id_utilisateur'] ?>" 
                                   onclick="return confirm('Confirmer la suppression de <?= addslashes(htmlspecialchars($u['username'])) ?> ?')">
                                    Supprimer
                                </a>
                            <?php else: ?>
                                <span>(Moi)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">
                            <p>Aucun utilisateur n'a été trouvé.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>