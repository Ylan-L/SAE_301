<?php

namespace App\Covoiturage\Model\DataObject;

class Resultat extends AbstractDataObject
{
    private int $idResultat;
    private string $serviceAnalyste;
    private string $libelleParametre;
    private string $uniteSymbole;
    private string $uniteLibelle;
    private float $valeur;
    private string $qualiteResultat;

    // 🔗 relation
    private Echantillon $echantillon;

    public function __construct(
        int $idResultat,
        string $serviceAnalyste,
        string $libelleParametre,
        string $uniteSymbole,
        string $uniteLibelle,
        float $valeur,
        string $qualiteResultat,
        Echantillon $echantillon
    ) {
        $this->idResultat = $idResultat;
        $this->serviceAnalyste = $serviceAnalyste;
        $this->libelleParametre = $libelleParametre;
        $this->uniteSymbole = $uniteSymbole;
        $this->uniteLibelle = $uniteLibelle;
        $this->valeur = $valeur;
        $this->qualiteResultat = $qualiteResultat;
        $this->echantillon = $echantillon;
    }

    /* ================= formatTableau ================= */

    public function formatTableau(): array
    {
        return [
            'id_resultat' => $this->idResultat,
            'service_analyste' => $this->serviceAnalyste,
            'libelle_parametre' => $this->libelleParametre,
            'unite_symbole' => $this->uniteSymbole,
            'unite_libelle' => $this->uniteLibelle,
            'valeur' => $this->valeur,
            'qualite_resultat' => $this->qualiteResultat,
            // FK
            'id_echantillon' => $this->echantillon->getIdEchantillon()
        ];
    }

    /* ================= GETTERS ================= */

    public function getIdResultat(): int {
        return $this->idResultat;
    }

    public function getEchantillon(): Echantillon {
        return $this->echantillon;
    }
}
