<?php 
namespace App\Covoiturage\Model\Repository;
use App\Covoiturage\Model\Repository\DatabaseConnection ;
use App\Covoiturage\Model\DataObject\Zone ;


class ZoneRepository extends AbstractRepository{

    
     public function construire(array $zoneFormatTableau) : Zone {
            $id_zone = $zoneFormatTableau["id_zone"];
            $nom_zone = $zoneFormatTableau["nom_zone"];
         
            
            $zone = new Zone($id_zone,$nom_zone);

            return $zone;

    }

    protected function getNomTable():string{
      return "zone";
    }

    protected function getNomClePrimaire(): string{
       return "id_zone";
    }

    protected function getNomsColonnes(): array{
       return ["id_zone","nom_zone"];
   }






}

?>