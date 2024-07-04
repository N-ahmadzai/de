<?php
require_once('../../config/db_connect.php');

session_start();

if (isset($_GET['id'])) {
    $comment_id = $_GET['id'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM habitat_comments WHERE id = ?");
        $stmt->execute([$comment_id]);

        $_SESSION['success_message'] = "Commentaire supprimé avec succès.";
        header("Location: habitat_comments.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
        header("Location: habitat_comments.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "ID de commentaire invalide.";
    header("Location: habitat_comments.php");
    exit();
}
