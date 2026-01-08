<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $pagetitle; ?></title>
        <link rel="stylesheet" href="../assets/css/style.css">

    </head>
    <body>
        <header>
    <nav>
        <ul>
            <li><a href="frontController.php?action=accueil">Accueil</a></li>

            <?php if (empty($_SESSION['user_id'])): ?>
            <!-- Utilisateur NON connecté -->
            <li><a href="frontController.php?action=connexion">Connexion</a></li>
            <li><a href="frontController.php?action=inscription">Inscription</a></li>
            <?php else: ?>
            <!-- Utilisateur connecté -->
            <li><a href="frontController.php?action=quizz">Quizz</a></li>
            <li><a href="frontController.php?action=dashboard">Dashboard</a></li>
            <li><a href="frontController.php?action=profil">Mon Profil</a></li>
            <li><a href="frontController.php?action=deconnexion">Quitter</a></li>
    <?php endif; ?>

    <li><a href="frontController.php?action=graphique">Graphiques</a></li>
    <li><a href="frontController.php?action=contact_propos">Contact</a></li>
</ul>

    </nav>
</header>
    <main>
        <?php
            $pagePath = __DIR__ . '/Pages/' . $view . '.php';

            if (!file_exists($pagePath)) {
                die("Vue introuvable : " . htmlspecialchars($pagePath));
            }
            require $pagePath;
        ?>
    </main>
    <footer>
        <p>Site du Groupe 3 pour la SAE 3_01</p>
    </footer>
    </body>
</html>
