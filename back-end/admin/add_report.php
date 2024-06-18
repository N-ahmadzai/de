<?php
require_once('../config/db_connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $animal_id = $_POST['animal_id'];
    $status = $_POST['status'];
    $food = $_POST['food'];
    $food_weight = $_POST['food_weight'];
    $visit_date = $_POST['visit_date'];
    $details = $_POST['details'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO veterinarian_reports (animal_id, status, food, food_weight, visit_date, details) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$animal_id, $status, $food, $food_weight, $visit_date, $details]);

        $_SESSION['success_message'] = "Le rapport a été ajouté avec succès.";
        header("Location: add_report.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de l'ajout du rapport : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un rapport vétérinaire</title>
</head>
<body>
    <form action="add_report.php" method="post">
        <label for="animal_id">ID de l'animal :</label>
        <input type="number" name="animal_id" id="animal_id" required><br>

        <label for="status">État de l'animal :</label>
        <input type="text" name="status" id="status" required><br>

        <label for="food">Nourriture proposée :</label>
        <input type="text" name="food" id="food" required><br>

        <label for="food_weight">Grammage de la nourriture :</label>
        <input type="number" step="0.01" name="food_weight" id="food_weight" required><br>

        <label for="visit_date">Date de passage :</label>
        <input type="date" name="visit_date" id="visit_date" required><br>

        <label for="details">Détail de l'état de l'animal :</label>
        <textarea name="details" id="details"></textarea><br>

        <button type="submit">Ajouter le rapport</button>
    </form>
</body>
</html>
