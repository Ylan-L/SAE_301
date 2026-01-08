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

    /* =================METHODE GRAPHIQUE ================= */
    public function selectDonneesGraphique(string $libelleParametre, string $dateDebut, string $dateFin): array
    {
        // Jointure : Resultat -> Echantillon -> Prelevement -> Passage (Date) -> Lieu -> Zone
        $sql = "SELECT p.date_passage as date, r.valeur, z.nom_zone
                FROM resultat r
                JOIN echantillon e ON r.id_echantillon = e.id_echantillon
                JOIN prelevement pr ON e.id_prelevement = pr.id_prelevement
                JOIN passage p ON pr.id_passage = p.id_passage
                JOIN lieu_surveillance ls ON p.id_lieu = ls.id_lieu
                JOIN zone z ON ls.id_zone = z.id_zone
                WHERE r.libelle_parametre = :libelle
                AND p.date_passage >= :dateDebut 
                AND p.date_passage <= :dateFin
                ORDER BY p.date_passage ASC";
        
        $pdo = DatabaseConnection::getPdo(); 
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute([
            'libelle' => $libelleParametre,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin
        ]);

        return $pdoStatement->fetchAll();
    }
}
