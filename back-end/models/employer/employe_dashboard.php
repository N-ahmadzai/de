<?php
session_start();
require_once('../../config/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = $_POST['review_id'];
    $status = $_POST['status'];

    if (!is_numeric($review_id) || empty($status)) {
        $_SESSION['error_message'] = "ID de l'avis invalide ou statut manquant.";
        header("Location: employe_dashboard.php");
        exit();
    }

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("UPDATE comments SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $review_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Commentaire mis à jour avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la mise à jour du commentaire.";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
    }

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
            <li class="active">
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
                            <a class="active" href="employe_dashboard.php">Valider un avis</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Valider un avis</h3>
                    </div>

                    <!-- Formulaire de validation d'avis -->
                    <form action="" method="POST">
                        <div class="mb-1">
                            <label for="review_id" class="form-label">ID de l'Avis:</label>
                            <input type="number" class="form-control" id="review_id" name="review_id" required>
                        </div>

                        <div class="mb-1">
                            <label for="status" class="form-label">Statut de l'Avis :</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending">En attente</option>
                                <option value="approved">Approuvé</option>
                                <option value="rejected">Rejeté</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success submit">Valider l'avis</button>
                    </form>
                </div>

                <div class="todo">
                    <ul class="todo-list">
                        <li class="completed">
                            <h3>Liste des commentaires</h3>
                            <i class='bx bx-list-ul'></i>
                        </li>
                    </ul>
                     <!-- Affichage des messages -->
                     <?php if (isset($_SESSION['success_message'])) : ?>
                        <div class="alert alert-success">
                            <?php
                            echo htmlspecialchars($_SESSION['success_message']);
                            unset($_SESSION['success_message']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_message'])) : ?>
                        <div class="alert alert-danger">
                            <?php
                            echo htmlspecialchars($_SESSION['error_message']);
                            unset($_SESSION['error_message']);
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php require_once('view_comments.php') ?>
                </div>
            </div>
        </main>
    </section>
    <!-- CONTENU -->
</body>

</html>
