<?php
require_once('../config/db_connect.php');
session_start();

// Récupérer les avis
try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM reviews");
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Erreur : " . $e->getMessage();
}

// Valider/Invalider un avis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = $_POST['review_id'];
    $action = $_POST['action'];

    try {
        if ($action == 'validate') {
            $stmt = $pdo->prepare("UPDATE reviews SET status = 'validé' WHERE id = ?");
            $stmt->execute([$review_id]);
        } elseif ($action == 'invalidate') {
            $stmt = $pdo->prepare("UPDATE reviews SET status = 'invalidé' WHERE id = ?");
            $stmt->execute([$review_id]);
        }

        $_SESSION['success_message'] = "L'avis a été mis à jour avec succès.";
        header("Location: manage_reviews.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les avis</title>
</head>
<body>
    <!-- Affichage et gestion des avis -->
</body>
</html>
