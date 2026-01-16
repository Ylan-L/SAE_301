<?php
// Autoload Composer (PHPMailer)
//require_once __DIR__ . '/../../vendor/autoload.php';

// Chargement des classes du projet
require_once __DIR__ . '/../Model/Repository/DatabaseConnection.php';
require_once __DIR__ . '/../Model/DataObject/AbstractDataObject.php';
require_once __DIR__ . '/../Model/DataObject/Utilisateur.php';
require_once __DIR__ . '/../Model/Repository/AbstractRepository.php';
require_once __DIR__ . '/../Model/Repository/UtilisateurRepository.php';
require_once __DIR__ . '/../Config/Conf.php';



use App\Covoiturage\Model\Repository\UtilisateurRepository;
use App\Covoiturage\Model\Repository\DatabaseConnection;
use App\Covoiturage\Config\Conf;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Controller {
// ==========================================
    //          MÉTHODES D'AFFICHAGE (VUES)
    // ==========================================

    public static function accueil() { $view = 'accueil'; $pagetitle = 'Accueil'; require_once __DIR__ . '/../View/view.php'; }
    public static function connexion() { $view = 'connexion'; $pagetitle = 'Connexion'; require_once __DIR__ . '/../View/view.php'; }
    public static function inscription() { $view = 'inscription'; $pagetitle = 'Inscription'; require_once __DIR__ . '/../View/view.php'; }
    public static function contact_propos() { $view = 'contact_propos'; $pagetitle = 'À Propos & Contact'; require_once __DIR__ . '/../View/view.php'; }
    public static function quizz() { $view = 'quizz'; $pagetitle = 'Quizz'; require_once __DIR__ . '/../View/view.php'; }
    public static function graphique() { $view = 'graphique'; $pagetitle = 'Graphique'; require_once __DIR__ . '/../View/view.php'; }
    public static function dashboard() {
        if (!isset($_SESSION['user_id'])) { header("Location: frontController.php?action=connexion"); exit(); }
        $view = 'dashboard'; $pagetitle = 'Tableau de Bord'; require_once __DIR__ . '/../View/view.php';
    }

    public static function bilan_carbone(){ $view = 'bilan_carbone'; $pagetitle = 'Bilan Carbone'; require_once __DIR__ . '/../View/view.php';}

    public static function profil() {
        if (!isset($_SESSION['user_id'])) { header("Location: frontController.php?action=connexion"); exit(); }
        $view = 'profil'; $pagetitle = 'Mon Profil'; require_once __DIR__ . '/../View/view.php';
    }

    // ==========================================
    //             LOGIQUE UTILISATEUR
    // ==========================================

    public static function validerInscription() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!empty($username) && !empty($email) && !empty($password)) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            if (UtilisateurRepository::inscrire($username, $email, $hash)) {
                $_SESSION['message_flash'] = "Compte créé avec succès ! Connectez-vous.";
                header("Location: frontController.php?action=connexion");
                exit();
            } else {
                $message_erreur = "Erreur : cet email est déjà utilisé.";
            }
        } else {
            $message_erreur = "Veuillez remplir tous les champs.";
        }
        $view = 'inscription';
        $pagetitle = 'Inscription';
        require_once __DIR__ . '/../View/view.php';
    }

    public static function validerConnexion() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $ip = $_SERVER['REMOTE_ADDR'];

        // Limite : 5 échecs en 10 minutes (même email + même IP)
        $maxTentatives = 5;
        $fenetreMinutes = 10;

        $sql = "SELECT COUNT(*) AS nb
                FROM logs_connexions
                WHERE email_tente = ?
                AND ip_adresse = ?
                AND succes = 0
                AND date_tentative >= (NOW() - INTERVAL ? MINUTE)";
        $stmt = DatabaseConnection::getPdo()->prepare($sql);
        $stmt->execute([$email, $ip, $fenetreMinutes]);
        $nbEchecs = (int)($stmt->fetch(PDO::FETCH_ASSOC)['nb'] ?? 0);

        if ($nbEchecs >= $maxTentatives) {
            $message_erreur = "Trop de tentatives. Réessayez dans quelques minutes.";
            $view = 'connexion';
            $pagetitle = 'Connexion';
            require_once __DIR__ . '/../View/view.php';
            return; 
        }

        $user = UtilisateurRepository::getByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['derniere_connexion'] = date('d/m/Y H:i'); 
            
            $_SESSION['message_flash'] = "Bienvenue, " . htmlspecialchars($user['username']);

            try {
                UtilisateurRepository::enregistrerLog($user['id_utilisateur'], $email, $ip, true);
            } catch (Exception $e) { }

            header("Location: frontController.php?action=dashboard");
            exit();
        } else {
            try {
                $id_fail = $user ? $user['id_utilisateur'] : null;
                UtilisateurRepository::enregistrerLog($id_fail, $email, $ip, false);
            } catch (Exception $e) { }

            $message_erreur = "Identifiants incorrects.";
            $view = 'connexion';
            $pagetitle = 'Connexion';
            require_once __DIR__ . '/../View/view.php';
        }
    }

    public static function deconnexion() {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['message_flash'] = "Vous avez été déconnecté.";
        header("Location: frontController.php?action=accueil");
        exit();
    }
    
    public static function verify_code() {
    $view = 'verify_code'; // C'est ici qu'on fait le lien avec verify_code.php
    $pagetitle = 'Vérification du code';
    require_once __DIR__ . '/../View/view.php';
}

    public static function forgot_password() {
    $view = 'forgot_password';
    $pagetitle = 'Mot de passe oublié';
    require_once __DIR__ . '/../View/view.php';
    }

    public static function send_reset_link() {
    $email = trim($_POST['email'] ?? '');

    // Message neutre (sécurité)
    $okMsg = "Si un compte existe, un lien de réinitialisation a été envoyé.";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message_flash'] = $okMsg;
        header("Location: FrontController.php?action=forgot_password");
        exit();
    }

    $user = UtilisateurRepository::getByEmail($email);

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $token_hash = password_hash($token, PASSWORD_DEFAULT);
        $expires_at = (new DateTime('+30 minutes'))->format('Y-m-d H:i:s');

        UtilisateurRepository::creerResetMdp(
            (int)$user['id_utilisateur'],
            $token_hash,
            $expires_at
        );

        $resetLink = "http://localhost/SAE_301/projet/web/frontController.php?action=reset_password"
        . "&email=" . urlencode($email)
        . "&token=" . urlencode($token);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = Conf::getMailHost();
            $mail->Port       = Conf::getMailPort();
            $mail->SMTPAuth   = true;
            $mail->Username   = Conf::getMailUsername();
            $mail->Password   = Conf::getMailPassword();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->setFrom(Conf::getMailUsername(), 'Support SAE 3-01');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Réinitialisation de mot de passe";
            $mail->Body = "
                <p>Vous avez demandé une réinitialisation de mot de passe.</p>
                <p>Ce lien est valide 30 minutes :</p>
                <p><a href='{$resetLink}'>Réinitialiser mon mot de passe</a></p>
            ";
            $mail->AltBody = "Lien (30 min) : " . $resetLink;

            $mail->send();
        } catch (Exception $e) {
            
        }
    }

    $_SESSION['message_flash'] = $okMsg;
    header("Location: frontController.php?action=forgot_password");
    exit();
}

    public static function reset_password() {
        $view = 'reset_password';
        $pagetitle = 'Réinitialisation du mot de passe';
        require_once __DIR__ . '/../View/view.php';
    }

    public static function update_password() {
        $email = trim($_POST['email'] ?? '');
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($token)) {
            $_SESSION['message_erreur'] = "Lien invalide.";
            header("Location: frontController.php?action=forgot_password");
            exit();
        }

        if ($password !== $password_confirm || strlen($password) < 8) {
            $_SESSION['message_erreur'] = "Mot de passe invalide (min 8 caractères) ou confirmation différente.";
            header("Location: frontController.php?action=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token));
            exit();
        }

        $user = UtilisateurRepository::getByEmail($email);
        if (!$user) {
            $_SESSION['message_erreur'] = "Lien invalide.";
            header("Location: frontController.php?action=forgot_password");
            exit();
        }

        $reset = UtilisateurRepository::getDernierResetValide((int)$user['id_utilisateur']);
        if (!$reset) {
            $_SESSION['message_erreur'] = "Lien expiré ou déjà utilisé.";
            header("Location: frontController.php?action=forgot_password");
            exit();
        }

        if (new DateTime() > new DateTime($reset['expires_at'])) {
            $_SESSION['message_erreur'] = "Lien expiré.";
            header("Location: frontController.php?action=forgot_password");
            exit();
        }

        if (!password_verify($token, $reset['token_hash'])) {
            $_SESSION['message_erreur'] = "Lien invalide.";
            header("Location: frontController.php?action=forgot_password");
            exit();
        }

        $new_hash = password_hash($password, PASSWORD_BCRYPT);
        UtilisateurRepository::updatePasswordHash(
            (int)$user['id_utilisateur'],
            $new_hash
        );
        UtilisateurRepository::marquerResetUtilise((int)$reset['id']);

        $_SESSION['message_flash'] = "Mot de passe modifié. Vous pouvez vous connecter.";
        header("Location: frontController.php?action=connexion");
        exit();
    }





    // ==========================================
    //             LOGIQUE ADMIN
    // ==========================================

    public static function admin_users() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: FrontController.php?action=accueil");
            exit();
        }

        $users = UtilisateurRepository::getAllUsers();
        $pdo = DatabaseConnection::getPdo();
        
        $logs = $pdo->query("
            SELECT a.*, u.username as admin_name 
            FROM audit_logs a 
            LEFT JOIN utilisateurs u ON a.user_id = u.id_utilisateur 
            ORDER BY action_date DESC 
            LIMIT 50
        ")->fetchAll(PDO::FETCH_ASSOC);

        // Traitement corrigé pour PHP 8.1+
        foreach ($logs as &$log) {
            // On s'assure de passer une chaîne vide "" au lieu de NULL
            $oldData = $log['old_data'] ?? '';
            $newData = $log['new_data'] ?? '';

            $old = json_decode($oldData, true) ?? [];
            $new = json_decode($newData, true) ?? [];
            
            // On crée une chaîne descriptive
            if ($log['action_type'] === 'UPDATE') {
                $log['details'] = "Rôle : " . ($old['role'] ?? '?') . " → " . ($new['role'] ?? '?');
            } else {
                $log['details'] = "Utilisateur supprimé : " . ($old['username'] ?? 'Inconnu');
            }
        }

        $view = 'admin_users'; 
        $pagetitle = 'Administration & Audit';
        require_once __DIR__ . '/../View/view.php';
    }
    // ==========================================
    //             LOGIQUE CONTACT
    // ==========================================

    public static function envoyerContact() {
        $nom = $_POST['nom'] ?? 'Anonyme';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';

        if (!empty($email) && !empty($message)) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
            $mail->Host       = Conf::getMailHost();
            $mail->Port       = Conf::getMailPort();
            $mail->SMTPAuth   = true;
            $mail->Username   = Conf::getMailUsername();
            $mail->Password   = Conf::getMailPassword();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

           
            $mail->setFrom(Conf::getMailUsername(), 'Formulaire de contact');
            $mail->addReplyTo($email, $nom);

           
            $mail->addAddress(Conf::getMailUsername());

            
            $mail->isHTML(true);
            $mail->Subject = "Contact SAE 301 de " . $nom;

            $safeNom = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
            $safeEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $safeMsg = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

            $mail->Body = "
                <h3>Nouveau message</h3>
                <p><strong>De :</strong> {$safeNom} ({$safeEmail})</p>
                <p><strong>Message :</strong><br>{$safeMsg}</p>
            ";

            $mail->AltBody = "Nouveau message\nDe : {$nom} ({$email})\n\n{$message}";

            $mail->send();
            $_SESSION['message_flash'] = "Email envoyé !";
            } catch (Exception $e) {
                $_SESSION['message_erreur'] = "L'email n'a pas pu être envoyé.";
            }
        }
        header("Location: FrontController.php?action=contact_propos");
        exit();
    }


   
}