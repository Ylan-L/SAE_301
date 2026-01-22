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
                $titreGraphique = 'Moyenne de Salinité (sans unité)';
                break;
            case 'phytoplanctons':
                $nomParametreBDD = 'Chlorophylle a';
                $titreGraphique = 'Moyenne de Chlorophylle a (µg/L)';
                break;
            case 'temperature':
            default:
                $nomParametreBDD = 'Température de l\'eau';
                $titreGraphique = 'Température moyenne de l\'eau (°C)';
                $filtre = 'temperature'; 
                break;
        }

        // 3. Récupération des données OPTIMISÉE
        $repository = new ResultatRepository();
        $donneesAgregees = $repository->selectMoyennesParStation($nomParametreBDD, $dateDebut, $dateFin);

        // 4. Préparation simple pour la Vue
        $labelsStations = [];
        $dataStations = [];
        $passages = []; 

        foreach ($donneesAgregees as $ligne) {
            // A. Pour le Graphique (Barres)
            $labelsStations[] = $ligne['libelle_lieu'];
            $dataStations[] = round((float)$ligne['moyenne'], 2);

            // B. Pour la Carte (Un seul point par station)
            if ($ligne['lat'] !== null && $ligne['lng'] !== null) {
                $passages[] = [
                    'lat' => (float)$ligne['lat'],
                    'lng' => (float)$ligne['lng'],
                    'label' => $ligne['libelle_lieu'] . " : " . round((float)$ligne['moyenne'], 2)
                ];
            }
        }

        // 5. Encodage JSON (Inchangé)
        $jsonLabels = json_encode($labelsStations);
        $jsonData = json_encode($dataStations);
        $jsonPassages = json_encode($passages);
        
        $pagetitle = "Graphique - " . $titreGraphique;
        $view = "graphique"; 

        require __DIR__ . "/../View/view.php";
    }
}
