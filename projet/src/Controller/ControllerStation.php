<?php

namespace App\Covoiturage\Controller;

use App\Covoiturage\Model\Repository\LieuSurveillanceRepository;
use App\Covoiturage\Model\Repository\ResultatRepository;

class ControllerStation
{
    public static function station(): void
    {
        $lieuRepo = new LieuSurveillanceRepository();
        $resultatRepo = new ResultatRepository();

        // --------------------
        // Données carte (TOUJOURS les mêmes)
        // --------------------
        $stationsCarte = $lieuRepo->getStationsAvecCoordonnees();

        // --------------------
        // Paramètres GET
        // --------------------
        $stationRecherchee = $_GET['station'] ?? null;
        $filtre = $_GET['filtre'] ?? 'temperature';
        $dateDebut = $_GET['dateDebut'] ?? '2021-01-01';
        $dateFin = $_GET['dateFin'] ?? '2022-01-01';

        // Pour l'autocomplete
        $listeStations = $stationsCarte;

        // --------------------
        // CAS 1 : aucune recherche
        // --------------------
        if ($stationRecherchee === null || trim($stationRecherchee) === '') {

            $jsonStations = json_encode($stationsCarte);

            $stationDetails = null;
            $jsonStationData = null;
            $disponibilites = [];

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
            $jsonStations = json_encode($stationsCarte);

            $stationDetails = null;
            $jsonStationData = null;
            $disponibilites = [];

            $view = 'station';
            $pagetitle = 'Station';
            require __DIR__ . '/../View/view.php';
            return;
        }

        // --------------------
        // Carte : UNE SEULE station (filtrage PHP)
        // --------------------
        $stationsFiltrees = array_filter(
            $stationsCarte,
            fn($s) => (int)$s['id_lieu'] === $station->getIdLieu()
        );

        $jsonStations = json_encode(array_values($stationsFiltrees));

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
        // Disponibilités des données
        // --------------------
        $disponibilites = $resultatRepo->getDisponibilitesStation(
            idLieu: $station->getIdLieu()
        );

        $dateMin = null;
        $dateMax = null;

        foreach ($disponibilites as $d) {
            if ($dateMin === null || $d['date_debut'] < $dateMin) {
                $dateMin = $d['date_debut'];
            }
            if ($dateMax === null || $d['date_fin'] > $dateMax) {
                $dateMax = $d['date_fin'];
            }
        }

        $indicateursDisponibles = [];

        foreach ($disponibilites as $d) {
            $indicateur = match ($d['indicateur']) {
                "Température de l'eau" => "temperature",
                "Salinité" => "salinite",
                "Chlorophylle a" => "phytoplanctons",
                default => null
            };

            if ($indicateur !== null && $d['nb_valeurs'] > 0) {
                $indicateursDisponibles[] = $indicateur;
            }
        }


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
