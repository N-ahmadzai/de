<?php
require_once('../../config/db_connect.php');

session_start();

try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT af.animal_id, a.name AS animal_name, af.food, af.food_weight, af.date FROM animal_food af JOIN animals a ON af.animal_id = a.id ORDER BY af.date DESC");
    $animal_foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Alimentation des Animaux</title>
    <link rel="stylesheet" href="../../admin/css/veterinaire.css">
</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="veterinaire_dashboard.php" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Arcadia</span>
        </a>
        <ul class="side-menu top">
            <li>
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
            <li class="active">
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
        <!-- PRINCIPAL -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h2>Tableau de bord Vétérinaire</h2>
                </div>
            </div>
            <div class="head-title">
                <div class="left">
                    <ul class="breadcrumb">
                        <li>
                            <a class="active" href="veterinaire_dashboard.php">Tableau de bord</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="view_animal_food.php">Alimentation</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="todo">
                    <ul class="todo-list">
                        <li class="completed">
                            <h2>Liste des animaux</h2>
                            <i class='bx bx-dots-vertical-rounded'></i>
                        </li>
                    </ul>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID de l'animal</th>
                                <th scope="col">Nom de l'animal</th>
                                <th scope="col">Nourriture</th>
                                <th scope="col">Grammage</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($animal_foods) && count($animal_foods) > 0) : ?>
                                <?php foreach ($animal_foods as $food) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($food['animal_id']); ?></td>
                                        <td><?php echo htmlspecialchars($food['animal_name']); ?></td>
                                        <td><?php echo htmlspecialchars($food['food']); ?></td>
                                        <td><?php echo htmlspecialchars($food['food_weight']); ?></td>
                                        <td><?php echo htmlspecialchars($food['date']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5">Aucune information disponible.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!-- PRINCIPAL -->
    </section>
    <!-- CONTENU -->

</body>

</html>