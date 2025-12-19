<?php

namespace App\Covoiturage\Model\Repository;

use App\Covoiturage\Model\DataObject\Zone;
use App\Covoiturage\Model\DataObject\AbstractDataObject;

class ZoneRepository extends AbstractRepository
{
    /* ================= HERITAGE ================= */

    protected function getNomTable(): string
    {
        return 'zone';
    }

    protected function getNomClePrimaire(): string
    {
        return 'id_zone';
    }

    protected function getNomsColonnes(): array
    {
        return [
            'id_zone',
            'nom_zone',
            'type_zone'
        ];
    }

    /* ================= CONSTRUCTION OBJET ================= */

    protected function construire(array $objetFormatTableau): AbstractDataObject
    {
        return new Zone(
            $objetFormatTableau['id_zone'],
            $objetFormatTableau['nom_zone'],
            $objetFormatTableau['type_zone']
        );
    }
}
