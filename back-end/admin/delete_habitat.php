<?php
session_start();
require_once('../config/db_connect.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $habitat_id = $_GET['id'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM habitats WHERE id = ?");
        $stmt->execute([$habitat_id]);

        $_SESSION['success_message'] = "L'habitat a été supprimé avec succès.";
        header("Location: manage_habitats.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la suppression de l'habitat : " . $e->getMessage();
        header("Location: manage_habitats.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "ID d'habitat manquant pour la suppression.";
    header("Location: manage_habitats.php");
    exit();
}
?>
