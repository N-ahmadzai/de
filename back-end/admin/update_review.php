<?php
require_once('../config/db_connect.php');
session_start();

try {
    $pdo = getPDO();
    if (isset($_POST['approve'])) {
        $review_id = $_POST['review_id'];
        $stmt = $pdo->prepare("UPDATE reviews SET status = 'approved' WHERE id = ?");
        $stmt->execute([$review_id]);
    } elseif (isset($_POST['reject'])) {
        $review_id = $_POST['review_id'];
        $stmt = $pdo->prepare("UPDATE reviews SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$review_id]);
    }

    $stmt = $pdo->prepare("SELECT * FROM reviews WHERE status = 'pending'");
    $stmt->execute();
    $pending_reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Erreur lors de la récupération des avis : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les avis</title>
</head>
<body>
    <h1>Gérer les avis</h1>
    <?php if (isset($pending_reviews) && count($pending_reviews) > 0): ?>
        <ul>
            <?php foreach ($pending_reviews as $review): ?>
                <li>
                    <strong>Pseudo:</strong> <?php echo htmlspecialchars($review['pseudo']); ?><br>
                    <strong>Avis:</strong> <?php echo htmlspecialchars($review['comment']); ?><br>
                    <form action="update_review.php" method="post">
                        <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                        <button type="submit" name="approve">Approuver</button>
                        <button type="submit" name="reject">Rejeter</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun avis en attente.</p>
    <?php endif; ?>
</body>
</html>
