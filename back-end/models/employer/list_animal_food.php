<?php
require_once('../../config/db_connect.php');
session_start();

try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM animal_food");
    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Erreur lors de la récupération des données : " . $e->getMessage();
    header("Location: employe_dashboard.php");
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
    <title>Liste des Nourritures d'Animaux</title>
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
            <li>
                <a href="add_animal_food.php">
                <i class='bx bxs-add-to-queue' ></i>
                    <span class="text">Ajout de nourriture</span>
                </a>
            </li>
            <li class="active">
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
                            <a class="active" href="list_animal_food.php">Nourriture</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="todo">
                        <ul class="todo-list">
                            <li class="completed">
                                <h3>Liste des Nourritures</h3>
                                <i class='bx bx-list-ul'></i>

                            </li>
                        </ul>
                    </div>
                    <!-- Table des nourritures -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th  scope="col">ID</th>
                                <th  scope="col">ID de l'Animal</th>
                                <th  scope="col">Nourriture</th>
                                <th  scope="col">Poids (g)</th>
                                <th  scope="col">Date</th>
                                <th  scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($foods as $food) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($food['id']); ?></td>
                                    <td><?php echo htmlspecialchars($food['animal_id']); ?></td>
                                    <td><?php echo htmlspecialchars($food['food']); ?></td>
                                    <td><?php echo htmlspecialchars($food['food_weight']); ?></td>
                                    <td><?php echo htmlspecialchars($food['date']); ?></td>
                                    <td>
                                        <a href="view_animal_food.php?id=<?php echo $food['id']; ?>"><i class='bx bx-show' style='color: #2EB872;'></i></a>
                                        <a href="update_animal_food.php?id=<?php echo $food['id']; ?>"><i class='bx bx-edit' style='color: #2EB872;'></i></a>
                                        <a href="delete_animal_food.php?id=<?php echo $food['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?');"><i class='bx bxs-trash' style='color: #2EB872;'></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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