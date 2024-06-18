<?php
require_once('../config/db_connect.php');
session_start();

function uploadPhoto($file)
{
    $target_dir = "uploads/animals/";
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
    $animal_id = isset($_POST['animal_id']) ? $_POST['animal_id'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : "";
    $race = isset($_POST['race']) ? $_POST['race'] : "";
    $habitat_id = isset($_POST['habitat_id']) ? $_POST['habitat_id'] : "";

    if ($animal_id && $name && $race && $habitat_id) {
        try {
            $pdo = getPDO();

            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $upload_result = uploadPhoto($_FILES['image']);

                if (strpos($upload_result, "Erreur") !== false || strpos($upload_result, "Le fichier") !== false) {
                    $_SESSION['error_message'] = $upload_result;
                    header("Location: manage_animals.php");
                    exit();
                } else {
                    $image_path = 'uploads/animals/' . $upload_result;
                    $stmt = $pdo->prepare("UPDATE animals SET name = ?, race = ?, habitat_id = ?, image_url = ? WHERE id = ?");
                    $stmt->execute([$name, $race, $habitat_id, $image_path, $animal_id]);
                }
            } else {
                $stmt = $pdo->prepare("UPDATE animals SET name = ?, race = ?, habitat_id = ? WHERE id = ?");
                $stmt->execute([$name, $race, $habitat_id, $animal_id]);
            }

            $_SESSION['success_message'] = "L'animal a été mis à jour avec succès.";
            header("Location: manage_animals.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erreur lors de la mise à jour de l'animal : " . $e->getMessage();
            header("Location: manage_animals.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Données manquantes pour la mise à jour de l'animal.";
        header("Location: manage_animals.php");
        exit();
    }
}

if (isset($_GET['id'])) {
    $animal_id = $_GET['id'];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM animals WHERE id = ?");
        $stmt->execute([$animal_id]);
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$animal) {
            $_SESSION['error_message'] = "Animal non trouvé.";
            header("Location: manage_animals.php");
            exit();
        }

        $stmt = $pdo->prepare("SELECT id, name FROM habitats");
        $stmt->execute();
        $habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la récupération des données : " . $e->getMessage();
        header("Location: manage_animals.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "ID de l'animal manquant.";
    header("Location: manage_animals.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les animaux</title>
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
                <li>
                    <a href="manage_habitats.php">
                        <i class='bx bxs-home-smile'></i>
                        <span class="text">Habitats</span>
                    </a>
                </li>
                <li class="active">
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
                        <h1>Gérer les Animaux</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a class="active" href="admin_dashboard.php">Tableau de bord</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="manage_animals.php">Animaux</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <a href="manage_animals.php">
                                <h3>Mettre à jour l'animal</h3>
                            </a>
                        </div>

                        <form action="update_animal.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="animal_id" value="<?php echo $animal['id']; ?>">
                            <div class="form-group">
                                <label for="name">Nom de l'animal :</label>
                                <input type="text" name="name" class="form-control" id="name" value="<?php echo htmlspecialchars($animal['name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="race">Race :</label>
                                <input type="text" name="race" class="form-control" id="race" value="<?php echo htmlspecialchars($animal['race']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="habitat_id">Habitat :</label>
                                <select name="habitat_id" class="form-control" id="habitat_id" required>
                                    <?php foreach ($habitats as $habitat): ?>
                                        <option value="<?php echo $habitat['id']; ?>" <?php echo $habitat['id'] == $animal['habitat_id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($habitat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Image :</label>
                                <input type="file" name="image" class="form-control" id="image">
                                <?php if (!empty($animal['image_url'])) : ?>
                                    <img src="<?php echo htmlspecialchars($animal['image_url']); ?>" alt="Image de l'animal" style="max-width: 200px; margin-top: 10px;">
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
