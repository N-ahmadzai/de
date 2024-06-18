<?php
require_once('../../config/db_connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $animal_id = $_POST['animal_id'];
    $food = $_POST['food'];
    $food_weight = $_POST['food_weight'];
    $date = $_POST['date'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO animal_food (animal_id, food, food_weight, date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$animal_id, $food, $food_weight, $date]);

        $_SESSION['success_message'] = "La nourriture de l'animal a été ajoutée avec succès.";
        header("Location: list_animal_food.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de l'ajout de la nourriture de l'animal : " . $e->getMessage();
        header("Location: add_animal_food.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Ajout alimentation</title>
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
            <li>
                <a href="employe_dashboard.php">
                <i class='bx bxs-comment-check' ></i>
                    <span class="text">Valider un avis</span>
                </a>
            </li>
            <li>
                <a href="view_service.php">
                <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Service</span>
                </a>
            </li>
            <li class="active">
                <a href="add_animal_food.php">
                <i class='bx bxs-add-to-queue' ></i>
                    <span class="text">Ajout de nourriture</span>
                </a>
            </li>
            <li>
                <a href="list_animal_food.php">
                <i class='bx bx-food-tag' ></i>
                    <span class="text">Liste des Nourritures</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="../../login/logout.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->
    <!-- CONTENU -->
    <section id="content">
        <main>
            <div class="head-title">
                <div class="left">
                    <h2>Tableau de bord employé</h2>
                    <ul class="breadcrumb">
                        <li>
                            <a class="active" href="employe_dashboard.php">Tableau de bord</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="add_animal_food.php">Ajout nourriture</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Ajout alimentation</h3>
                    </div>

                    <!-- Formulaire ajout alimentation -->
                    <form action="add_animal_food.php" method="POST">
                        <div class="mb-1">
                            <label for="animal_id" class="form-label">ID de l'Animal:</label>
                            <input type="number" class="form-control" id="animal_id" name="animal_id" required>
                        </div>
                        <div class="mb-1">
                            <label for="food" class="form-label">Alimentation:</label>
                            <input type="text" class="form-control" id="food" name="food" required>
                        </div>
                        <div class="mb-1">
                            <label for="food_weight" class="form-label">Poids de la Nourriture (g):</label>
                            <input type="number" class="form-control" id="food_weight" name="food_weight" required>
                        </div>
                        <div class="mb-1">
                            <label for="date" class="form-label">Date:</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <button type="submit" class="btn btn-success submit">Ajouter</button>
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

                <div class="todo">
                    <ul class="todo-list">
                        <li class="completed">
                            <h3>Liste des animaux</h3>
                            <i class='bx bx-list-ul'></i>
                        </li>
                    </ul>
                    <?php require_once('view_animals.php') ?>

                </div>
            </div>
        </main>
    </section>
    <!-- CONTENU -->
</body>

</html>