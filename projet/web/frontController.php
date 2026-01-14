<?php
session_start();
use App\Covoiturage\Controller\ControllerGraphique;
use App\Covoiturage\Controller\ControllerStation;

$ds = DIRECTORY_SEPARATOR;

// On remonte de /projet/web → /SAE_301
$root = realpath(__DIR__ . $ds . '..' . $ds . '..') ?: (__DIR__ . $ds . '..' . $ds . '..');

// Composer
require_once $root . $ds . 'vendor' . $ds . 'autoload.php';
// On charge le parent AbstractRepository
require_once $root . $ds . 'projet' . $ds . 'src' . $ds . 'Model' . $ds . 'Repository' . $ds . 'AbstractRepository.php';
// On charge ResultatRepository
require_once $root . $ds . 'projet' . $ds . 'src' . $ds . 'Model' . $ds . 'Repository' . $ds . 'ResultatRepository.php';

// Projet
require_once $root . $ds . 'projet' . $ds . 'src' . $ds . 'Model' . $ds . 'Repository' . $ds . 'DatabaseConnection.php';

require_once $root . $ds . 'projet' . $ds . 'src' . $ds . 'Controller' . $ds . 'Controller.php';
require_once $root . $ds . 'projet' . $ds . 'src' . $ds . 'Controller' . $ds . 'ControllerGraphique.php';

$action = $_GET['action'] ?? 'accueil';

if ($action === 'graphique') {
    // Appel du nouveau contrôleur pour les graphiques
    ControllerGraphique::afficher();
} 
elseif($action === 'station') {
    ControllerStation::station();
}
elseif (method_exists('Controller', $action)) {
    Controller::$action();
} else {
    Controller::accueil();
}

?>