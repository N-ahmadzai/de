<?php
require_once('../config/db_connect.php');
session_start();

if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = "ID de l'animal manquant.";
    header("Location: habitats.php");
    exit();
}

$animal_id = $_GET['id'];

try {
    $pdo = getPDO();

    $stmt = $pdo->prepare("SELECT * FROM animals WHERE id = ?");
    $stmt->execute([$animal_id]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        $_SESSION['error_message'] = "Animal non trouvé.";
        header("Location: habitats.php");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM veterinarian_visits WHERE animal_id = ?");
    $stmt->execute([$animal_id]);
    $visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de l'Animal</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/animal.css">
</head>

<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($animal['name']); ?></h1>
        <img src="<?php echo htmlspecialchars($animal['image_url']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>" class="img-fluid">
        <p>Race : <?php echo htmlspecialchars($animal['race']); ?></p>

        <h2>État de l'animal</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>État</th>
                        <th>Nourriture</th>
                        <th>Grammage</th>
                        <th>Détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($visits as $visit) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($visit['date']); ?></td>
                            <td><?php echo htmlspecialchars($visit['etat']); ?></td>
                            <td><?php echo htmlspecialchars($visit['nourriture']); ?></td>
                            <td><?php echo htmlspecialchars($visit['grammage']); ?></td>
                            <td><?php echo htmlspecialchars($visit['details']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h2>Laisser un avis</h2>
        <form action="submit_review.php" method="post">
            <input type="hidden" name="animal_id" value="<?php echo $animal['id']; ?>">
            <div class="form-group">
                <label for="pseudo">Pseudo :</label>
                <input type="text" name="pseudo" class="form-control" id="pseudo" required>
            </div>
            <div class="form-group">
                <label for="avis">Avis :</label>
                <textarea name="avis" class="form-control" id="avis" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Soumettre</button>
        </form>
    </div>
</body>

</html>
