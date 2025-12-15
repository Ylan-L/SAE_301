<?php 
namespace App\Covoiturage\Model\Repository;
use App\Covoiturage\Model\Repository\DatabaseConnection ;
use App\Covoiturage\Model\DataObject\Resultat ;


class ResultatRepository extends AbstractRepository{

    
     public function construire(array $zoneFormatTableau) : Resultat {
            $id_resultat = $zoneFormatTableau["id_resultat"];
            $service_analyste = $zoneFormatTableau["service_analyste"];
            $libelle_parametre = $zoneFormatTableau["libelle_parametre"];
            $unite_symbole = $zoneFormatTableau["unite_symbole"];
            $unite_libelle = $zoneFormatTableau["unite_libelle"];
            $valeur = $zoneFormatTableau["valeur"];
            $qualite_resultat = $zoneFormatTableau["qualite_resultat"];
            $id_echantillon = $zoneFormatTableau["id_echantillon"];
         
            
            $resultat = new Resultat($id_resultat,$service_analyste,$libelle_parametre,$unite_symbole,$unite_libelle,$valeur,$qualite_resultat,$id_echantillon);

            return $resultat;

    }

    protected function getNomTable():string{
      return "resultat";
    }

    protected function getNomClePrimaire(): string{
       return "id_ resultat";
    }

    protected function getNomsColonnes(): array{
       return ["id_resultat","service_analyste","libelle_parametre","unite_symbole","unite_libelle","valeur","qualite_resultat","id_echantillon"];
    }

}

?>