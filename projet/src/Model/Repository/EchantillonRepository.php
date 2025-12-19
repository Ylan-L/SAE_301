<?php

namespace App\Covoiturage\Model\Repository;

use App\Covoiturage\Model\DataObject\Echantillon;
use App\Covoiturage\Model\DataObject\AbstractDataObject;
use App\Covoiturage\Model\Repository\PrelevementRepository;

class EchantillonRepository extends AbstractRepository
{
    /* ================= HERITAGE ================= */

    protected function getNomTable(): string
    {
        return 'echantillon';
    }

    protected function getNomClePrimaire(): string
    {
        return 'id_echantillon';
    }

    protected function getNomsColonnes(): array
    {
        return [
            'id_echantillon',
            'qualite_echantillon',
            'id_prelevement'
        ];
    }

    /* ================= CONSTRUCTION OBJET ================= */

    protected function construire(array $objetFormatTableau): AbstractDataObject
    {
        // 🔗 récupération du prélèvement
        $prelevementRepository = new PrelevementRepository();
        $prelevement = $prelevementRepository->select($objetFormatTableau['id_prelevement']);

        return new Echantillon(
            $objetFormatTableau['id_echantillon'],
            $objetFormatTableau['qualite_echantillon'],
            $prelevement
        );
    }
}
