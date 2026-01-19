<?php

namespace App\Covoiturage\Controller;

use App\Covoiturage\Model\Repository\ResultatRepository;

class ControllerGraphique
{
    public static function afficher()
    {
        // 1. Filtres
        $filtre = $_GET['filtre'] ?? 'temperature';
        $dateDebut = $_GET['dateDebut'] ?? '2021-01-01';
        $dateFin = $_GET['dateFin'] ?? '2022-01-01';

        $nomParametreBDD = '';
        $titreGraphique = '';

        // 2. Mapping
        switch ($filtre) {
            case 'salinite':
                $nomParametreBDD = 'Salinité';
                $titreGraphique = 'Salinité (sans unité)';
                break;
            case 'phytoplanctons':
                $nomParametreBDD = 'Chlorophylle a';
                $titreGraphique = 'Concentration en Chlorophylle a (µg/L)';
                break;
            case 'temperature':
            default:
                $nomParametreBDD = 'Température de l\'eau';
                $titreGraphique = 'Température de l\'eau (°C)';
                $filtre = 'temperature'; 
                break;
        }

        // 3. Récupération des données
        $repository = new ResultatRepository();
        $donneesBrutes = $repository->selectDonneesGraphique($nomParametreBDD, $dateDebut, $dateFin);

        // 4. Tri des données
        $dataAtl = [];
        $dataMed = [];
        $passages = [];

        foreach ($donneesBrutes as $ligne) {
            $point = ['x' => $ligne['date'], 'y' => $ligne['valeur']];

            // LOGIQUE INFAILLIBLE : On cherche "Manche"
            if (strpos($ligne['nom_zone'], 'Manche') !== false) {
                // C'est la Manche / Atlantique
                $dataAtl[] = $point;
            } else {
                // Tout le reste, c'est la Méditerranée
                $dataMed[] = $point;
            }

            $idPassage = $ligne['id_passage'];
            if (!isset($passages[$idPassage])) {
                $minx = (float)$ligne['minx'];
                $maxx = (float)$ligne['maxx'];
                $miny = (float)$ligne['miny'];
                $maxy = (float)$ligne['maxy'];
                $centerX = ($minx + $maxx) / 2;
                $centerY = ($miny + $maxy) / 2;

                $passages[$idPassage] = [
                    'lat' => $centerY,
                    'lng' => $centerX,
                    'lieu' => $ligne['libelle_lieu'] ?? '',
                    'zone' => $ligne['nom_zone'] ?? '',
                    'sum' => (float)$ligne['valeur'],
                    'count' => 1
                ];
            } else {
                $passages[$idPassage]['sum'] += (float)$ligne['valeur'];
                $passages[$idPassage]['count'] += 1;
            }
        }

        // 5. Envoi à la vue
        $jsonAtl = json_encode($dataAtl);
        $jsonMed = json_encode($dataMed);

        $passagesForJson = [];
        foreach ($passages as $passage) {
            $labelParts = [];
            if (!empty($passage['lieu'])) {
                $labelParts[] = $passage['lieu'];
            }
            if (!empty($passage['zone'])) {
                $labelParts[] = $passage['zone'];
            }
            if ($passage['count'] > 0) {
                $average = $passage['sum'] / $passage['count'];
                $labelParts[] = 'Valeur: ' . round($average, 2);
            }

            $passagesForJson[] = [
                'lat' => $passage['lat'],
                'lng' => $passage['lng'],
                'label' => implode(' - ', $labelParts)
            ];
        }

        $jsonPassages = json_encode($passagesForJson);
        
        $pagetitle = "Graphique - " . $titreGraphique;
        $view = "graphique"; 

        require __DIR__ . "/../View/view.php";
    }

   public static function export_csv(){
    if (!isset($_SESSION['user_id'])) {
        header("Location: frontController.php?action=connexion");
        exit();
    }

    // 1) Récupère le choix
    $indicateur = $_GET['indicateur'] ?? '';

    // 2) Map indicateur -> libellé BD
    $map = [
        'temperature' => "Température de l'eau",
        'salinite' => "Salinité",
        'phytoplanctons' => "Chlorophylle a"
    ];

    if (!isset($map[$indicateur])) {
        $_SESSION['message_flash'] = "Indicateur invalide.";
        header("Location: frontController.php?action=graphique");
        exit();
    }

    $libelleBD = $map[$indicateur];

    // 3) Récupérer toutes les données
    $rows = ResultatRepository::getAllByIndicateur($libelleBD);

    // 4) Préparer téléchargement CSV
    $filename = "donnees_" . $indicateur . ".csv";

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // BOM UTF-8 (Excel)
    echo "\xEF\xBB\xBF";

    $out = fopen('php://output', 'w');

    // En-têtes CSV
    fputcsv($out, ['date', 'zone', 'lieu', 'valeur'], ';');

    foreach ($rows as $r) {
        fputcsv($out, [
            $r['date'] ?? '',
            $r['nom_zone'] ?? '',
            $r['libelle_lieu'] ?? '',
            $r['valeur'] ?? ''
        ], ';');
    }

    fclose($out);
    exit();
    }


}
