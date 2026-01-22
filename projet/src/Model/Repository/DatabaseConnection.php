<?php
namespace App\Covoiturage\Model\Repository;

use App\Covoiturage\Config\Conf;
use PDO;

class DatabaseConnection {

    private static $instance = null;
    private PDO $pdo;

    private function __construct() {

        $hostname     = Conf::getHostname();
        $databaseName = Conf::getDatabase();
        $login        = Conf::getLogin();
        $password     = Conf::getPassword();

        // Connexion PDO
        $this->pdo = new PDO(
            "mysql:host=$hostname;dbname=$databaseName;charset=utf8",
            $login,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );

        // ===== AUDIT LOG : utilisateur courant =====
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            $this->pdo->exec(
                "SET @current_user_id = " . (int)$_SESSION['user_id']
            );
        } else {
            $this->pdo->exec("SET @current_user_id = NULL");
        }
    }

    // Accès public au PDO
    public static function getPdo(): PDO {
        return self::getInstance()->pdo;
    }

    // Singleton
    private static function getInstance(): DatabaseConnection {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }
}
