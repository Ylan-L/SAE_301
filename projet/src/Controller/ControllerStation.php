<?php

namespace App\Covoiturage\Controller;

use App\Covoiturage\Model\Repository\LieuSurveillanceRepository;
use App\Covoiturage\Model\Repository\PassageRepository;
use App\Covoiturage\Model\Repository\ResultatRepository;

class ControllerStation
{
    public static function station(): void
    {
        // --------------------
        // Repositories
        // --------------------
        $lieuRepo = new LieuSurveillanceRepository();
        $passageRepo = new PassageRepository();
        $resultatRepo = new ResultatRepository();

        // --------------------
        // Paramètres GET
        // --------------------
        $stationRecherchee = $_GET['station'] ?? null;
        $filtre = $_GET['filtre'] ?? 'temperature';
        $dateDebut = $_GET['dateDebut'] ?? '2021-01-01';
        $dateFin = $_GET['dateFin'] ?? '2022-01-01';

        // --------------------
        // CAS 1 : aucune station recherchée
        // --------------------
        if ($stationRecherchee === null || trim($stationRecherchee) === '') {

            $stations = $lieuRepo->getStationsAvecCoordonnees();

            $jsonStations = json_encode($stations);

            // variables utilisées dans la vue
            $stationDetails = null;
            $jsonStationData = null;

            require __DIR__ . '/../View/station.php';
            return;
        }

        // --------------------
        // CAS 2 : station recherchée
        // --------------------
        $station = $lieuRepo->rechercherParNom($stationRecherchee);

        // Si aucune station trouvée
        if ($station === null) {

            $stations = $lieuRepo->getStationsAvecCoordonnees();
            $jsonStations = json_encode($stations);

            $stationDetails = null;
            $jsonStationData = null;

            require __DIR__ . '/../View/station.php';
            return;
        }

        // --------------------
        // Coordonnées de la station
        // --------------------
        $coords = $passageRepo->getCoordonneesPourLieu($station->getIdLieu());
        $jsonStations = json_encode($coords);

        // --------------------
        // Données du graphique
        // --------------------
        $donneesGraph = $resultatRepo->getDonneesStation(
            $station->getIdLieu(),
            $filtre,
            $dateDebut,
            $dateFin
        );

        $jsonStationData = json_encode($donneesGraph);

        // --------------------
        // Détails station (pour la vue)
        // --------------------

        // REPRENDRE ICI MARIAM
        $stationDetails = [
            //'nom' => $station->getNomLieu(),
            'zone' => $station->getZone()->getNomZone(),
            //'type' => $station->getTypeLieu()
        ];

        require __DIR__ . '/../View/station.php';
    }
}
