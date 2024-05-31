<?php
require_once('../config/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        // Redirection avec message de succès
        header("Location: create_user.php?status=success&message=" . urlencode("Le compte a été supprimé avec succès."));
        exit();
    } catch (PDOException $e) {
        // Redirection avec message d'erreur
        header("Location: create_user.php?status=error&message=" . urlencode("Erreur : " . $e->getMessage()));
        exit();
    }
}
