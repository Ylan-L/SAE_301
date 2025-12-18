<?php 
namespace App\Covoiturage\Model\Repository;
use App\Covoiturage\Model\Repository\DatabaseConnection ;
use App\Covoiturage\Model\DataObject\Resultat ;


class EchantillonRepository extends AbstractRepository{

    
     public function construire(array $zoneFormatTableau) : Echantillon {
            $id_echantillon = $zoneFormatTableau["id_echantillon"];
            $qualite_echantillon = $zoneFormatTableau["qualite_echantillon"];
            $prelevement = $zoneFormatTableau["prelevement"];
         
            
            $echantillon = new Echantillon($id_echantillon,$qualite_echantillon,$prelevement);

            return $echantillon;
    }
    protected function getNomTable():string{
      return "echantillon";
    }
    protected function getNomClePrimaire(): string{
       return "id_echantillon";
    }
    protected function getNomsColonnes(): array{
       return ["id_echantillon","qualite_echantillon","prelevement"];
    }
}