<?php 
namespace App\Covoiturage\Model\Repository;
use App\Covoiturage\Model\Repository\DatabaseConnection ;
use App\Covoiturage\Model\DataObject\Utilisateur ;


class UtilisateurRepository extends AbstractRepository{

    
     public function construire(array $utilisateurFormatTableau) : Utilisateur {
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