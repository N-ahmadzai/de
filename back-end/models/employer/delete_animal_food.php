<?php
require_once('../../config/db_connect.php');
session_start();

if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = "ID de la nourriture de l'animal non spécifié.";
    header("Location: list_animal_food.php");
    exit();
}

$food_id = $_GET['id'];

try {
    $pdo = getPDO();

    $stmt = $pdo->prepare("DELETE FROM animal_food WHERE id = ?");
    $stmt->execute([$food_id]);

    $_SESSION['success_message'] = "La nourriture de l'animal a été supprimée avec succès.";
    header("Location: list_animal_food.php");
    exit();
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Erreur lors de la suppression de la nourriture de l'animal : " . $e->getMessage();
    header("Location: list_animal_food.php");
    exit();
}
?>
