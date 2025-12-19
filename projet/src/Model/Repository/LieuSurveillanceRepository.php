<?php

namespace App\Covoiturage\Model\Repository;

use App\Covoiturage\Model\DataObject\LieuSurveillance;
use App\Covoiturage\Model\DataObject\AbstractDataObject;
use App\Covoiturage\Model\Repository\ZoneRepository;

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
            'nom_lieu',
            'type_lieu',
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
            $objetFormatTableau['nom_lieu'],
            $objetFormatTableau['type_lieu'],
            $zone
        );
    }
}
