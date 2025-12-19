<?php 
namespace App\Covoiturage\Model\Repository;
use App\Covoiturage\Model\Repository\DatabaseConnection ;
use App\Covoiturage\Model\DataObject\Resultat ;
use PDO;


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


// ça c'est pour récupérer la moyenne des valeurs par zone pour l'affichage dans le graphique
public static function getMoyenneParZone(string $parametre): array {
    $sql = "SELECT z.nom_zone, AVG(r.valeur) as moyenne
            FROM resultat r
            JOIN echantillon e ON r.id_echantillon = e.id_echantillon
            JOIN prelevement p ON e.id_prelevement = p.id_prelevement
            JOIN passage pass ON p.id_passage = pass.id_passage
            JOIN lieu_surveillance l ON pass.id_lieu = l.id_lieu
            JOIN zone z ON l.id_zone = z.id_zone
            WHERE r.libelle_parametre = :param
            GROUP BY z.nom_zone";

    $db = DatabaseConnection::getPdo();
    $query = $db->prepare($sql);
    $query->execute(['param' => $parametre]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
//-----------------------------------------FIN DU TRUC GRAPHIQUE-----------------------------------------

}

?>