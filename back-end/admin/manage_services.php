<?php 
session_start(); // Démarrage de la session

require_once('../config/db_connect.php');
require_once('delete_service.php');

function uploadPhoto($file)
{
    $target_dir = "uploads/";
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . uniqid() . "." . $imageFileType;  // Génère un nom de fichier unique

    // Vérifie si le fichier est une véritable image ou une fausse image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return "Le fichier n'est pas une image.";
    }

    // Vérifie la taille du fichier
    if ($file["size"] > 500000) { // 500 KB
        return "Le fichier est trop volumineux.";
    }

    // Autorise uniquement certains formats de fichiers
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        return "Seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
    }

    // Tente de télécharger le fichier
    if (!move_uploaded_file($file["tmp_name"], $target_file)) {
        return "Erreur lors du téléchargement du fichier.";
    }

    return basename($target_file);  // Retourne le nom de fichier unique
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $service_id = $_POST['service_id'] ?? null;
    $service_name = $_POST['name'] ?? null;
    $service_description = $_POST['description'] ?? null;
    $photo = isset($_FILES['photo']) ? uploadPhoto($_FILES['photo']) : null;

    // Vérification si uploadPhoto retourne une erreur
    if (is_string($photo) && strpos($photo, '.') === false) {
        $_SESSION['error_message'] = $photo;  // Message d'erreur retourné par uploadPhoto
    } else {
        try {
            $pdo = getPDO();

            if ($action == 'create') {
                $stmt = $pdo->prepare("INSERT INTO services (name, description, photo) VALUES (?, ?, ?)");
                $stmt->execute([$service_name, $service_description, $photo]);
                $_SESSION['success_message'] = "Le service a été créé avec succès.";
            } elseif ($action == 'update') {
                if ($photo) {
                    $stmt = $pdo->prepare("UPDATE services SET name = ?, description = ?, photo = ? WHERE id = ?");
                    $stmt->execute([$service_name, $service_description, $photo, $service_id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE services SET name = ?, description = ? WHERE id = ?");
                    $stmt->execute([$service_name, $service_description, $service_id]);
                }
                $_SESSION['success_message'] = "Le service a été mis à jour avec succès.";
            } elseif ($action == 'delete') {
                $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
                $stmt->execute([$service_id]);
                $_SESSION['success_message'] = "Le service a été supprimé avec succès.";
            }

            header("Location: manage_services.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
        }
    }
}

// Récupérer la liste des services
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
    <title>Gérer les services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/service.css">
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
                <i class='bx bxs-user-account' ></i>
                    <span class="text">Membres</span>
                </a>
            </li>
            <li class="active">
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
            <main>
                <div class="head-title">
                    <div class="left">
                        <h1>Gérer les services</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a class="active" href="admin_dashboard.php">Tableau de bord</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="manage_services.php">Services</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <a href="manage_services.php">
                                <h3>Créer un nouveau service</h3>
                            </a>
                        </div>

                        <!-- Formulaire pour créer un nouveau service -->
                        <form method="POST" action="manage_services.php" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="create">
                            <label for="name">Nom du service:</label>
                            <input class="form-control" type="text" id="name" name="name" required>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">Choisir un fichier</label>
                                <input class="form-control" type="file" id="photo" name="photo" required>
                            </div>
                            <button class="btn btn-success submit" type="submit">Créer</button>
                        </form>
                        <!-- // Afficher les messages de succès ou d'erreur -->
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
                                <h3>Liste des services</h3>
                                <i class='bx bx-list-ul'></i>
                            </li>
                        </ul>
                        

                        <!-- inclure la page afficher les services -->
                        <?php include_once('view_services.php') ?>
                    </div>
                </div>
            </main>
        </section>
        <!-- CONTENU -->
    </div>
    <script src="js/script.js"></script>
</body>

</html>
