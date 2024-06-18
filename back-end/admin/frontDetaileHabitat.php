<?php
require_once('../config/db_connect.php');
session_start();

if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = "ID de l'habitat manquant.";
    header("Location: habitats.php");
    exit();
}

$habitat_id = $_GET['id'];

try {
    $pdo = getPDO();

    $stmt = $pdo->prepare("SELECT * FROM habitats WHERE id = ?");
    $stmt->execute([$habitat_id]);
    $habitat = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$habitat) {
        $_SESSION['error_message'] = "Habitat non trouvé.";
        header("Location: habitats.php");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM animals WHERE habitat_id = ?");
    $stmt->execute([$habitat_id]);
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de l'Habitat</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/habitat.css">
</head>

<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($habitat['name']); ?></h1>
        <img src="<?php echo htmlspecialchars($habitat['image_url']); ?>" alt="<?php echo htmlspecialchars($habitat['name']); ?>" class="img-fluid">
        <p><?php echo htmlspecialchars($habitat['description']); ?></p>

        <h2>Animaux dans cet habitat</h2>
        <div class="row">
            <?php foreach ($animals as $animal) : ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?php echo htmlspecialchars($animal['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($animal['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($animal['name']); ?></h5>
                            <a href="animal_detail.php?id=<?php echo $animal['id']; ?>" class="btn btn-primary">Voir les détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
