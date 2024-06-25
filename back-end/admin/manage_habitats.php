<?php
session_start();
require_once('../config/db_connect.php');

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les données nécessaires sont fournies
    if (isset($_POST['name']) && isset($_POST['description']) && isset($_FILES['image'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $image = $_FILES['image'];

        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("INSERT INTO habitats (name, description, image_url) VALUES (?, ?, ?)");
            // Move uploaded image to a directory and save its path in the database
            $image_path = 'uploads/habitats/' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], $image_path);
            $stmt->execute([$name, $description, $image_path]);

            // Définir le message de succès
            $_SESSION['success_message'] = "L'habitat a été créé avec succès.";

            // Rediriger vers la page de gestion des habitats
            header("Location: manage_habitats.php");
            exit();
        } catch (PDOException $e) {
            // En cas d'erreur, définir le message d'erreur
            $_SESSION['error_message'] = "Erreur lors de la création de l'habitat : " . $e->getMessage();

            // Rediriger vers la page de gestion des habitats
            header("Location: manage_habitats.php");
            exit();
        }
    } else {
        // Si des données nécessaires sont manquantes, définir le message d'erreur
        $_SESSION['error_message'] = "Données manquantes pour la création de l'habitat.";

        // Rediriger vers la page de gestion des habitats
        header("Location: manage_habitats.php");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les habitats</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/habitat.css">
</head>

<body>
    <div class="container-fluid">
        <!-- SIDEBAR -->
        <section id="sidebar">
            <a href="admin_dashboard.php" class="brand">
                <i class='bx bxs-smile'></i>
                <span class="text">Arcadia</span>
            </a>
            <ul class="side-menu top">
                <li>
                    <a href="admin_dashboard.php">
                        <i class='bx bxs-dashboard'></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="manage_user.php">
                        <i class='bx bxs-user-account'></i>
                        <span class="text">Membres</span>
                    </a>
                </li>
                <li>
                    <a href="manage_services.php">
                        <i class='bx bxs-doughnut-chart'></i>
                        <span class="text">Services</span>
                    </a>
                </li>
                <li>
                    <a href="manage_horaires.php">
                        <i class='bx bxs-hourglass'></i>
                        <span class="text">Horaires</span>
                    </a>
                </li>
                <li class="active">
                    <a href="manage_habitats.php">
                    <i class='bx bxs-home-smile'></i>
                        <span class="text">Habitats</span>
                    </a>
                </li>
                <li>
                    <a href="manage_animals.php">
                        <i class='bx bxl-baidu'></i>
                        <span class="text">Animaux</span>
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
                    <a href="../login/logout.php" class="logout">
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
                        <h1>Gérer les Habitats</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a class="active" href="admin_dashboard.php">Tableau de bord</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="manage_habitats.php">Habitats</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <a href="manage_habitats.php">
                                <h3>Créer un habitat</h3>
                            </a>
                        </div>

                        <!-- Formulaire de création d'utilisateur -->
              
        <form action="manage_habitats.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Nom de l'habitat</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image de l'habitat</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-success submit">Créer Habitat</button>
        </form>
   

                        <?php if (isset($_SESSION['success_message'])) : ?>
                            <div class="alert alert-success mt-3"><?php echo htmlspecialchars($_SESSION['success_message']); ?></div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error_message'])) : ?>
                            <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($_SESSION['error_message']); ?></div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>
                    </div>

                    <div class="todo">
                        <ul class="todo-list">
                            <li class="completed">
                                <h3>Gestion des Habitats</h3>
                                <i class='bx bx-list-ul'></i>
                            </li>
                        </ul>



                        <!-- inclure la page afficher les habitats -->
                        <?php include_once('view_habitats.php') ?>


                    </div>
                </div>
            </main>
        </section>
        <!-- CONTENU -->
    </div>
</body>

</html>
