<?php
session_start();

$ds = DIRECTORY_SEPARATOR;
$root = __DIR__ . $ds . '..';

require_once $root . $ds . 'src' . $ds . 'Model' . $ds . 'Repository' . $ds . 'DatabaseConnection.php';
require_once $root . $ds . 'src' . $ds . 'Controller' . $ds . 'Controller.php';

$action = $_GET['action'] ?? 'accueil';

if (method_exists('Controller', $action)) {
    Controller::$action();
} else {
    Controller::accueil();
}
