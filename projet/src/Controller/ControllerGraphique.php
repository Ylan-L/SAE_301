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

                $labelParts = [];
                if (!empty($ligne['libelle_lieu'])) {
                    $labelParts[] = $ligne['libelle_lieu'];
                }
                if (!empty($ligne['nom_zone'])) {
                    $labelParts[] = $ligne['nom_zone'];
                }

                $passages[$idPassage] = [
                    'lat' => $centerY,
                    'lng' => $centerX,
                    'label' => implode(' - ', $labelParts)
                ];
            }
        }

        // 5. Envoi à la vue
        $jsonAtl = json_encode($dataAtl);
        $jsonMed = json_encode($dataMed);
        $jsonPassages = json_encode(array_values($passages));
        
        $pagetitle = "Graphique - " . $titreGraphique;
        $view = "graphique"; 

        require __DIR__ . "/../View/view.php";
    }
}
