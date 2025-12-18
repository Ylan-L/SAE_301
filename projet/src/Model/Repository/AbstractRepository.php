<?php
namespace App\Covoiturage\Model\Repository;
use App\Covoiturage\Model\DataObject\AbstractDataObject;

abstract class AbstractRepository {

    public function selectAll(){
        //Création d'un tableau vide
        $tableau = [];
        // La requête SQL
        $sql = "SELECT * FROM " . $this->getNomTable();
        // Appel de la fonction query pour récupérer les lignes du tableau
        $pdoStatement= DatabaseConnection::getPdo()->query($sql);
        // Chaque ligne est récupéré pour construire un objet Voiture
        foreach ($pdoStatement as  $value) {
            $v = $this->construire($value);
            $tableau[] = $v;
        }
        // L'objet est stocké dans le tableau qui est retourné à la fin
        return $tableau;
    }

    public function select(string $valeurClePrimaire): ?AbstractDataObject{
        $sql ="SELECT * FROM " . $this->getNomTable() ." WHERE " . $this->getNomClePrimaire() . " = :cleprimaireTag";
        // Préparation de la requête
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql); 

        $values = array( 
            "cleprimaireTag" => $valeurClePrimaire,
        //nomdutag => valeur, ... 
        );
        // On donne les valeurs et on exécute la requête 
        $pdoStatement->execute($values); 
        
        // On récupère les résultats comme précédemment 
        // Note: fetch() renvoie false si pas de voiture correspondante 
        $voiture = $pdoStatement->fetch(); 

        //si il n’existe pas de voiture d’immatriculation $immatriculation, la fonction retourne null
        if($voiture == false){
            return null;
        }
        
        return $this->construire($voiture); 
    }
    public function delete($valeurClePrimaire) : void {
        $sql ="DELETE FROM " . $this->getNomTable() ." WHERE " . $this->getNomClePrimaire() . " = :cleprimaireTag";
        // Préparation de la requête
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql); 

        $values = array( 
            "cleprimaireTag" => $valeurClePrimaire,
        //nomdutag => valeur, ... 
        );
        // On donne les valeurs et on exécute la requête 
        $pdoStatement->execute($values);     
        
    }
    public function update(AbstractDataObject $objet): void{
        $colonnes = $this->getNomsColonnes();
        $partieSet = '';
        foreach ($colonnes as $colonne) {
        if ($colonne === $this->getNomClePrimaire()) continue;

        if ($partieSet !== '') {
            $partieSet .= ', ';
        }

        $partieSet .= "$colonne = :$colonne";
        }

        $sql = "UPDATE " . $this->getNomTable() .
           " SET " . $partieSet .
           " WHERE " . $this->getNomClePrimaire() . " = :" . $this->getNomClePrimaire();
             
        // Préparation de la requête
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql); 

        $values = $objet->formatTableau();
        // On donne les valeurs et on exécute la requête 
        $pdoStatement->execute($values); 

    }

    public function save(AbstractDataObject $objet): void{
        $colonnes = $this->getNomsColonnes(); // 4 colonnes, dont immatriculation
        $colonnesAInserer = [];
        $tagsAInserer = [];

        foreach ($colonnes as $colonne) {
            // AUCUNE EXCLUSION !
            $colonnesAInserer[] = $colonne;
            $tagsAInserer[] = ":$colonne";
        }

        $listColonnes = implode(', ', $colonnesAInserer);
        $listColonnesTag = implode(', ', $tagsAInserer);

        $sql = "INSERT INTO " . $this->getNomTable() .
            " ($listColonnes) VALUES ($listColonnesTag)";
             
        // Préparation de la requête
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql); 

        $values = $objet->formatTableau();
        // On donne les valeurs et on exécute la requête 
        $pdoStatement->execute($values); 

    }



    protected abstract function getNomTable(): string;
    protected abstract function construire(array $objetFormatTableau) : AbstractDataObject;
    protected abstract function getNomClePrimaire(): string;

    protected abstract function getNomsColonnes(): array;

    
}

?>