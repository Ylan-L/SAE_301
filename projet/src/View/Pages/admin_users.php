<div class="container-page">
    <h1>Administration</h1>

    <div class="admin-container container-blanc">
        <header class="admin-header">
            <div>
                <h2>Gestion des Utilisateurs</h2>
                <p>Interface de modération sécurisée pour les administrateurs.</p>
            </div>
            <a href="frontController.php?action=dashboard" class="btn-back">← Retour au Dashboard</a>
        </header>

        <div class="admin-table-wrapper">
            <table>
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
                            <td><strong>#<?= htmlspecialchars($u['id_utilisateur']) ?></strong></td>
                            <td><?= htmlspecialchars($u['username']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td>
                                <span class="role-badge">
                                    <?= strtoupper(htmlspecialchars($u['role'] ?? 'user')) ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                $session_id = $_SESSION['user_id'] ?? null;
                                if ($u['id_utilisateur'] != $session_id): ?>
                                    <a href="frontController.php?action=supprimerUser&id=<?= $u['id_utilisateur'] ?>" 
                                       class="btn-delete"
                                       onclick="return confirm('Supprimer l\'utilisateur <?= addslashes(htmlspecialchars($u['username'])) ?> ?')">
                                        Supprimer
                                    </a>

                                    <?php if (($u['role'] ?? 'user') !== 'admin'): ?>
                                        <a href="frontController.php?action=changerRole&id=<?= $u['id_utilisateur'] ?>"
                                           class="btn-edit"
                                           onclick="return confirm('Rendre <?= addslashes(htmlspecialchars($u['username'])) ?> administrateur ?')">
                                            Rendre Admin
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="me-label">(Moi)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="empty-table">Aucun utilisateur trouvé.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <h2 style="margin-top: 40px;">Journal d'Audit</h2>
        <div class="admin-table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Table</th>
                        <th>Anciennes données</th>
                        <th>Admin (ID)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= $log['created_at'] ?></td>
                            <td><strong><?= $log['action_type'] ?></strong></td>
                            <td><?= $log['table_name'] ?></td>
                            <td><small><?= htmlspecialchars($log['old_data']) ?></small></td>
                            <td><?= $log['user_id'] ?? 'Système' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">Aucun log disponible.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>