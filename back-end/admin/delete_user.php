<?php
require_once('../config/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        // Redirection avec message de succès
        header("Location: manage_user.php?status=success&message=" . urlencode("Le compte a été supprimé avec succès."));
        exit();
    } catch (PDOException $e) {
        // Redirection avec message d'erreur
        header("Location: manage_user.php?status=error&message=" . urlencode("Erreur : " . $e->getMessage()));
        exit();
    }
}


// Vérifier si un message de suppression a été passé via la session
if (isset($_SESSION['delete_source'])) {
    $delete_source = $_SESSION['delete_source'];

    if ($delete_source === 'create_user' && isset($_GET['status']) && isset($_GET['message'])) {
        // Afficher le message de succès ou d'erreur uniquement si la redirection provient de manage_user.php
        if ($_GET['status'] === 'success') {
            echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_GET['message']) . '</div>';
        } elseif ($_GET['status'] === 'error') {
            echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['message']) . '</div>';
        }
    }

    // Supprimer la variable de session après utilisation
    unset($_SESSION['delete_source']);
}
