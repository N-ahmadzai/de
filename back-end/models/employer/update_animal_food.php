<?php
require_once('../../config/db_connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_id = $_POST['food_id'];
    $animal_id = $_POST['animal_id'];
    $food = $_POST['food'];
    $food_weight = $_POST['food_weight'];
    $date = $_POST['date'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("UPDATE animal_food SET animal_id = ?, food = ?, food_weight = ?, date = ? WHERE id = ?");
        $stmt->execute([$animal_id, $food, $food_weight, $date, $food_id]);

        $_SESSION['success_message'] = "La nourriture de l'animal a été mise à jour avec succès.";
        header("Location: list_animal_food.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la mise à jour de la nourriture de l'animal : " . $e->getMessage();
        header("Location: update_animal_food.php?id=$food_id");
        exit();
    }
} else {
    if (!isset($_GET['id'])) {
        $_SESSION['error_message'] = "ID de la nourriture de l'animal non spécifié.";
        header("Location: list_animal_food.php");
        exit();
    }

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
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mettre à Jour Nourriture d'Animal</title>
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
            <li class="active"><a href="update_animal_food.php"><i class='bx bxs-comment'></i><span class="text"> Mise à jour</span></a></li>
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
                    <h2>Mettre à Jour Nourriture d'Animal</h2>
                    <ul class="breadcrumb">
                        <li><a class="active" href="employe_dashboard.php">Tableau de bord</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="update_animal_food.php">Mettre à jour nourriture</a></li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Mettre à jour nourriture</h3>
                    </div>
                    <!-- Formulaire de mise à jour de la nourriture -->
                    <form action="update_animal_food.php" method="POST">
                        <input type="hidden" name="food_id" value="<?php echo htmlspecialchars($food['id']); ?>">
                        <div class="mb-1">
                            <label for="animal_id" class="form-label">ID de l'Animal:</label>
                            <input type="number" class="form-control" id="animal_id" name="animal_id" value="<?php echo htmlspecialchars($food['animal_id']); ?>" required>
                        </div>
                        <div class="mb-1">
                            <label for="food" class="form-label">Nourriture:</label>
                            <input type="text" class="form-control" id="food" name="food" value="<?php echo htmlspecialchars($food['food']); ?>" required>
                        </div>
                        <div class="mb-1">
                            <label for="food_weight" class="form-label">Poids de la Nourriture (g):</label>
                            <input type="number" class="form-control" id="food_weight" name="food_weight" value="<?php echo htmlspecialchars($food['food_weight']); ?>" required>
                        </div>
                        <div class="mb-1">
                            <label for="date" class="form-label">Date:</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($food['date']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-success submit">Mettre à jour</button>
                    </form>

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