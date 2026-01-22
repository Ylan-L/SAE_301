<?php

namespace App\Covoiturage\Model\Repository;

use App\Covoiturage\Model\DataObject\LieuSurveillance;
use App\Covoiturage\Model\DataObject\AbstractDataObject;
use App\Covoiturage\Model\Repository\ZoneRepository;
use PDO;

class LieuSurveillanceRepository extends AbstractRepository
{
    /* ================= HERITAGE ================= */

    protected function getNomTable(): string
    {
        return 'lieu_surveillance';
    }

    protected function getNomClePrimaire(): string
    {
        return 'id_lieu';
    }

    protected function getNomsColonnes(): array
    {
        return [
            'id_lieu',
            'libelle_lieu',
            'entite_classement',
            'id_zone'
        ];
    }

    /* ================= CONSTRUCTION OBJET ================= */

    protected function construire(array $objetFormatTableau): AbstractDataObject
    {
        // 🔗 récupération de la zone
        $zoneRepository = new ZoneRepository();
        $zone = $zoneRepository->select($objetFormatTableau['id_zone']);

        return new LieuSurveillance(
            $objetFormatTableau['id_lieu'],
            $objetFormatTableau['libelle_lieu'],
            $objetFormatTableau['entite_classement'],
            $zone
        );
    }

    /* ================= PAGE STATION ================= */

    public function rechercherParNom(string $nom): ?LieuSurveillance {
        $sql = "
            SELECT *
            FROM lieu_surveillance
            WHERE libelle_lieu LIKE :nom
            LIMIT 1
        ";

        $pdo = DatabaseConnection::getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['nom' => "%$nom%"]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return $this->construire($row);
    }

    public function getStationsAvecCoordonnees(): array {
        $sql = "
            SELECT DISTINCT
                l.id_lieu,
                l.libelle_lieu,
                l.entite_classement,
                (p.minx + p.maxx) / 2 AS lng,
                (p.miny + p.maxy) / 2 AS lat
            FROM lieu_surveillance l
            JOIN passage p ON l.id_lieu = p.id_lieu
            JOIN zone z ON l.id_zone = z.id_zone
            WHERE l.id_zone = 2

        ";

        $pdo = DatabaseConnection::getPdo();
        $stmt = $pdo->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
