<?php
require_once('../config/db_connect.php');
session_start();

try {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT id, name, image_url FROM habitats");
    $stmt->execute();
    $habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitats</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/habitat.css">
</head>

<body>
    <div class="container">
        <h1>Habitats</h1>
        <div class="row">
            <?php foreach ($habitats as $habitat) : ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?php echo htmlspecialchars($habitat['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($habitat['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($habitat['name']); ?></h5>
                            <a href="habitat_detail.php?id=<?php echo $habitat['id']; ?>" class="btn btn-primary">Voir les détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
