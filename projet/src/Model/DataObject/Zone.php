<?php

namespace App\Covoiturage\Model\DataObject;

class Zone extends AbstractDataObject
{
    private int $idZone;
    private string $nomZone;

    public function __construct(
        int $idZone,
        string $nomZone
    ) {
        $this->idZone = $idZone;
        $this->nomZone = $nomZone;
    }

    /* ================= formatTableau ================= */

    public function formatTableau(): array
    {
        return [
            'id_zone' => $this->idZone,
            'nom_zone' => $this->nomZone
        ];
    }

    /* ================= GETTERS ================= */

    public function getIdZone(): int {
        return $this->idZone;
    }

    public function getNomZone(): string {
        return $this->nomZone;
    }
}
