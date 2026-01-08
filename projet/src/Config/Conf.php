<?php
namespace App\Covoiturage\Config;
class Conf {
    // Configuration de la base de données
    private static $databases = array(
        'hostname' => 'localhost',
        'database' => 'sae3_01', 
<<<<<<< HEAD
        // Sur votre machine, vous avez surement un compte 'root'
        'login' => 'root',
        // CHANGEZ AVEC VOTRE MDP A VOUS 
        'password' => 'vitrygtr' );
static private array $configs = array();
        static public function getLogin() : string { 
            // L'attribut statique $databases s'obtient 
            // avec la syntaxe static::$databases 
            // au lieu de $this->databases pour un attribut non statique 
            return static::$databases['login']; 
            } 
        static public function getHostname() : string { 
            return static::$databases['hostname']; 
            } 
        
        static public function getDatabase() : string { 
            return static::$databases['database']; 
            } 
=======
        'login'    => 'root',
        'password' => 'julia' 
    );
>>>>>>> 77ae15043430bf22001b87dcda7d993417d65956

    // Ajout pour le mail
    private static $mail = array(
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => 'contactsae301@gmail.com',
        'password' => 'xsdr rjrp mpjf xrtb',
        'secure' => 'tls' // tls = STARTTLS
    );

<<<<<<< HEAD
    
            
} 
=======
    // Paramètres de l'application
    private static $debug = true; 

    public static function getLogin() { 
        return self::$databases['login']; 
    }

    public static function getHostname() { 
        return self::$databases['hostname']; 
    }

    public static function getDatabase() { 
        return self::$databases['database']; 
    }

    public static function getPassword() { 
        return self::$databases['password']; 
    }

    public static function getDebug() {
        return self::$debug;
    }
     public static function getMailHost() { return self::$mail['host']; }
    public static function getMailPort() { return self::$mail['port']; }
    public static function getMailUsername() { return self::$mail['username']; }
    public static function getMailPassword() { return self::$mail['password']; }
}
>>>>>>> 77ae15043430bf22001b87dcda7d993417d65956
?>