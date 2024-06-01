<?php
require_once('../config/db_connect.php');

session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM horaires WHERE id = ?");
        $stmt->execute([$id]);

        // Après la suppression réussie d'un horaire
        $_SESSION['delete_source'] = 'manage_horaires';
        header("Location: manage_horaires.php?status=success&message=Horaire supprimé avec succès.");
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur lors de la suppression d'un horaire
        $_SESSION['delete_source'] = 'manage_horaires';
        header("Location: manage_horaires.php?status=error&message=Erreur : " . $e->getMessage());
        exit();
    }
}
