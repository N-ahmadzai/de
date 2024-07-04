<?php
require_once('../../config/db_connect.php');

session_start();

if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM vet_reports WHERE id = ?");
        $stmt->execute([$report_id]);

        $_SESSION['success_message'] = "Rapport supprimé avec succès.";
        header("Location: veterinaire_dashboard.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
        header("Location: veterinaire_dashboard.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "ID de rapport invalide.";
    header("Location: veterinaire_dashboard.php");
    exit();
}
