<?php
session_start();
require_once('../config/db_connect.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $animal_id = $_GET['id'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM animals WHERE id = ?");
        $stmt->execute([$animal_id]);

        $_SESSION['success_message'] = "L'animal a été supprimé avec succès.";
        header("Location: manage_animals.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la suppression de l'animal : " . $e->getMessage();
        header("Location: manage_animals.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "ID d'animal manquant pour la suppression.";
    header("Location: manage_animals.php");
    exit();
}
?>
