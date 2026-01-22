<?php

namespace App\Covoiturage\Model\DataObject;

class LieuSurveillance extends AbstractDataObject
{
    private int $idLieu;
    private string $nomLieu;
    private string $typeLieu;

    // Relation
    private Zone $zone;

    public function __construct(
        int $idLieu,
        string $nomLieu,
        string $typeLieu,
        Zone $zone
    ) {
        $this->idLieu = $idLieu;
        $this->nomLieu = $nomLieu;
        $this->typeLieu = $typeLieu;
        $this->zone = $zone;
    }

    /* ================= formatTableau ================= */

    public function formatTableau(): array
    {
        return [
            'id_lieu' => $this->idLieu,
            'libelle_lieu' => $this->nomLieu,
            'entite_classement' => $this->typeLieu,
            // FK
            'id_zone' => $this->zone->getIdZone()
        ];
    }

    /* ================= GETTERS ================= */

    public function getIdLieu(): int {
        return $this->idLieu;
    }

    public function getZone(): Zone {
        return $this->zone;
    }

    public function getNomLieu(): string {
        return $this->nomLieu;
    }

    public function getTypeLieu(): string {
        return $this->typeLieu;
    }

}
