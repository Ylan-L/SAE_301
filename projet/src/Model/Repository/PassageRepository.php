<?php

namespace App\Covoiturage\Model\Repository;

use App\Covoiturage\Model\DataObject\Passage;
use App\Covoiturage\Model\DataObject\AbstractDataObject;
use App\Covoiturage\Model\Repository\LieuSurveillanceRepository;

class PassageRepository extends AbstractRepository
{
    /* ================= HERITAGE ================= */

    protected function getNomTable(): string
    {
        return 'passage';
    }

    protected function getNomClePrimaire(): string
    {
        return 'id_passage';
    }

    protected function getNomsColonnes(): array
    {
        return [
            'id_passage',
            'date_passage',
            'minx',
            'maxx',
            'miny',
            'maxy',
            'id_lieu'
        ];
    }

    /* ================= CONSTRUCTION OBJET ================= */

    protected function construire(array $objetFormatTableau): AbstractDataObject
    {
        // 🔗 récupération du lieu de surveillance
        $lieuRepository = new LieuSurveillanceRepository();
        $lieuSurveillance = $lieuRepository->select($objetFormatTableau['id_lieu']);

        return new Passage(
            $objetFormatTableau['id_passage'],
            $objetFormatTableau['date_passage'],
            (float)$objetFormatTableau['minx'],
            (float)$objetFormatTableau['maxx'],
            (float)$objetFormatTableau['miny'],
            (float)$objetFormatTableau['maxy'],
            $lieuSurveillance
        );
    }
}
