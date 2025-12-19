<?php
namespace App\Covoiturage\Model\DataObject;

class Echantillon extends AbstractDataObject{
    private int $idEchantillon;
    private string $qualiteEchantillon;
    private Prelevement $prelevement;

    public function __construct(int $idEchantillon, string $qualiteEchantillon, Prelevement $Prelevement) {
        $this->idEchantillon = $idEchantillon;
        $this->qualiteEchantillon = $qualiteEchantillon;
        $this->Prelevement = $prelevement;
    }

    #------------Getter---------------
    public function getIdEchantillon(): int {
        return $this->idEchantillon;
    }

    public function getQualiteEchantillon(): string {
        return $this->qualiteEchantillon;
    }

    public function getPrelevement() : Prelevement {
        return $this->prelevement;
    }
    
    #------------Setter---------------
    public function setIdEchantillon(int $idEchantillon): void {
        $this->idEchantillon = $idEchantillon;
    }

    public function setQualiteEchantillon(string $qualiteEchantillon): void {
        $this->qualiteEchantillon = $qualiteEchantillon;
    }

    public function setPrelevement(Prelevement $prelevement) : void {
        $this->prelevement = $prelevement;
    }

    public function formatTableau(): array{
    return [
        "id_Echantillon"=> $this->getIdEchantillon(),
        "qualite_Echantillon" => $this->getQualiteEchantillon(),
        "prelevement" => $this->getPrelevement(),
    ];}
}
