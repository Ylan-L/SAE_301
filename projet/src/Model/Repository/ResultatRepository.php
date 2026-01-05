<?php

namespace App\Covoiturage\Model\Repository;

use App\Covoiturage\Model\DataObject\Resultat;
use App\Covoiturage\Model\DataObject\AbstractDataObject;
use App\Covoiturage\Model\Repository\EchantillonRepository;

class ResultatRepository extends AbstractRepository
{
    /* ================= HERITAGE ================= */

    protected function getNomTable(): string
    {
        return 'resultat';
    }

    protected function getNomClePrimaire(): string
    {
        return 'id_resultat';
    }

    protected function getNomsColonnes(): array
    {
        return [
            'id_resultat',
            'service_analyste',
            'libelle_parametre',
            'unite_symbole',
            'unite_libelle',
            'valeur',
            'qualite_resultat',
            'id_echantillon'
        ];
    }

    /* ================= CONSTRUCTION OBJET ================= */

    protected function construire(array $objetFormatTableau): AbstractDataObject
    {
        // Récupération de l’échantillon
        $echantillonRepository = new EchantillonRepository();
        $echantillon = $echantillonRepository->select($objetFormatTableau['id_echantillon']);

        return new Resultat(
            $objetFormatTableau['id_resultat'],
            $objetFormatTableau['service_analyste'],
            $objetFormatTableau['libelle_parametre'],
            $objetFormatTableau['unite_symbole'],
            $objetFormatTableau['unite_libelle'],
            (float)$objetFormatTableau['valeur'],
            $objetFormatTableau['qualite_resultat'],
            $echantillon
        );
    }
}
