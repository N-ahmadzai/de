<?php
require_once('../config/db_connect.php');
session_start();

try {
    // Récupérer une instance de PDO
    $pdo = getPDO();

    // Requête SQL pour compter le nombre total d'utilisateurs
    $countUsersSql = "SELECT COUNT(*) AS total_users FROM users";
    $stmtUsers = $pdo->query($countUsersSql);
    $resultUsers = $stmtUsers->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le résultat des utilisateurs est valide
    if ($resultUsers) {
        $total_users = $resultUsers['total_users'];
    } else {
        $total_users = 0; // Défaut à 0 si aucun utilisateur n'est trouvé
    }

    // Requête SQL pour compter le nombre total d'animaux
    $countAnimalsSql = "SELECT COUNT(*) AS total_animals FROM animals";
    $stmtAnimals = $pdo->query($countAnimalsSql);
    $resultAnimals = $stmtAnimals->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le résultat des animaux est valide
    if ($resultAnimals) {
        $total_animals = $resultAnimals['total_animals'];
    } else {
        $total_animals = 0; // Défaut à 0 si aucun animal n'est trouvé
    }

    // Requête SQL pour compter le nombre total d'habitats
    $countHabitatsSql = "SELECT COUNT(*) AS total_habitats FROM habitats";
    $stmtHabitats = $pdo->query($countHabitatsSql);
    $resultHabitats = $stmtHabitats->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le résultat des habitats est valide
    if ($resultHabitats) {
        $total_habitats = $resultHabitats['total_habitats'];
    } else {
        $total_habitats = 0; // Défaut à 0 si aucun habitat n'est trouvé
    }

    // Fermer la connexion à la base de données
    $pdo = null;
} catch (PDOException $e) {
    // En cas d'erreur PDO, afficher l'erreur
    die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>AdminHub</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .bxl-baidu,.bxs-group, .bxs-home-circle{
	color: var(--light) !important;
	background-color: var(--green) !important;
}
    </style>
</head>

<body>


    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="admin_dashboard.php" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Arcadia</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
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
            <li>
                <a href="manage_habitats.php">
                    <i class='bx bxs-home-smile'></i>
                    <span class="text">Habitats</span>
                </a>
            </li>
            <li>
                <a href="manage_animals.php">
                <i class='bx bxs-home'></i>
                    <span class="text">Animaux</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
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
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" class="serach" placeholder="Recherche..." style="margin-top:15px;">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <div class="profile">
                <img src="img/logo.png" alt="Profile Image">
                <div class="dropdown-menu">
                    <!-- <a href="profile.php">Mon Profil</a> -->
                    <a href="../login/logout.php" class="logout">Déconnexion</a>
                </div>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- PRINCIPAL -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Tableau de bord admin</h1>
                </div>
                <!-- <a href="#" class="btn-download">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">Télécharger PDF</span>
                </a> -->
            </div>

            <!-- Messages d'erreur et de succès -->
            <?php if (!empty($error_message)) : ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)) : ?>
                <div class="success-message">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <!-- Affichage du nombre total d'utilisateurs -->
                        <h3>Total des Membres : <p><?php echo isset($total_users) ? $total_users : '0'; ?></p>
                        </h3>
                    </span>
                </li>
                <li>
                    <i class='bx bxl-baidu'></i>
                    <span class="text">
                        <h3>Total des Animaux :
                            <p><?php echo isset($total_animals) ? $total_animals : '0'; ?></p>
                        </h3>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-home-circle'></i>
                    <span class="text">
                        <h3>Total des Habitats : <p><?php echo isset($total_habitats) ? $total_habitats : '0'; ?></p>
                        </h3>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Animaux les plus appréciés (hors animal du jour)</h3>
                    </div>
                    <div class="row">
                        <?php
                        try {
                            // Récupérer une instance de PDO
                            $pdo = getPDO();

                            // Requête SQL pour récupérer les animaux les plus cliqués en omettant le premier
                            $mostClickedSql = "SELECT h.name AS habitat_name, a.name AS animal_name, a.race AS animal_race, a.image_url AS animal_image, a.click_count
                                       FROM animals a
                                       LEFT JOIN habitats h ON a.habitat_id = h.id
                                       ORDER BY a.click_count DESC
                                       LIMIT 1, 6"; // Omettre le premier animal et prendre les six suivants
                            $stmtMostClicked = $pdo->query($mostClickedSql);
                            $mostClickedAnimals = $stmtMostClicked->fetchAll(PDO::FETCH_ASSOC);

                            // Vérifier si des animaux ont été trouvés
                            if ($mostClickedAnimals) {
                                foreach ($mostClickedAnimals as $index => $animal) {
                                    // Ouvrir une nouvelle ligne Bootstrap après chaque deux cartes
                                    if ($index % 2 == 0 && $index != 0) {
                                        echo '</div><div class="row">';
                                    }

                                    echo '<div class="col-lg-6 col-md-6 mb-4">';
                                    echo '<div class="card animal-card">';
                                    echo '<img class="card-img-top rounded img-fixed-size" src="' . $animal['animal_image'] . '" alt="' . $animal['animal_name'] . '">';
                                    echo '<div class="card-header">';
                                    echo '<h4>' . $animal['animal_name'] . '</h4>';
                                    echo '</div>';
                                    echo '<div class="card-body">';
                                    echo '<p><strong>Habitat:</strong> ' . $animal['habitat_name'] . '</p>';
                                    echo '<p><strong>Race:</strong> ' . $animal['animal_race'] . '</p>';
                                    echo '<p><strong>Nombre de clics:</strong> ' . $animal['click_count'] . '</p>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<li class="completed">';
                                echo '<h3>Aucun animal trouvé</h3>';
                                echo '</li>';
                            }
                        } catch (PDOException $e) {
                            // En cas d'erreur PDO, afficher l'erreur
                            die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
                        } finally {
                            // Fermer la connexion à la base de données
                            $pdo = null;
                        }
                        ?>
                    </div>
                </div>
                <div class="todo">
                    <div class="head">
                        <h4>Animal du jour</h4>
                    </div>
                    <ul class="todo-list">
                        <?php
                        try {
                            // Récupérer une instance de PDO
                            $pdo = getPDO();

                            // Requête SQL pour récupérer l'animal le plus cliqué
                            $mostClickedSql = "SELECT h.name AS habitat_name, a.name AS animal_name, a.race AS animal_race, a.image_url AS animal_image, a.click_count
                               FROM animals a
                               LEFT JOIN habitats h ON a.habitat_id = h.id
                               ORDER BY a.click_count DESC
                               LIMIT 1";
                            $stmtMostClicked = $pdo->query($mostClickedSql);
                            $mostClickedAnimal = $stmtMostClicked->fetch(PDO::FETCH_ASSOC);

                            // Vérifier si un animal le plus cliqué a été trouvé
                            if ($mostClickedAnimal) {
                                echo '<li class="completed">';
                                echo '<div class="col-lg-12 col-md-6 mb-4">';
                                echo '<div class="card animal-card" style="max-width: 500px;">'; // Limite la largeur de la carte à 500px
                                echo '<img class="card-img-top rounded" src="' . $mostClickedAnimal['animal_image'] . '" alt="' . $mostClickedAnimal['animal_name'] . '" style="max-width: 100%; height: auto;">';
                                echo '<div class="card-header">'; // En-tête de la carte
                                echo '<h4>' . $mostClickedAnimal['animal_name'] . '</h4>';
                                echo '</div>';
                                echo '<div class="card-body">';
                                echo '<p><strong>Habitat:</strong> ' . $mostClickedAnimal['habitat_name'] . '</p>';
                                echo '<p><strong>Race:</strong> ' . $mostClickedAnimal['animal_race'] . '</p>';
                                echo '<p><strong>Nombre de clics:</strong> ' . $mostClickedAnimal['click_count'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</li>';
                            } else {
                                echo '<li class="completed">';
                                echo '<h3>Aucun animal trouvé</h3>';
                                echo '</li>';
                            }
                        } catch (PDOException $e) {
                            // En cas d'erreur PDO, afficher l'erreur
                            die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
                        } finally {
                            // Fermer la connexion à la base de données
                            $pdo = null;
                        }
                        ?>
                    </ul>
                </div>

            </div>
        </main>
        <!-- PRINCIPAL -->
    </section>
    <!-- CONTENU -->

    <script src="js/script.js"></script>
</body>

</html>