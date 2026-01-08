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
                <ul><!-- exemple d'utilisation à modifier -->
                  <nav>
                    <li><a href="frontController.php?action=accueil">Accueil</a></li>
                    <li><a href="frontController.php?action=connexion">Connexion</a></li>
                    <li><a href="frontController.php?action=inscription">Inscription</a></li>
                    <li><a href="frontController.php?action=quizz">Quizz</a></li>
                    <li><a href="frontController.php?action=graphique">Graphiques</a></li>
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <li><a href="frontController.php?action=dashboard">Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="frontController.php?action=contact_propos">Contact</a></li>
                
                </nav>

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
