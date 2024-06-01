<?php
session_start();
require_once('../config/db_connect.php');
$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $avis_id = $_POST['avis_id'];
    $valider = isset($_POST['valider']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE avis SET valide = ? WHERE id = ?");
    $stmt->execute([$valider, $avis_id]);

    $_SESSION['success_message'] = "L'avis a été validé avec succès.";
    header("Location: dashboard.php"); // Rediriger vers le tableau de bord de l'employé
    exit();
} else {
    echo "Méthode non autorisée.";
    exit();
}
