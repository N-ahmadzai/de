<?php
// Inclure le fichier de connexion à la base de données
session_start();

require_once('../config/db_connect.php');

// Récupérer l'identifiant de l'habitat depuis l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Appeler la fonction getPDO() pour obtenir une instance de PDO
    $pdo = getPDO();

    // Récupérer les détails de l'habitat depuis la base de données
    $stmt = $pdo->prepare("SELECT * FROM habitats WHERE id = ?");
    $stmt->execute([$id]);
    $habitat = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'habitat existe
    if ($habitat) {
        // Récupérer d'autres données liées à l'habitat si nécessaire
        // ...
    } else {
        echo "Habitat non trouvé.";
        exit();
    }
} else {
    echo "ID d'habitat manquant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Habitat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   
</body>
</html>


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
                <li>
                    <a href="manage_habitats.php">
                        <i class='bx bxl-baidu'></i>
                        <span class="text">Habitats</span>
                    </a>
                </li>
                <li class="active">
                    <a href="habitat_detail.php">
                        <i class='bx bxl-baidu'></i>
                        <span class="text">Habitat detail</span>
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


                        <div class="container">
        <h1><?php echo htmlspecialchars($habitat['name']); ?></h1>
        <p><?php echo htmlspecialchars($habitat['description']); ?></p>

        <h2>Animaux</h2>
        <div class="row">
            <?php foreach ($animaux as $animal) : ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <?php
                        // Récupérer l'image de l'animal depuis la base de données
                        $stmt = $pdo->prepare("SELECT image_url FROM animal_images WHERE animal_id = ?");
                        $stmt->execute([$animal['id']]);
                        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php if (!empty($images)) : ?>
                            <img src="<?php echo htmlspecialchars($images[0]['image_url']); ?>" class="card-img-top" alt="Image de l'animal">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($animal['prename']); ?></h5>
                            <a href="animal_detail.php?id=<?php echo $animal['id']; ?>" class="btn btn-primary">Voir les détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
                    </div>

                    <div class="todo">
                        <ul class="todo-list">
                            <li class="completed">
                                <h3>Habitat photo</h3>
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
    <script src="js/script.js"></script>
</body>

</html>
