<?php

namespace App\Covoiturage\Model\DataObject;

class Zone extends AbstractDataObject
{
    private int $idZone;
    private string $nomZone;
    private string $typeZone;

    public function __construct(
        int $idZone,
        string $nomZone,
        string $typeZone
    ) {
        $this->idZone = $idZone;
        $this->nomZone = $nomZone;
        $this->typeZone = $typeZone;
    }

    /* ================= formatTableau ================= */

    public function formatTableau(): array
    {
        return [
            'id_zone' => $this->idZone,
            'nom_zone' => $this->nomZone,
            'type_zone' => $this->typeZone
        ];
    }

    /* ================= GETTERS ================= */

    public function getIdZone(): int {
        return $this->idZone;
    }

    public function getNomZone(): string {
        return $this->nomZone;
    }

    public function getTypeZone(): string {
        return $this->typeZone;
    }
}
