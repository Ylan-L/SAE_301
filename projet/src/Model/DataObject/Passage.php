<?php

namespace App\Covoiturage\Model\DataObject;

class Passage extends AbstractDataObject
{
    private int $idPassage;
    private string $datePassage;
    private float $minx;
    private float $maxx;
    private float $miny;
    private float $maxy;

    // Relation
    private LieuSurveillance $lieuSurveillance;

    public function __construct(
        int $idPassage,
        string $datePassage,
        float $minx,
        float $maxx,
        float $miny,
        float $maxy,
        LieuSurveillance $lieuSurveillance
    ) {
        $this->idPassage = $idPassage;
        $this->datePassage = $datePassage;
        $this->minx = $minx;
        $this->maxx = $maxx;
        $this->miny = $miny;
        $this->maxy = $maxy;
        $this->lieuSurveillance = $lieuSurveillance;
    }

    /* ================= formatTableau ================= */

    public function formatTableau(): array
    {
        return [
            'id_passage' => $this->idPassage,
            'date_passage' => $this->datePassage,
            'minx' => $this->minx,
            'maxx' => $this->maxx,
            'miny' => $this->miny,
            'maxy' => $this->maxy,
            // FK
            'id_lieu' => $this->lieuSurveillance->getIdLieu()
        ];
    }

    /* ================= GETTERS ================= */

    public function getIdPassage(): int {
        return $this->idPassage;
    }

    public function getDatePassage(): string {
        return $this->datePassage;
    }

    public function getMinx(): float {
        return $this->minx;
    }

    public function getMaxx(): float {
        return $this->maxx;
    }

    public function getMiny(): float {
        return $this->miny;
    }

    public function getMaxy(): float {
        return $this->maxy;
    }

    public function getLieuSurveillance(): LieuSurveillance {
        return $this->lieuSurveillance;
    }
}
