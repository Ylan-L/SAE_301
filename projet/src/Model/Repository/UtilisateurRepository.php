<?php 
namespace App\Covoiturage\Model\Repository;
use App\Covoiturage\Model\Repository\DatabaseConnection ;
use App\Covoiturage\Model\DataObject\Utilisateur ;
use App\Covoiturage\Model\DataObject\AbstractDataObject;

use PDO;
use PDOException;



class UtilisateurRepository extends AbstractRepository{

    
    public function construire(array $utilisateurFormatTableau): AbstractDataObject {
            $user_id = $utilisateurFormatTableau["id_utilisateur"];
            $username = $utilisateurFormatTableau["username"];
            $email = $utilisateurFormatTableau["email"] ;
            $password_hash = $utilisateurFormatTableau["password_hash"];
            $role = $utilisateurFormatTableau["role"];
            $date_creation = $utilisateurFormatTableau["date_creation"];

            

            $utilisateur = new Utilisateur($user_id,$username, $email, $password_hash,$role, $date_creation);

            return $utilisateur;

    }

    protected function getNomTable():string{
      return "utilisateur";
    }

    protected function getNomClePrimaire(): string{
       return "id_utilisateur";
    }

    protected function getNomsColonnes(): array{
       return ["id_utilisateur","username","email","password_hash","role","date_creation"];
    }

     public static function getByEmail($email) {
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = DatabaseConnection::getPdo()->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public static function inscrire($username, $email, $password_hash) {
        try {
            $sql = "INSERT INTO utilisateurs (username, email, password_hash, role) VALUES (?, ?, ?, 'user')";
            return DatabaseConnection::getPdo()->prepare($sql)->execute([$username, $email, $password_hash]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function enregistrerLog($id, $email, $ip, $succes) {
        $sql = "INSERT INTO logs_connexions (utilisateur_id, email_tente, ip_adresse, date_tentative, succes) VALUES (?, ?, ?, NOW(), ?)";
        return DatabaseConnection::getPdo()->prepare($sql)->execute([$id, $email, $ip, $succes ? 1 : 0]);
    }
    public static function getAllUsers() {
        $sql = "SELECT id_utilisateur, username, email, role FROM utilisateurs";
        $stmt = DatabaseConnection::getPdo()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function supprimerUtilisateur($id_utilisateur) {
    try {
        $sql = "DELETE FROM utilisateurs WHERE id_utilisateur = ?";
        $stmt = DatabaseConnection::getPdo()->prepare($sql);
        return $stmt->execute([$id_utilisateur]);
    } catch (PDOException $e) {
        // Optionnel : logger l'erreur si besoin
        return false;
    }

    }

    public static function creerResetMdp($id_utilisateur, $token_hash, $expires_at) {
        $sql = "INSERT INTO password_resets (id_utilisateur, token_hash, expires_at)
                VALUES (?, ?, ?)";
        return DatabaseConnection::getPdo()->prepare($sql)->execute([$id_utilisateur, $token_hash, $expires_at]);
    }

    public static function getDernierResetValide($id_utilisateur) {
        $sql = "SELECT * FROM password_resets
                WHERE id_utilisateur = ? AND used_at IS NULL
                ORDER BY created_at DESC
                LIMIT 1";
        $stmt = DatabaseConnection::getPdo()->prepare($sql);
        $stmt->execute([$id_utilisateur]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function marquerResetUtilise($reset_id) {
        $sql = "UPDATE password_resets SET used_at = NOW() WHERE id = ?";
        return DatabaseConnection::getPdo()->prepare($sql)->execute([$reset_id]);
    }

    public static function updatePasswordHash($id_utilisateur, $password_hash) {
        $sql = "UPDATE utilisateurs SET password_hash = ? WHERE id_utilisateur = ?";
        return DatabaseConnection::getPdo()->prepare($sql)->execute([$password_hash, $id_utilisateur]);
    }

    public static function changerole($id_utilisateur): bool {
        $sqlSelect = "SELECT role FROM utilisateurs WHERE id_utilisateur = ?";
        $stmt = DatabaseConnection::getPdo()->prepare($sqlSelect);
        $stmt->execute([$id_utilisateur]);
        $user = $stmt->fetch();

        if ($user) {
            $nouveauRole = ($user['role'] === 'admin') ? 'user' : 'admin';

            $sqlUpdate = "UPDATE utilisateurs SET role = ? WHERE id_utilisateur = ?";
            return DatabaseConnection::getPdo()->prepare($sqlUpdate)->execute([$nouveauRole, $id_utilisateur]);
        }
        return false;
    }


    




    /**public static function getUtilisateurs(){
        //Création d'un tableau vide
        $tableau = [];
        // La requête SQL
        $sql = "SELECT * FROM utilisateur";
        // Appel de la fonction query pour récupérer les lignes du tableau
        $pdoStatement= DatabaseConnection::getPdo()->query($sql);
        // Chaque ligne est récupéré pour construire un objet utilisateur
        foreach ($pdoStatement as  $value) {
            $u = UtilisateurRepository::construire($value);
            $tableau[] = $u;
        }
        // L'objet est stocké dans le tableau qui est retourné à la fin
        return $tableau;
    } **/



}

?>