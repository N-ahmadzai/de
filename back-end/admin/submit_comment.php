<?php
session_start();
require_once('../config/db_connect.php');
$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $avis = $_POST['avis'];
    $animal_id = $_POST['animal_id'];

    $stmt = $pdo->prepare("INSERT INTO avis (animal_id, pseudo, avis) VALUES (?, ?, ?)");
    $stmt->execute([$animal_id, $pseudo, $avis]);

    $_SESSION['success_message'] = "Votre commentaire a été soumis avec succès.";
    header("Location: animal_detail.php?id=$animal_id");
    exit();
} else {
    echo "Méthode non autorisée.";
    exit();
}
