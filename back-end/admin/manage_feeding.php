<?php
require_once('../config/db_connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = $_POST['animal_id'];
    $food_type = $_POST['food_type'];
    $quantity = $_POST['quantity'];
    $feeding_time = $_POST['feeding_time'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO feedings (animal_id, food_type, quantity, feeding_time) VALUES (?, ?, ?, ?)");
        $stmt->execute([$animal_id, $food_type, $quantity, $feeding_time]);

        $_SESSION['success_message'] = "L'alimentation a été enregistrée avec succès.";
        header("Location: manage_feeding.php");
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
    <title>Gérer l'alimentation</title>
</head>
<body>
    <!-- Formulaire pour enregistrer l'alimentation des animaux -->
</body>
</html>
