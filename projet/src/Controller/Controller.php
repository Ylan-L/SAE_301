<?php
require_once __DIR__ . '/../Model/Repository/UtilisateurRepository.php';

class Controller {

    private static function render(string $view): void {
        require __DIR__ . '/../View/header.php';
        require __DIR__ . '/../View/' . $view . '.php';
        require __DIR__ . '/../View/footer.php';
    }

    public static function register(): void {
        if ($_POST) {
            UtilisateurRepository::create(
                $_POST['username'],
                $_POST['email'],
                $_POST['password']
            );
            header("Location: index.php?action=login");
            exit;
        }
        self::render("register");
    }

    public static function login(): void {
        if ($_POST) {
            $user = UtilisateurRepository::findByEmail($_POST['email']);
            if ($user && password_verify($_POST['password'], $user->password_hash)) {
                session_start();
                $_SESSION['id'] = $user->id_utilisateurs;
                $_SESSION['username'] = $user->username;
                header("Location: index.php?action=dashboard");
                exit;
            }
        }
        self::render("login");
    }

    public static function dashboard(): void {
        session_start();
        if (!isset($_SESSION['id'])) {
            header("Location: index.php?action=login");
            exit;
        }
        self::render("dashboard");
    }

    public static function logout(): void {
        session_start();
        session_destroy();
        header("Location: index.php?action=login");
    }
}
