<?php
namespace App\Covoiturage\Config;

class Conf {
    // Configuration de la base de données
    private static $databases = [
        'hostname' => 'localhost',
        'database' => 'sae3_01',
        'login'    => 'root',
        'password' => 'vboxuser'
    ];

    // Ajout pour le mail
    private static $mail = [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => 'contactsae301@gmail.com',
        'password' => 'xsdr rjrp mpjf xrtb',
        'secure' => 'tls' // tls = STARTTLS
    ];

    // Paramètres de l'application
    private static $debug = true;

    public static function getLogin() { return self::$databases['login']; }
    public static function getHostname() { return self::$databases['hostname']; }
    public static function getDatabase() { return self::$databases['database']; }
    public static function getPassword() { return self::$databases['password']; }
    public static function getDebug() { return self::$debug; }

    public static function getMailHost() { return self::$mail['host']; }
    public static function getMailPort() { return self::$mail['port']; }
    public static function getMailUsername() { return self::$mail['username']; }
    public static function getMailPassword() { return self::$mail['password']; }
}

?>