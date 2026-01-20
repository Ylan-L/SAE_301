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

        // 3. Récupération des données
        $repository = new ResultatRepository();
        $donneesBrutes = $repository->selectDonneesGraphique($nomParametreBDD, $dateDebut, $dateFin);

        // 4. Calcul de la moyenne par STATION
        $tempStations = [];
        $passages = [];

        foreach ($donneesBrutes as $ligne) {
            $point = ['x' => $ligne['date'], 'y' => $ligne['valeur']];

            // LOGIQUE INFAILLIBLE : On cherche "Manche"
            $valeur = (float)$ligne['valeur'];
            $nomLieu = $ligne['libelle_lieu'];

             // Calcul Moyenne
            if (!isset($tempStations[$nomLieu])) {
                $tempStations[$nomLieu] = ['sum' => 0, 'count' => 0];
            }
            $tempStations[$nomLieu]['sum'] += $valeur;
            $tempStations[$nomLieu]['count']++;

            // Données Carte
            $idPassage = $ligne['id_passage'];
            if (!isset($passages[$idPassage])) {
                $passages[$idPassage] = [
                    'lat' => ((float)$ligne['miny'] + (float)$ligne['maxy']) / 2,
                    'lng' => ((float)$ligne['minx'] + (float)$ligne['maxx']) / 2,
                    'label' => $nomLieu . " : " . $valeur
                ];
            }
        }

        // 5. Préparation pour Chart.js
        $labelsStations = [];
        $dataStations = [];

        ksort($tempStations); // On trie les stations par ordre alphabétique

        ksort($tempStations); // On trie les stations par ordre alphabétique
        
        foreach ($tempStations as $lieu => $stats) {
            $labelsStations[] = $lieu;
            // On arrondit à 2 chiffres après la virgule
            $dataStations[] = round($stats['sum'] / $stats['count'], 2);
        }

        // Encodage JSON
        $jsonLabels = json_encode($labelsStations);
        $jsonData = json_encode($dataStations);
        $jsonPassages = json_encode(array_values($passages));
        
        $pagetitle = "Graphique - " . $titreGraphique;
        $view = "graphique"; 

        require __DIR__ . "/../View/view.php";
    }




}
