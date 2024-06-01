<?php

require_once('../config/db_connect.php'); // Inclusion du fichier de connexion à la base de données

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $service_id = $_GET['id']; // Récupération de l'ID du service à supprimer

    try {
        $pdo = getPDO(); // Connexion à la base de données
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?"); // Préparation de la requête SQL de suppression
        $stmt->execute([$service_id]); // Exécution de la requête SQL avec l'ID du service à supprimer

        $_SESSION['success_message'] = "Le service a été supprimé avec succès."; // Message de succès
        header("Location: manage_services.php"); // Redirection vers la page de gestion des services
        exit(); // Arrêt du script
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la suppression du service avec l'ID $service_id : " . $e->getMessage(); // Message d'erreur
        header("Location:  manage_services.php"); // Redirection vers la page de gestion des services
        exit(); // Arrêt du script
    }
}