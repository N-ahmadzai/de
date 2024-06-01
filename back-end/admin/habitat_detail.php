<?php
require_once('../config/db_connect.php');
$pdo = getPDO();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM habitats WHERE id = ?");
    $stmt->execute([$id]);
    $habitat = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($habitat) {
        $stmt = $pdo->prepare("SELECT * FROM animaux WHERE habitat_id = ?");
        $stmt->execute([$id]);
        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Habitat non trouvé.";
        exit();
    }
} else {
    echo "ID d'habitat manquant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Habitat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($habitat['nom']); ?></h1>
        <p><?php echo htmlspecialchars($habitat['description']); ?></p>

        <h2>Animaux</h2>
        <div class="row">
            <?php foreach ($animaux as $animal) : ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <?php
                        $stmt = $pdo->prepare("SELECT image_url FROM animal_images WHERE animal_id = ?");
                        $stmt->execute([$animal['id']]);
                        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php if (!empty($images)) : ?>
                            <img src="<?php echo htmlspecialchars($images[0]['image_url']); ?>" class="card-img-top" alt="Image de l'animal">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($animal['prenom']); ?></h5>
                            <a href="animal_detail.php?id=<?php echo $animal['id']; ?>" class="btn btn-primary">Voir les détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
