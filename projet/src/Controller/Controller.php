<?php

namespace App\Covoiturage\Controller;

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
use PDO;
use DateTime;

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
    public static function bilan_carbone(){ $view = 'bilan_carbone'; $pagetitle = 'Bilan Carbone'; require_once __DIR__ . '/../View/view.php';}
    
    public static function dashboard() {
        if (!isset($_SESSION['user_id'])) { header("Location: frontController.php?action=connexion"); exit(); }
        $view = 'dashboard'; $pagetitle = 'Tableau de Bord'; require_once __DIR__ . '/../View/view.php';
    }

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
        $view = 'inscription'; $pagetitle = 'Inscription'; require_once __DIR__ . '/../View/view.php';
    }

    public static function validerConnexion() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $ip = $_SERVER['REMOTE_ADDR'];

        $maxTentatives = 5;
        $fenetreMinutes = 10;

        $sql = "SELECT COUNT(*) AS nb FROM logs_connexions WHERE email_tente = ? AND ip_adresse = ? AND succes = 0 AND date_tentative >= (NOW() - INTERVAL ? MINUTE)";
        $stmt = DatabaseConnection::getPdo()->prepare($sql);
        $stmt->execute([$email, $ip, $fenetreMinutes]);
        $nbEchecs = (int)($stmt->fetch(PDO::FETCH_ASSOC)['nb'] ?? 0);

        if ($nbEchecs >= $maxTentatives) {
            $message_erreur = "Trop de tentatives. Réessayez dans quelques minutes.";
            $view = 'connexion'; $pagetitle = 'Connexion'; require_once __DIR__ . '/../View/view.php';
            return; 
        }

        $user = UtilisateurRepository::getByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['derniere_connexion'] = date('d/m/Y H:i'); 
            $_SESSION['message_flash'] = "Bienvenue, " . htmlspecialchars($user['username']);

            try { UtilisateurRepository::enregistrerLog($user['id_utilisateur'], $email, $ip, true); } catch (\Exception $e) { }

            header("Location: frontController.php?action=dashboard");
            exit();
        } else {
            try { 
                $id_fail = $user ? $user['id_utilisateur'] : null;
                UtilisateurRepository::enregistrerLog($id_fail, $email, $ip, false); 
            } catch (\Exception $e) { }

            $message_erreur = "Identifiants incorrects.";
            $view = 'connexion'; $pagetitle = 'Connexion'; require_once __DIR__ . '/../View/view.php';
        }
    }

    public static function deconnexion() {
        session_unset(); session_destroy(); session_start();
        $_SESSION['message_flash'] = "Vous avez été déconnecté.";
        header("Location: frontController.php?action=accueil");
        exit();
    }

    // ==========================================
    //          MOT DE PASSE OUBLIÉ
    // ==========================================

    public static function forgot_password() { $view = 'forgot_password'; $pagetitle = 'Mot de passe oublié'; require_once __DIR__ . '/../View/view.php'; }

    public static function send_reset_link() {
        $email = trim($_POST['email'] ?? '');
        $okMsg = "Si un compte existe, un lien de réinitialisation a été envoyé.";

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $user = UtilisateurRepository::getByEmail($email);
            if ($user) {
                $token = bin2hex(random_bytes(32));
                $token_hash = password_hash($token, PASSWORD_DEFAULT);
                $expires_at = (new DateTime('+30 minutes'))->format('Y-m-d H:i:s');

                UtilisateurRepository::creerResetMdp((int)$user['id_utilisateur'], $token_hash, $expires_at);

                $resetLink = "http://localhost/SAE_301/projet/web/frontController.php?action=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token);

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = Conf::getMailHost();
                    $mail->Port = Conf::getMailPort();
                    $mail->SMTPAuth = true;
                    $mail->Username = Conf::getMailUsername();
                    $mail->Password = Conf::getMailPassword();
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->setFrom(Conf::getMailUsername(), 'Support SAE 3-01');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = "Reinitialisation de mot de passe";
                    $mail->Body = "<p>Lien valide 30 minutes :</p><p><a href='{$resetLink}'>Réinitialiser mon mot de passe</a></p>";
                    $mail->send();
                } catch (\Exception $e) { }
            }
        }
        $_SESSION['message_flash'] = $okMsg;
        header("Location: frontController.php?action=forgot_password"); exit();
    }

    public static function reset_password() { $view = 'reset_password'; $pagetitle = 'Réinitialisation'; require_once __DIR__ . '/../View/view.php'; }

    public static function update_password() {
        $email = trim($_POST['email'] ?? '');
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        if ($password !== $password_confirm || strlen($password) < 8) {
            $_SESSION['message_erreur'] = "Mot de passe invalide (min 8 caractères).";
            header("Location: frontController.php?action=forgot_password"); exit();
        }

        $user = UtilisateurRepository::getByEmail($email);
        $reset = $user ? UtilisateurRepository::getDernierResetValide((int)$user['id_utilisateur']) : null;

        if ($reset && password_verify($token, $reset['token_hash']) && new DateTime() <= new DateTime($reset['expires_at'])) {
            UtilisateurRepository::updatePasswordHash((int)$user['id_utilisateur'], password_hash($password, PASSWORD_BCRYPT));
            UtilisateurRepository::marquerResetUtilise((int)$reset['id']);
            $_SESSION['message_flash'] = "Mot de passe modifié.";
            header("Location: frontController.php?action=connexion"); exit();
        }
        $_SESSION['message_erreur'] = "Lien invalide ou expiré.";
        header("Location: frontController.php?action=forgot_password"); exit();
    }

    // ==========================================
    //                LOGIQUE ADMIN
    // ==========================================

    public static function admin_users() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: FrontController.php?action=accueil"); exit();
        }

        $users = UtilisateurRepository::getAllUsers();
        $pdo = DatabaseConnection::getPdo();
        
        $logs = $pdo->query("SELECT a.*, u.username as admin_name FROM audit_logs a LEFT JOIN utilisateurs u ON a.user_id = u.id_utilisateur ORDER BY action_date DESC LIMIT 50")->fetchAll(PDO::FETCH_ASSOC);

        // --- CORRECTION JSON_DECODE NULL ---
        foreach ($logs as &$log) {
            // On utilise l'opérateur ?? pour envoyer une chaîne vide au lieu de NULL
            $old = json_decode($log['old_data'] ?? '{}', true);
            $new = json_decode($log['new_data'] ?? '{}', true);
            
            if ($log['action_type'] === 'UPDATE') {
                $log['details'] = "Rôle : " . ($old['role'] ?? '?') . " → " . ($new['role'] ?? '?');
            } else {
                $log['details'] = "Utilisateur supprimé : " . ($old['username'] ?? 'Inconnu');
            }
        }

        $view = 'admin_users'; $pagetitle = 'Administration & Audit'; require_once __DIR__ . '/../View/view.php';
    }

    public static function supprimerUser() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') { header("Location: FrontController.php?action=accueil"); exit(); }
        $id = $_GET['id'] ?? null;
        if ($id && $id != $_SESSION['user_id']) {
            UtilisateurRepository::supprimerUtilisateur($id);
            $_SESSION['message_flash'] = "Utilisateur supprimé.";
        }
        header("Location: FrontController.php?action=admin_users"); exit();
    }

    public static function changerRole(): void {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') { header("Location: frontController.php?action=accueil"); exit(); }
        $id = $_GET['id'] ?? null;
        if ((int)$id !== (int)$_SESSION['user_id'] && UtilisateurRepository::changeRole($id)) {
            $_SESSION['message_flash'] = "Rôle mis à jour.";
        } else {
            $_SESSION['message_flash'] = "Action impossible.";
        }
        header("Location: frontController.php?action=admin_users"); exit();
    }

    // ==========================================
    //              LOGIQUE CONTACT
    // ==========================================

    public static function envoyerContact() {
        $nom = $_POST['nom'] ?? 'Anonyme';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';

        if (!empty($email) && !empty($message)) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = Conf::getMailHost();
                $mail->Port = Conf::getMailPort();
                $mail->SMTPAuth = true;
                $mail->Username = Conf::getMailUsername();
                $mail->Password = Conf::getMailPassword();
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->setFrom(Conf::getMailUsername(), 'Formulaire de contact');
                $mail->addReplyTo($email, $nom);
                $mail->addAddress(Conf::getMailUsername());
                $mail->isHTML(true);
                $mail->Subject = "Contact SAE 301 de " . htmlspecialchars($nom);
                $mail->Body = "<h3>Message de " . htmlspecialchars($nom) . "</h3><p>" . nl2br(htmlspecialchars($message)) . "</p>";
                $mail->send();
                $_SESSION['message_flash'] = "Email envoyé !";
            } catch (\Exception $e) { $_SESSION['message_erreur'] = "Erreur d'envoi."; }
        }
        header("Location: FrontController.php?action=contact_propos"); exit();
    }
}