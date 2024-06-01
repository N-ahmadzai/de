<?php
require_once('../config/db_connect.php');
session_start();

// Récupérer le nombre total d'utilisateurs
try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT COUNT(*) as total_users FROM users");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_users = $result['total_users'];
} catch (PDOException $e) {
    $error_message = "Erreur : " . $e->getMessage();
}

// Si vous avez d'autres logiques ou variables à récupérer, ajoutez-les ici

?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>AdminHub</title>
    <link rel="stylesheet" href="css/dashboard.css">
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
                <i class='bx bxs-user-account' ></i>
                    <span class="text">Membres</span>
                </a>
            </li>
            <li>
                <a href="manage_services.php">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Service</span>
                </a>
            </li>
            <li>
                <a href="manage_horaires.php">
                 <i class='bx bxs-hourglass' ></i>
                    <span class="text">Horaires</span>
                </a>
            </li>
            <li>
                <a href="manage_horaires.php">
                <i class='bx bxs-hourglass' ></i>
                    <span class="text">Horaires</span>
                </a>
            </li>
            <li class="active">
                <a href="#">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="#">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="#">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
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
                <a href="#" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
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
            <a href="#" class="nav-link">Catégories</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" class="serach" placeholder="Recherche..." style="margin-top:15px;">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
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
                    <h1>Tableau de bord</h1>
                </div>
                <a href="#" class="btn-download">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">Télécharger PDF</span>
                </a>
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
                    <i class='bx bxs-calendar-check'></i>
                    <span class="text">
                        <h3>1020</h3>
                        <p>Nouvelle Commande</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <!-- Affichage du nombre total d'utilisateurs -->
                        <h3>Total des membres : <p><?php echo $total_users; ?></p>
                        </h3>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-dollar-circle'></i>
                    <span class="text">
                        <h3>$2543
                    </span>
                    <p>Ventes Totales</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Commandes Récentes</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Date de Commande</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="img/logo.png">
                                    <p>John Doe</p>
                                </td>
                                <td>01-10-2021</td>
                                <td><span class="status completed">Complété</span></td>
                            </tr>
                            <!-- Autres lignes -->
                        </tbody>
                    </table>
                </div>
                <div class="todo">
                    <div class="head">
                        <h3>Liste de Tâches</h3>
                        <i class='bx bx-plus'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <ul class="todo-list">
                        <li class="completed">
                            <p>Liste de Tâches</p>
                            <i class='bx bx-dots-vertical-rounded'></i>
                        </li>
                        <!-- Autres tâches -->
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