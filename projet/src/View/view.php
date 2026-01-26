<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $pagetitle; ?></title>
        <link rel="stylesheet" href="../assets/css/style.css">

    </head>
    <body>
        <header>
    <nav class="navigation">
        <ul>
          <img src="../assets/images/OceanScope.png" alt="Logo" class="logo" width="90" height="68">

            <?php if (empty($_SESSION['user_id'])): ?>
            <!-- Utilisateur NON connecté -->
                <li><a class="speci" href="frontController.php?action=connexion">Connexion</a></li>
                <li><a class="spec" href="frontController.php?action=inscription">Inscription</a></li>
                 <li><a href="frontController.php?action=accueil">Accueil</a></li>

            <?php else: ?>
            <!-- Utilisateur connecté -->
            <li><a href="frontController.php?action=quizz">Quizz</a></li>
            <li><a href="frontController.php?action=dashboard">Dashboard</a></li>
            <li><a class="spec" href="frontController.php?action=deconnexion">Quitter</a></li>
             <li><a href="frontController.php?action=bilan_carbone">Bilan Carbone</a></li>
        <?php endif; ?>
            <li><a href="frontController.php?action=graphique">Graphique</a></li>
            <li><a href="frontController.php?action=station">Stations</a></li>
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
