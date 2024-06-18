<?php
require_once('../config/db_connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $animal_id = $_POST['animal_id'];
    $pseudo = $_POST['pseudo'];
    $comment = $_POST['comment'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO reviews (animal_id, pseudo, comment) VALUES (?, ?, ?)");
        $stmt->execute([$animal_id, $pseudo, $comment]);

        $_SESSION['success_message'] = "Votre avis a été soumis pour validation.";
        header("Location: submit_review.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la soumission de l'avis : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Laisser un avis</title>
</head>
<body>
    <form action="submit_review.php" method="post">
        <label for="animal_id">ID de l'animal :</label>
        <input type="number" name="animal_id" id="animal_id" required><br>

        <label for="pseudo">Pseudo :</label>
        <input type="text" name="pseudo" id="pseudo" required><br>

        <label for="comment">Avis :</label>
        <textarea name="comment" id="comment" required></textarea><br>

        <button type="submit">Soumettre l'avis</button>
    </form>
</body>
</html>
