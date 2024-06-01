<?php
require_once('../config/db_connect.php');
$pdo = getPDO();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM animaux WHERE id = ?");
    $stmt->execute([$id]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($animal) {
        $stmt = $pdo->prepare("SELECT * FROM veterinaire WHERE animal_id = ?");
        $stmt->execute([$id]);
        $veterinaire = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM avis WHERE animal_id = ? AND valide = 1");
        $stmt->execute([$id]);
        $avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Animal non trouvé.";
        exit();
    }
} else {
    echo "ID d'animal manquant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Animal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($animal['prenom']); ?></h1>
        <p>Race : <?php echo htmlspecialchars($animal['race']); ?></p>

        <?php if ($veterinaire) : ?>
            <h2>État de l'animal</h2>
            <p>État : <?php echo htmlspecialchars($veterinaire['etat']); ?></p>
            <p>Nourriture : <?php echo htmlspecialchars($veterinaire['nourriture']); ?></p>
            <p>Grammage : <?php echo htmlspecialchars($veterinaire['grammage']); ?> g</p>
            <p>Date de passage : <?php echo htmlspecialchars($veterinaire['date_passage']); ?></p>
            <p>Détails de l'état : <?php echo htmlspecialchars($veterinaire['details_etat']); ?></p>
        <?php endif; ?>

        <h2>Commentaires</h2>
        <?php foreach ($avis as $commentaire) : ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($commentaire['pseudo']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($commentaire['avis']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <h2>Laisser un commentaire</h2>
        <form method="POST" action="submit_comment.php">
            <div class="mb-3">
                <label class="form-label" for="pseudo">Pseudo :</label>
                <input class="form-control" type="text" id="pseudo" name="
                <?php echo $animal['prenom']; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="avis">Avis :</label>
                <textarea class="form-control" id="avis" name="avis" rows="3" required></textarea>
            </div>
            <input type="hidden" name="animal_id" value="<?php echo $animal['id']; ?>">
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>
    </div>
</body>
</html>
