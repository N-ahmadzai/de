<?php
require_once('../../config/db_connect.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $animal_id = $_POST['animal_id'];
    $status = $_POST['animal_status'];
    $food = $_POST['animal_food'];
    $food_weight = $_POST['animal_food_weight'];
    $visit_date = $_POST['visit_date'];
    $details = isset($_POST['details']) ? $_POST['details'] : '';

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO vet_reports (animal_id, animal_status, animal_food, animal_food_weight, visit_date, details) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$animal_id, $status, $food, $food_weight, $visit_date, $details]);

        $_SESSION['success_message'] = "Rapport ajouté avec succès.";
        header("Location: veterinaire_dashboard.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
        header("Location: veterinaire_dashboard.php");
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
    <title>Tableau de bord Vétérinaire</title>
    <link rel="stylesheet" href="../../admin/css/dashboard.css">
</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="veterinaire_dashboard.php" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Arcadia</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="veterinaire_dashboard.php">
                    <i class='bx bxs-add-to-queue'></i>
                    <span class="text">Ajouter un rapport</span>
                </a>
            </li>
            <li>
                <a href="view_animals.php">
                    <i class='bx bxl-baidu'></i>
                    <span class="text">Animaux</span>
                </a>
            </li>
            <li>
                <a href="habitat_comments.php">
                    <i class='bx bxs-comment-detail'></i>
                    <span class="text">Commentaires</span>
                </a>
            </li>
            <li>
                <a href="view_animal_food.php">
                    <i class='bx bx-food-menu'></i>
                    <span class="text">Alimentation</span>
                </a>
            </li>

        </ul>
        <ul class="side-menu">
            <li>
                <a href="../../login/logout.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Déconnexion</span>
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
                    <h2>Tableau de bord Vétérinaire</h2>
                    <ul class="breadcrumb">
                        <li>
                            <a class="active" href="veterinaire_dashboard.php">Tableau de bord</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="veterinaire_dashboard.php">Rapports veterinaire</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <a href="veterinaire_dashboard.php">
                            <h3>Ajouter un rapport veterinaire</h3>
                        </a>
                    </div>

                    <!-- Formulaire pour créer un nouveau rapport -->
                    <form action="veterinaire_dashboard.php" method="POST">
                        <div class="mb-1">
                            <label for="animal_id" class="form-label">Animal ID:</label>
                            <input type="number" class="form-control" id="animal_id" name="animal_id" required>
                        </div>

                        <div class="mb-1">
                            <label for="status" class="form-label">État de l'animal :</label>
                            <input type="text" class="form-control" id="status" name="animal_status" required>
                        </div>

                        <div class="mb-1">
                            <label for="food" class="form-label">Nourriture proposée :</label>
                            <input type="text" class="form-control" id="food" name="animal_food" required>
                        </div>

                        <div class="mb-1">
                            <label for="food_weight" class="form-label">Grammage de la nourriture :</label>
                            <input type="number" class="form-control" id="food_weight" name="animal_food_weight" required>
                        </div>


                        <div class="mb-1">
                            <label for="visit_date" class="form-label">Date de passage:</label>
                            <input type="date" class="form-control" id="visit_date" name="visit_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="details" class="form-label">Détail de l'état de l'animal (facultatif):</label>
                            <textarea class="form-control" id="details" name="details" rows="2"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success submit">Ajouter le rapport</button>
                    </form>
                    <!-- Messages d'erreur et de succès -->

                </div>


                <div class="todo">
                    <ul class="todo-list">
                        <li class="completed">
                            <h3>Gestion des rapports vétérinaire</h3>
                            <i class='bx bx-list-ul'></i>
                        </li>
                    </ul>
                    <?php
                    if (isset($_SESSION['success_message'])) : ?>
                        <div class="alert alert-success mt-3">
                            <?php
                            echo $_SESSION['success_message'];
                            unset($_SESSION['success_message']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    if (isset($_SESSION['error_message'])) : ?>
                        <div class="alert alert-danger mt-3">
                            <?php
                            echo $_SESSION['error_message'];
                            unset($_SESSION['error_message']);
                            ?>
                        </div>
                    <?php endif; ?>




                    <!-- Affichage des messages -->
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


                    <!--  inclure la page afficher les rapports -->
                    <?php require_once('view_reports.php'); ?>
                </div>
            </div>
        </main>
    </section>
    <!-- CONTENU -->

</body>

</html>