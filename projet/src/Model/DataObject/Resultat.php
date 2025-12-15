<?php
namespace App\Covoiturage\Model\DataObject;

class Resultat extends AbstractDataObject{
    private int $idResultat;
    private string $serviceAnalyste;
    private string $libelleParametre;
    private string $uniteSymbole;
    private string $uniteLibelle;
    private float $valeur;
    private string $qualiteResultat;
    private int $idEchantillon;


    public function getIdResultat(): int
    {
        return $this->idResultat;
    }

    public function getServiceAnalyste(): string
    {
        return $this->serviceAnalyste;
    }

    public function setServiceAnalyste(string $serviceAnalyste): void
    {
        $this->serviceAnalyste = $serviceAnalyste;
    }

    public function getLibelleParametre(): string
    {
        return $this->libelleParametre;
    }

    public function setLibelleParametre(string $libelleParametre): void
    {
        $this->libelleParametre = $libelleParametre;
    }

    public function getUniteSymbole(): string
    {
        return $this->uniteSymbole;
    }

    public function getUniteLibelle(): string
    {
        return $this->uniteLibelle;
    }

    public function getValeur(): float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): void
    {
        $this->valeur = $valeur;
    }

    public function getQualiteResultat(): string
    {
        return $this->qualiteResultat;
    }

    public function getIdEchantillon(): int
    {
        return $this->idEchantillon;
    }

    public function formatTableau(): array{
    return [
        "id_resultat"=> $this->getIdResultat(),
        "service_analyste" => $this->getServiceAnalyste(),
        "libelle_parametre" => $this->getLibelleParametre(),
        "unite_symbole" => $this->getUniteSymbole(),
        "unite_libelle" => $this->getUniteLibelle(),
        "valeur" => $this->getValeur(),
        "qualite_resultat" => $this->getQualiteResultat(),
        "id_echantillon" => $this->getIdEchantillon(),
    ];}

}