<!-- Affichage des Détails de l'Animal avec les Rapports Vétérinaires et les Avis des Visiteurs -->
<?php
require_once('../config/db_connect.php');

if (isset($_GET['id'])) {
    $animal_id = $_GET['id'];

    try {
        $pdo = getPDO();

        // Récupérer les détails de l'animal
        $stmt = $pdo->prepare("SELECT * FROM animals WHERE id = ?");
        $stmt->execute([$animal_id]);
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);

        // Récupérer les rapports vétérinaires
        $stmt = $pdo->prepare("SELECT * FROM veterinarian_reports WHERE animal_id = ?");
        $stmt->execute([$animal_id]);
        $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Récupérer les avis approuvés des visiteurs
        $stmt = $pdo->prepare("SELECT * FROM reviews WHERE animal_id = ? AND approved = 1");
        $stmt->execute([$animal_id]);
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit();
    }
} else {
    echo "ID de l'animal manquant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Détails de l'animal</title>
</head>

<body>
    <h2>Détails de l'animal</h2>
    <p><strong>Nom :</strong> <?php echo htmlspecialchars($animal['name']); ?></p>
    <p><strong>Espèce :</strong> <?php echo htmlspecialchars($animal['species']); ?></p>
    <p><strong>Age :</strong> <?php echo htmlspecialchars($animal['age']); ?></p>
    <p><strong>Description :</strong> <?php echo htmlspecialchars($animal['description']); ?></p>

    <h2>Rapports vétérinaires</h2>
    <?php if (count($reports) > 0) : ?>
        <ul>
            <?php foreach ($reports as $report) : ?>
                <li>
                    <p><strong>État :</strong> <?php echo htmlspecialchars($report['status']); ?></p>
                    <p><strong>Nourriture :</strong> <?php echo htmlspecialchars($report['food']); ?></p>
                    <p><strong>Grammage :</strong> <?php echo htmlspecialchars($report['food_weight']); ?>g</p>
                    <p><strong>Date de passage :</strong> <?php echo htmlspecialchars($report['visit_date']); ?></p>
                    <?php if (!empty($report['details'])) : ?>
                        <p><strong>Détails :</strong> <?php echo htmlspecialchars($report['details']); ?></p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Aucun rapport vétérinaire disponible.</p>
    <?php endif; ?>

    <h2>Avis des visiteurs</h2>
    <?php if (count($reviews) > 0) : ?>
        <ul>
            <?php foreach ($reviews as $review) : ?>
                <li>
                    <p><strong>Pseudo :</strong> <?php echo htmlspecialchars($review['pseudo']); ?></p>
                    <p><strong>Avis :</strong> <?php echo htmlspecialchars($review['comment']); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Aucun avis disponible.</p>
    <?php endif; ?>
</body>

</html>