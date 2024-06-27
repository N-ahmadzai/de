<?php
require_once('../../config/db_connect.php');
session_start();

if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = "ID du commentaire non spécifié.";
    header("Location: employe_dashboard.php");
    exit();
}

$comment_id = $_GET['id'];

try {
    $pdo = getPDO();

    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$comment_id]);

    $_SESSION['success_message'] = "Le commentaire a été supprimé avec succès.";
    header("Location: employe_dashboard.php");
    exit();
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Erreur lors de la suppression du commentaire : " . $e->getMessage();
    header("Location: employe_dashboard.php");
    exit();
}
