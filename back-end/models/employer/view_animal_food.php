<?php
require_once('../../config/db_connect.php');
session_start();

$food_id = $_GET['id'];

try {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM animal_food WHERE id = ?");
    $stmt->execute([$food_id]);
    $food = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Erreur lors de la récupération des données : " . $e->getMessage();
    header("Location: list_animal_food.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Visualiser Nourriture d'Animal</title>
    <link rel="stylesheet" href="../../admin/css/employer.css">
</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="employe_dashboard.php" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Arcadia</span>
        </a>
        <ul class="side-menu top">
            <li><a href="employe_dashboard.php"><i class='bx bxs-comment-check'></i><span class="text">Valider un avis</span></a></li>
            <li><a href="view_service.php"><i class='bx bxs-doughnut-chart'></i><span class="text">Service</span></a></li>
            <li><a href="add_animal_food.php"><i class='bx bxs-add-to-queue'></i><span class="text">Ajout de nourriture</span></a></li>
            <li><a href="list_animal_food.php"><i class='bx bx-food-tag'></i><span class="text">Liste des Nourritures</span></a></li>
            <li class="active"><a href="view_animal_food.php"><i class='bx bxl-baidu'></i><span class="text">Voir l'animal</span></a></li>
        </ul>
        <ul class="side-menu">
            <li><a href="#"><i class='bx bxs-cog'></i><span class="text">Settings</span></a></li>
            <li><a href="../../login/logout.php" class="logout"><i class='bx bxs-log-out-circle'></i><span class="text">Logout</span></a></li>
        </ul>
    </section>
    <!-- SIDEBAR -->
    <!-- CONTENU -->
    <section id="content">
        <main>
            <div class="head-title">
                <div class="left">
                    <h2>Visualiser Nourriture d'Animal</h2>
                    <ul class="breadcrumb">
                        <li><a class="active" href="employe_dashboard.php">Tableau de bord</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a href="view_animal_food.php">Visualiser Nourriture</a></li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Détails de la nourriture</h3>
                    </div>
                    <!-- Détails de la nourriture -->
                    <?php if ($food) : ?>
                        <p>ID de l'Animal: <?php echo htmlspecialchars($food['animal_id']); ?></p>
                        <p>Nourriture: <?php echo htmlspecialchars($food['food']); ?></p>
                        <p>Poids de la Nourriture (g): <?php echo htmlspecialchars($food['food_weight']); ?></p>
                        <p>Date: <?php echo htmlspecialchars($food['date']); ?></p>
                    <?php else : ?>
                        <p>Nourriture introuvable.</p>
                    <?php endif; ?>

                    <!-- Messages d'erreur et de succès -->
                    <?php if (isset($_SESSION['success_message'])) : ?>
                        <div class="alert alert-success mt-3">
                            <?php echo $_SESSION['success_message']; ?>
                        </div>
                        <?php unset($_SESSION['success_message']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error_message'])) : ?>
                        <div class="alert alert-danger mt-3">
                            <?php echo $_SESSION['error_message']; ?>
                        </div>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </section>
    <!-- CONTENU -->
</body>

</html>