<?php
session_start();

$ds = DIRECTORY_SEPARATOR;

// On remonte de /projet/web → /SAE_301
$root = realpath(__DIR__ . $ds . '..' . $ds . '..') ?: (__DIR__ . $ds . '..' . $ds . '..');

// Composer
require_once $root . $ds . 'vendor' . $ds . 'autoload.php';

// Projet
require_once $root . $ds . 'projet' . $ds . 'src' . $ds . 'Model' . $ds . 'Repository' . $ds . 'DatabaseConnection.php';
require_once $root . $ds . 'projet' . $ds . 'src' . $ds . 'Controller' . $ds . 'Controller.php';

$action = $_GET['action'] ?? 'accueil';

if (method_exists('Controller', $action)) {
    Controller::$action();
} else {
    Controller::accueil();
}

?>