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
        <p>Site de moi, je suis trop fort, et vive Gizzini et Delechel</p>
    </footer>
    </body>
</html>
