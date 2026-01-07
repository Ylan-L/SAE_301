<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $pagetitle; ?></title>
        <link rel="nom du fichier css" href="chemin du fichier css">
    </head>
    <body>
        <header>
            <nav>
                <ul><!-- exemple d'utilisation à modifier -->
                    <a href="frontController.php?action=accueil">Accueil</a>
                    <li><a href="chemin">nom du truc</a></li>
                    <li><a href="chemin">nom du truc</a></li>
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
