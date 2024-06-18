<?php
session_start();
require_once('../config/db_connect.php');

if (isset($_POST['review_id']) && isset($_POST['action'])) {
    $review_id = $_POST['review_id'];
    $action = $_POST['action'];

    try {
        $pdo = getPDO();
        if ($action == 'approve') {
            $stmt = $pdo->prepare("UPDATE reviews SET approved = 1 WHERE id = ?");
        } elseif ($action == 'reject') {
            $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
        }
        $stmt->execute([$review_id]);
        
        $_SESSION['success_message'] = "Action effectuée avec succès.";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
    }
    header("Location: manage_reviews.php");
    exit();
}

// Récupération des avis en attente de validation
try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM reviews WHERE approved = 0");
    $pending_reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
    $pending_reviews = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les avis</title>
</head>
<body>
    <h2>Gérer les avis</h2>
    <?php if (!empty($pending_reviews)): ?>
        <ul>
            <?php foreach ($pending_reviews as $review): ?>
                <li>
                    <p><strong>Pseudo :</strong> <?php echo htmlspecialchars($review['pseudo']); ?></p>
                    <p><strong>Avis :</strong> <?php echo htmlspecialchars($review['comment']); ?></p>
                    <form action="manage_reviews.php" method="POST">
                        <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                        <button type="submit" name="action" value="approve">Approuver</button>
                        <button type="submit" name="action" value="reject">Rejeter</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun avis en attente de validation.</p>
    <?php endif; ?>
</body>
</html>
