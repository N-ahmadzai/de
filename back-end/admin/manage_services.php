<?php
require_once('../config/db_connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $service_id = $_POST['service_id'] ?? null;
    $service_name = $_POST['name'] ?? null;
    $service_description = $_POST['description'] ?? null;

    try {
        $pdo = getPDO();

        if ($action == 'create') {
            $stmt = $pdo->prepare("INSERT INTO services (name, description) VALUES (?, ?)");
            $stmt->execute([$service_name, $service_description]);
            $_SESSION['success_message'] = "Le service a été créé avec succès.";
        } elseif ($action == 'update') {
            $stmt = $pdo->prepare("UPDATE services SET name = ?, description = ? WHERE id = ?");
            $stmt->execute([$service_name, $service_description, $service_id]);
            $_SESSION['success_message'] = "Le service a été mis à jour avec succès.";
        } elseif ($action == 'delete') {
            $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
            $stmt->execute([$service_id]);
            $_SESSION['success_message'] = "Le service a été supprimé avec succès.";
        }

        header("Location: manage_services.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
    }
}

// Récupérer la liste des services
try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM services");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Erreur : " . $e->getMessage();
}
?>
