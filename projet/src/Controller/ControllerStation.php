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
        $listeStations = $lieuRepo->getStationsAvecCoordonnees();

        
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
        // Carte (station seule) — STRUCTURE UNIFIÉE
        // --------------------
        $coords = $passageRepo->getCoordonneesPourLieu($station->getIdLieu());

        // on calcule un centre (au cas où plusieurs passages)
        $lat = null;
        $lng = null;

        if (!empty($coords)) {
            $lat = $coords[0]['lat'];
            $lng = $coords[0]['lng'];
        }

        $jsonStations = json_encode([[
            'libelle_lieu' => $station->getNomLieu(),
            'entite_classement' => $station->getTypeLieu(),
            'lat' => $lat,
            'lng' => $lng
        ]]);


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
        // Disponibilité des données
        // --------------------
        $disponibilites = $resultatRepo->getDisponibilitesStation(
        idLieu: $station->getIdLieu()
        );

        $disposParIndicateur = [];

        foreach ($disponibilites as $d) {
            $indicateur = match ($d['indicateur']) {
                "Température de l'eau" => "temperature",
                "Salinité" => "salinite",
                "Chlorophylle a" => "phytoplanctons",
                default => null
            };

            if ($indicateur !== null) {
                $disposParIndicateur[$indicateur] = [
                    'dateDebut' => $d['date_debut'],
                    'dateFin'   => $d['date_fin']
                ];
            }
        }
        $jsonStations = json_encode($disposParIndicateur);


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
