<?php
use App\Covoiturage\Model\Repository\ResultatRepository;

$resultatRepository = new ResultatRepository();

// Sélection d’un résultat existant
$resultat = $resultatRepository->select(1);

var_dump($resultat);

?>