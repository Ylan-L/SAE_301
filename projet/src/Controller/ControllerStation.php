<?php

namespace App\Covoiturage\Controller;

use App\Covoiturage\Model\Repository\LieuSurveillanceRepository;
use App\Covoiturage\Model\Repository\PassageRepository;
use App\Covoiturage\Model\Repository\ResultatRepository;

class ControllerStation
{
    public static function station(): void
    {
        $lieuRepo = new \App\Covoiturage\Model\Repository\LieuSurveillanceRepository();
        $passageRepo = new \App\Covoiturage\Model\Repository\PassageRepository();
        $resultatRepo = new \App\Covoiturage\Model\Repository\ResultatRepository();

        // --------------------
        // Paramètres GET
        // --------------------
        $stationRecherchee = $_GET['station'] ?? null;
        $filtre = $_GET['filtre'] ?? 'temperature';
        $dateDebut = $_GET['dateDebut'] ?? '2021-01-01';
        $dateFin = $_GET['dateFin'] ?? '2022-01-01';

        // --------------------
        // CAS 1 : aucune recherche
        // --------------------
        if ($stationRecherchee === null || trim($stationRecherchee) === '') {

            $stations = $lieuRepo->getStationsAvecCoordonnees();
            $jsonStations = json_encode($stations);

            $stationDetails = null;
            $jsonStationData = null;

            $view = 'station'; 
            $pagetitle = 'Station';
            require __DIR__ . '/../View/view.php';
            return;
        }

        // --------------------
        // CAS 2 : station recherchée
        // --------------------
        $station = $lieuRepo->rechercherParNom($stationRecherchee);

        if ($station === null) {
            $stations = $lieuRepo->getStationsAvecCoordonnees();
            $jsonStations = json_encode($stations);

            $stationDetails = null;
            $jsonStationData = null;

            $view = 'station'; 
            $pagetitle = 'Station';
            require __DIR__ . '/../View/view.php';
            return;
        }

        // --------------------
        // Carte (station seule)
        // --------------------
        $coords = $passageRepo->getCoordonneesPourLieu($station->getIdLieu());
        $jsonStations = json_encode($coords);

        // --------------------
        // Graphique
        // --------------------
        $donneesGraph = $resultatRepo->getDonneesStation(
            $station->getIdLieu(),
            $filtre,
            $dateDebut,
            $dateFin
        );

        $jsonStationData = json_encode($donneesGraph);

        // --------------------
        // Infos station
        // --------------------
        $stationDetails = [
            'nom'  => $station->getNomLieu(),
            'zone' => $station->getZone()->getNomZone(),
            'type' => $station->getTypeLieu()
        ];

        $view = 'station'; 
        $pagetitle = 'Station';
        require __DIR__ . '/../View/view.php';
    }
}
