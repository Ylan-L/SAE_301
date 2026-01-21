<?php

namespace App\Covoiturage\Model\Repository;

use App\Covoiturage\Model\DataObject\Resultat;
use App\Covoiturage\Model\DataObject\AbstractDataObject;
use App\Covoiturage\Model\Repository\EchantillonRepository;
use PDO;

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

    /* ================= METHODE GRAPHIQUE ================= */

    public function selectDonneesGraphique(string $libelleParametre, string $dateDebut, string $dateFin): array
    {
        // Jointure : Resultat -> Echantillon -> Prelevement -> Passage (Date) -> Lieu -> Zone
        $sql = "SELECT p.id_passage, p.date_passage as date, r.valeur, z.nom_zone,
                       p.minx, p.maxx, p.miny, p.maxy, ls.libelle_lieu
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

    public function getDonneesStation(
        int $idLieu,
        string $parametre,
        string $dateDebut,
        string $dateFin
    ): array {
        $sql = "
            SELECT 
                p.date_passage AS x,
                r.valeur AS y
            FROM resultat r
            JOIN echantillon e ON r.id_echantillon = e.id_echantillon
            JOIN prelevement pr ON e.id_prelevement = pr.id_prelevement
            JOIN passage p ON pr.id_passage = p.id_passage
            WHERE p.id_lieu = :idLieu
            AND r.libelle_parametre = :param
            AND p.date_passage BETWEEN :debut AND :fin
            ORDER BY p.date_passage
        ";

        $pdo = DatabaseConnection::getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'idLieu' => $idLieu,
            'param'  => ucfirst($parametre),
            'debut'  => $dateDebut,
            'fin'    => $dateFin
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllByIndicateur(string $libelleParametre): array {
    $sql = "SELECT 
                p.date_passage AS date,
                z.nom_zone,
                ls.libelle_lieu,
                r.valeur
            FROM resultat r
            JOIN echantillon e ON r.id_echantillon = e.id_echantillon
            JOIN prelevement pr ON e.id_prelevement = pr.id_prelevement
            JOIN passage p ON pr.id_passage = p.id_passage
            JOIN lieu_surveillance ls ON p.id_lieu = ls.id_lieu
            JOIN zone z ON ls.id_zone = z.id_zone
            WHERE r.libelle_parametre = :libelle
            ORDER BY p.date_passage ASC";

    $stmt = DatabaseConnection::getPdo()->prepare($sql);
    $stmt->execute(['libelle' => $libelleParametre]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    /* ================= METHODE STATION ================= */
    public function getDisponibilitesStation(int $idLieu): array
    {
        $sql = "
            SELECT
                r.libelle_parametre AS indicateur,
                MIN(p.date_passage) AS date_debut,
                MAX(p.date_passage) AS date_fin,
                COUNT(*) AS nb_valeurs
            FROM resultat r
            JOIN echantillon e ON r.id_echantillon = e.id_echantillon
            JOIN prelevement pr ON e.id_prelevement = pr.id_prelevement
            JOIN passage p ON pr.id_passage = p.id_passage
            WHERE p.id_lieu = :id_lieu
            GROUP BY r.libelle_parametre
            ORDER BY r.libelle_parametre
        ";

        $pdo = DatabaseConnection::getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_lieu' => $idLieu]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


}
