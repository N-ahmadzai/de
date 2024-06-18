<?php
require_once('../../config/db_connect.php');

try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM services");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Tableau de bord employé et Validation des Avis</title>
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
            <li class="active">
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
                            <a class="active" href="view_service.php">Service</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="todo">
                    <ul class="todo-list">
                        <li class="completed">
                            <h3>Mettre à jour le service</h3>
                            <i class='bx bx-list-ul'></i>
                        </li>
                    </ul>
                    <!-- Afficher les messages d'erreur ou de succès -->
                    <?php if (isset($_SESSION['success_message'])) : ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success_message']);
                                                            unset($_SESSION['success_message']); ?></div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_message'])) : ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error_message']);
                                                        unset($_SESSION['error_message']); ?></div>
                    <?php endif; ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Description</th>
                                <th scope="col">Photo</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service) : ?>
                                <tr>
                                    <td scope="row"><?php echo htmlspecialchars($service['id']); ?></td>
                                    <td scope="row"><?php echo htmlspecialchars($service['name']); ?></td>
                                    <td scope="row"><?php echo htmlspecialchars($service['description']); ?></td>
                                    <td scope="row">
                                        <?php if (!empty($service['photo'])) : ?>
                                            <img src="../../admin/uploads/services/<?php echo htmlspecialchars($service['photo']); ?>" alt="Photo du service" width="50">
                                        <?php else : ?>
                                            Pas de photo
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="update_service.php?id=<?php echo $service['id']; ?>"><i class='bx bx-edit' style='color: #2EB872;'></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Afficher les messages d'erreur ou de succès -->
                    <?php if (isset($_SESSION['success_message'])) : ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success_message']);
                                                            unset($_SESSION['success_message']); ?></div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_message'])) : ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error_message']);
                                                        unset($_SESSION['error_message']); ?></div>
                    <?php endif; ?>
                </div>

        </main>
    </section>
    <!-- CONTENU -->
</body>

</html>