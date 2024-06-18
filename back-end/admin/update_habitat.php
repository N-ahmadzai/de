<?php
require_once('../config/db_connect.php');
session_start();

function uploadPhoto($file)
{
    $target_dir = "uploads/habitats/";
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return "Le fichier n'est pas une image.";
    }

    // Renommer le fichier si un fichier avec le même nom existe déjà
    $i = 1;
    $target_file = $target_dir . basename($file["name"]);
    while (file_exists($target_file)) {
        $target_file = $target_dir . pathinfo($file["name"], PATHINFO_FILENAME) . "_$i." . $imageFileType;
        $i++;
    }

    if ($file["size"] > 2000000) {
        return "Le fichier est trop volumineux.";
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return "Seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
    }

    if (!move_uploaded_file($file["tmp_name"], $target_file)) {
        return "Erreur lors du téléchargement du fichier.";
    }

    return basename($target_file);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Définition des variables $name et $description avec des valeurs par défaut
    $name = isset($_POST['name']) ? $_POST['name'] : "";
    $description = isset($_POST['description']) ? $_POST['description'] : "";

    // Vérifiez si les données nécessaires sont fournies
    if (isset($_POST['habitat_id']) && isset($_POST['name']) && isset($_POST['description'])) {
        $habitat_id = $_POST['habitat_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        try {
            $pdo = getPDO(); // Connexion à la base de données

            // Vérifiez si une nouvelle image est téléchargée
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $upload_result = uploadPhoto($_FILES['image']);

                if (strpos($upload_result, "Erreur") !== false || strpos($upload_result, "Le fichier") !== false) {
                    $_SESSION['error_message'] = $upload_result;
                    header("Location: manage_habitats.php");
                    exit();
                } else {
                    $image_path = 'uploads/habitats/' . $upload_result;
                    $stmt = $pdo->prepare("UPDATE habitats SET name = ?, description = ?, image_url = ? WHERE id = ?");
                    $stmt->execute([$name, $description, $image_path, $habitat_id]);
                }
            } else {
                $stmt = $pdo->prepare("UPDATE habitats SET name = ?, description = ? WHERE id = ?");
                $stmt->execute([$name, $description, $habitat_id]);
            }

            $_SESSION['success_message'] = "L'habitat a été mis à jour avec succès.";
            header("Location: manage_habitats.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erreur lors de la mise à jour de l'habitat : " . $e->getMessage();
            header("Location: manage_habitats.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Données manquantes pour la mise à jour de l'habitat.";
        header("Location: manage_habitats.php");
        exit();
    }
}

// Récupérer les informations actuelles de l'habitat
if (isset($_GET['id'])) {
    $habitat_id = $_GET['id'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM habitats WHERE id = ?");
        $stmt->execute([$habitat_id]);
        $habitat = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$habitat) {
            $_SESSION['error_message'] = "Habitat non trouvé.";
            header("Location: manage_habitats.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la récupération de l'habitat : " . $e->getMessage();
        header("Location: manage_habitats.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "ID d'habitat manquant.";
    header("Location: manage_habitats.php");
    exit();
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
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <div class="container-fluid">
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
                                <h3>Mettre à jour l'habitat</h3>
                            </a>
                        </div>

                        <form action="update_habitat.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="habitat_id" value="<?php echo $habitat['id']; ?>">
                            <div class="form-group">
                                <label for="name">Nom de l'habitat :</label>
                                <input type="text" name="name" class="form-control" id="name" value="<?php echo htmlspecialchars($habitat['name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description :</label>
                                <textarea name="description" class="form-control" id="description" required><?php echo htmlspecialchars($habitat['description']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Image :</label>
                                <input type="file" name="image" class="form-control" id="image">
                                <?php if (!empty($habitat['image_url'])) : ?>
                                    <img src="<?php echo htmlspecialchars($habitat['image_url']); ?>" alt="Image de l'habitat" style="max-width: 200px; margin-top: 10px;">
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-success submit mt-3">Mettre à jour</button>
                        </form>

                    </div>
                </div>
            </main>
        </section>
    </div>
    <script src="js/script.js"></script>
</body>

</html>
