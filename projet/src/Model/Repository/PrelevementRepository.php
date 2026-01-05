<?php

namespace App\Covoiturage\Model\Repository;

use App\Covoiturage\Model\DataObject\Prelevement;
use App\Covoiturage\Model\Repository\PassageRepository;
use App\Covoiturage\Model\DataObject\AbstractDataObject;

class PrelevementRepository extends AbstractRepository
{
    /* ================= HERITAGE ================= */

    protected function getNomTable(): string { 
        return 'prelevement';
    }

    protected function getNomClePrimaire(): string {
        return 'id_prelevement';
    }

    protected function getNomsColonnes(): array {
        return [
            'id_prelevement',
            'service_preleveur',
            'niveau_prelevement',
            'immersion',
            'unite_immersion',
            'qualite_prelevement',
            'id_passage'
        ];
    }

    /* ================= CONSTRUCTION OBJET ================= */

    protected function construire(array $objetFormatTableau): AbstractDataObject
    {
        // 🔗 récupération du passage via son repository
        $passageRepository = new PassageRepository();
        $passage = $passageRepository->select($objetFormatTableau['id_passage']);

        return new Prelevement(
            $objetFormatTableau['id_prelevement'],
            $objetFormatTableau['service_preleveur'],
            $objetFormatTableau['niveau_prelevement'],
            (float)$objetFormatTableau['immersion'],
            $objetFormatTableau['unite_immersion'],
            $objetFormatTableau['qualite_prelevement'],
            $passage
        );
    }
}
