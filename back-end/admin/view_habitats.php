<?php
require_once('../config/db_connect.php');
$pdo = getPDO();

$habitats = $pdo->query("SELECT * FROM habitats")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Habitats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Habitats</h1>
        <div class="row">
            <?php foreach ($habitats as $habitat) : ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <?php
                        $stmt = $pdo->prepare("SELECT image_url FROM habitat_images WHERE habitat_id = ?");
                        $stmt->execute([$habitat['id']]);
                        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php if (!empty($images)) : ?>
                            <img src="<?php echo htmlspecialchars($images[0]['image_url']); ?>" class="card-img-top" alt="Image de l'habitat">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($habitat['nom']); ?></h5>
                            <a href="habitat_detail.php?id=<?php echo $habitat['id']; ?>" class="btn btn-primary">Voir les détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
