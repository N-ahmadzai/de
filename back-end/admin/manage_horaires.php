<?php
require_once('../config/db_connect.php');
require_once('delete_horaires.php');

// session_start(); // Démarrage de la session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jour_semaine = $_POST['jour_semaine'];
    $heure_ouverture = $_POST['heure_ouverture'];
    $heure_fermeture = $_POST['heure_fermeture'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO horaires (jour_semaine, heure_ouverture, heure_fermeture) VALUES (?, ?, ?)");
        $stmt->execute([$jour_semaine, $heure_ouverture, $heure_fermeture]);

        // Après l'ajout réussi d'un horaire
        $_SESSION['success_message'] = "Horaire ajouté avec succès.";

        header("Location: manage_horaires.php");
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur lors de l'ajout d'un horaire
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();

        header("Location: manage_horaires.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les services</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/horaire.css">
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
                <li class="active">
                    <a href="manage_horaires.php">
                        <i class='bx bxs-hourglass'></i>
                        <span class="text">Horaires</span>
                    </a>
                </li>
                <li>
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
                        <h1>Gérer les Horaires</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a class="active" href="admin_dashboard.php">Tableau de bord</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="manage_horaires.php">Horaires</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-data">
                    <div class="order">
                        <div class="head">
                        <a href="manage_horaires.php">
                        <h3>Ajouter un nouvel horaire</h3>
                            </a>
                        </div>
                        <!-- Formulaire de création d'utilisateur -->
                        <form method="POST" action="manage_horaires.php">
                            <div class="mb-3">
                                <label class="form-label" for="jour_semaine">Jour de la semaine :</label>
                                <select class="form-select custom-select" name="jour_semaine" id="jour_semaine">
                                    <option value="Lundi">Lundi</option>
                                    <option value="Mardi">Mardi</option>
                                    <option value="Mercredi">Mercredi</option>
                                    <option value="Jeudi">Jeudi</option>
                                    <option value="Vendredi">Vendredi</option>
                                    <option value="Samedi">Samedi</option>
                                    <option value="Dimanche">Dimanche</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="heure_ouverture">Heure d'ouverture :</label>
                                <input class="form-control custom-input" type="time" id="heure_ouverture" name="heure_ouverture" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="heure_fermeture">Heure de fermeture :</label>
                                <input class="form-control custom-input" type="time" id="heure_fermeture" name="heure_fermeture" required>
                            </div>
                            <button class="btn btn-success submit" type="submit">Ajouter Horaire</button>
                        </form>
                   

                    <?php if (isset($_SESSION['success_message'])) : ?>
                            <div class="alert alert-success mt-3">
                                <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                            </div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error_message'])) : ?>
                            <div class="alert alert-danger mt-3">
                                <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                            </div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>

                    </div>
                    <div class="todo">
                        <ul class="todo-list">
                            <li class="completed">
                                <h3>Gestion des Horaires</h3>
                                <i class='bx bx-list-ul'></i>
                            </li>
                        </ul>



                        <?php if (isset($_SESSION['delete_source'])) : ?>
                            <?php if ($_SESSION['delete_source'] === 'manage_horaires' && isset($_GET['status']) && isset($_GET['message'])) : ?>
                                <?php if ($_GET['status'] === 'success') : ?>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo htmlspecialchars($_GET['message']); ?>
                                    </div>
                                <?php elseif ($_GET['status'] === 'error') : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo htmlspecialchars($_GET['message']); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php unset($_SESSION['delete_source']); ?>
                        <?php endif; ?>



                        <!-- inclure la page afficher les services -->
                        <?php include_once('view_horaires.php') ?>
                    </div>
                </div>
            </main>
        </section>
        <!-- CONTENU -->
    </div>
    <script src="js/script.js"></script>
</body>
</html>
