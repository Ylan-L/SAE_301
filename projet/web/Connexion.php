<?php
require_once __DIR__ . '/../src/Controller/Controller.php';

$action = $_GET['action'] ?? 'login';
Controller::$action();

