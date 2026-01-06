<?php
session_start();
// __DIR__ est déjà le dossier "web"
$ds = DIRECTORY_SEPARATOR;

// 1. Chemin vers DatabaseConnection (dans web/src/)
$dbPath = __DIR__ . $ds . 'src' . $ds . 'DatabaseConnection.php';

// 2. Chemin vers la racine du projet pour remonter vers le dossier "src" principal
$projectRoot = __DIR__ . $ds . '..';

// VERIFICATION
if (!file_exists($dbPath)) {
    die("ERREUR : Le fichier est introuvable.<br>Chemin tente : " . $dbPath);
}

// Inclusions
require_once $dbPath; // Charge web/src/DatabaseConnection.php
require_once $projectRoot . $ds . 'src' . $ds . 'Model' . $ds . 'Repository' . $ds . 'UtilisateurRepository.php';
require_once $projectRoot . $ds . 'src' . $ds . 'Controller';

// Gestion de l'action
$action = $_GET['action'] ?? 'accueil';

if (method_exists('Controller', $action)) {
    Controller::$action();
} else {
    Controller::accueil();
}
?>