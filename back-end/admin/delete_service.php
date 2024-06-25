<?php

require_once('../config/db_connect.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $service_id = $_GET['id'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
        $stmt->execute([$service_id]);

        $_SESSION['success_message'] = "Le service a été supprimé avec succès.";
        header("Location: manage_services.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la suppression du service avec l'ID $service_id : " . $e->getMessage();
        header("Location: manage_services.php");
        exit();
    }
}