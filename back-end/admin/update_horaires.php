<?php
require_once('../config/db_connect.php');


$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $jour_semaine = $_POST['jour_semaine'];
    $heure_ouverture = $_POST['heure_ouverture'];
    $heure_fermeture = $_POST['heure_fermeture'];

    try {
        $stmt = $pdo->prepare("UPDATE horaires SET jour_semaine = ?, heure_ouverture = ?, heure_fermeture = ? WHERE id = ?");
        $stmt->execute([$jour_semaine, $heure_ouverture, $heure_fermeture, $id]);
        header("Location: manage_horaires.php?success=Horaire modifié avec succès");
        exit();
    } catch (PDOException $e) {
        header("Location: manage_horaires.php?error=Erreur : " . $e->getMessage());
        exit();
    }
} else {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM horaires WHERE id = ?");
    $stmt->execute([$id]);
    $horaire = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$horaire) {
        header("Location: manage_horaires.php?error=Horaire non trouvé");
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
    <title>Mise à jour horaires</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">
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
                    <a href="" manage_horaires.php>
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
                        <h1>Gérer les horaires</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a class="active" href="admin_dashboard.php">Tableau de borad</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="update_service.php">Mettre à jour les horaires</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <a href="update_service.php">
                                <h3>Mettre à jour les horaires</h3>
                            </a>
                        </div>



                        <form method="POST" action="update_horaires.php">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($horaire['id']); ?>">
                            <div class="mb-3">
                                <label class="form-label" for="jour_semaine">Jour de la semaine :</label>
                                <select class="form-select" name="jour_semaine" id="jour_semaine">
                                    <option value="Lundi" <?php if ($horaire['jour_semaine'] == 'Lundi') echo 'selected'; ?>>Lundi</option>
                                    <option value="Mardi" <?php if ($horaire['jour_semaine'] == 'Mardi') echo 'selected'; ?>>Mardi</option>
                                    <option value="Mercredi" <?php if ($horaire['jour_semaine'] == 'Mercredi') echo 'selected'; ?>>Mercredi</option>
                                    <option value="Jeudi" <?php if ($horaire['jour_semaine'] == 'Jeudi') echo 'selected'; ?>>Jeudi</option>
                                    <option value="Vendredi" <?php if ($horaire['jour_semaine'] == 'Vendredi') echo 'selected'; ?>>Vendredi</option>
                                    <option value="Samedi" <?php if ($horaire['jour_semaine'] == 'Samedi') echo 'selected'; ?>>Samedi</option>
                                    <option value="Dimanche" <?php if ($horaire['jour_semaine'] == 'Dimanche') echo 'selected'; ?>>Dimanche</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="heure_ouverture">Heure d'ouverture :</label>
                                <input class="form-control" type="time" id="heure_ouverture" name="heure_ouverture" value="<?php echo htmlspecialchars($horaire['heure_ouverture']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="heure_fermeture">Heure de fermeture :</label>
                                <input class="form-control" type="time" id="heure_fermeture" name="heure_fermeture" value="<?php echo htmlspecialchars($horaire['heure_fermeture']); ?>" required>
                            </div>
                            <button class="btn btn-success" type="submit">Modifier Horaire</button>
                        </form>
            </main>
        </section>
        <!-- CONTENU -->
    </div>
</body>

</html>