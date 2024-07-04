<?php

require_once __DIR__ . '../../vendor/autoload.php'; // Charger Composer autoloader

use MongoDB\Client;

// Connexion à MongoDB (adapter l'URI selon votre configuration)
$mongoClient = new Client('mongodb://localhost:27017');

// Sélectionner la base de données
$db = $mongoClient->selectDatabase('zoo_arcadia');

// Sélectionner la collection pour stocker les consultations d'animaux
$animalConsultations = $db->animal_consultations;
