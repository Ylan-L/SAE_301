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
                    <li><a href="/SAE301/web/frontController.php?action=readAll">Accueil voitures</a></li>
                    <li><a href="chemin">nom du truc</a></li>
                    <li><a href="chemin">nom du truc</a></li>
                </ul>
            </nav>
        </header>
    <main>
        <?php
        require __DIR__ . "/{$cheminVueBody}";
        ?>
    </main>
    <footer>
        <p>Site de moi, je suis trop fort, et vive Gizzini et Delechel</p>
    </footer>
    </body>
</html>
