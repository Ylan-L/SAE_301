<?php
namespace App\Covoiturage\Model\DataObject;

class Prelevement extends AbstractDataObject{
    private int $idPrelevement;
    private string $servicePreleveur;
    private string $niveauPrelevement;
    private float $immersion;
    private string $uniteImmersion;
    private string $qualitePrelevement;
    
    private Passage $passage;

    public function __construct(int $idPrelevement,
        string $servicePreleveur,
        string $niveauPrelevement,
        float $immersion,
        string $uniteImmersion,
        string $qualitePrelevement,
        Passage $passage)
    {
        $this->idPrelevement = $idPrelevement;
        $this->servicePreleveur = $servicePreleveur;
        $this->niveauPrelevement = $niveauPrelevement;
        $this->immersion = $immersion;
        $this->uniteImmersion = $uniteImmersion;
        $this->qualitePrelevement = $qualitePrelevement;
        $this->passage = $passage;
    }

    /* ================= GETTERS ================= */

    public function getIdPrelevement(): int {
        return $this->idPrelevement;
    }

    public function getServicePreleveur(): string {
        return $this->servicePreleveur;
    }

    public function getNiveauPrelevement(): string {
        return $this->niveauPrelevement;
    }

    public function getImmersion(): float {
        return $this->immersion;
    }

    public function getUniteImmersion(): string {
        return $this->uniteImmersion;
    }

    public function getQualitePrelevement(): string {
        return $this->qualitePrelevement;
    }

    public function getPassage(): Passage {
        return $this->passage;
    }

    /* ================= SETTERS ================= */

    public function setServicePreleveur(string $servicePreleveur): void {
        $this->servicePreleveur = $servicePreleveur;
    }

    public function setNiveauPrelevement(string $niveauPrelevement): void {
        $this->niveauPrelevement = $niveauPrelevement;
    }

    public function setImmersion(float $immersion): void {
        $this->immersion = $immersion;
    }

    public function setUniteImmersion(string $uniteImmersion): void {
        $this->uniteImmersion = $uniteImmersion;
    }

    public function setQualitePrelevement(string $qualitePrelevement): void {
        $this->qualitePrelevement = $qualitePrelevement;
    }

    public function setPassage(Passage $passage): void {
        $this->passage = $passage;
    }


    public function formatTableau(): array{
    return [
            'id_prelevement' => $this->idPrelevement,
            'service_preleveur' => $this->servicePreleveur,
            'niveau_prelevement' => $this->niveauPrelevement,
            'immersion' => $this->immersion,
            'unite_immersion' => $this->uniteImmersion,
            'qualite_prelevement' => $this->qualitePrelevement,
            // FK
            'id_passage' => $this->passage->getIdPassage()
    ];}

}