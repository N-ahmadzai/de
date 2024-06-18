<?php
require_once('../config/db_connect.php');
session_start();


function uploadPhoto($file)
{
    $target_dir = "uploads/services/";
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

    if ($file["size"] > 500000) {
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



// function uploadPhoto($file)
// {
//     $target_dir = "uploads/services//";
//     $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

//     $check = getimagesize($file["tmp_name"]);
//     if ($check === false) {
//         return "Le fichier n'est pas une image.";
//     }


//     //Générer un nom de fichier aléatoire
//     $random_name = uniqid('', true) . '.' . $imageFileType;
//     $target_file = $target_dir . $random_name;

//     if ($file["size"] > 500000) {
//         return "Le fichier est trop volumineux.";
//     }

//     if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
//         return "Seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
//     }

//     if (!move_uploaded_file($file["tmp_name"], $target_file)) {
//         return "Erreur lors du téléchargement du fichier.";
//     }

//     return $random_name;
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['service_id'];
    $service_name = $_POST['name'];
    $service_description = $_POST['description'];
    $photo = isset($_FILES['photo']) ? uploadPhoto($_FILES['photo']) : null;

    try {
        $pdo = getPDO();

        if ($photo) {
            $stmt = $pdo->prepare("UPDATE services SET name = ?, description = ?, photo = ? WHERE id = ?");
            $stmt->execute([$service_name, $service_description, $photo, $service_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE services SET name = ?, description = ? WHERE id = ?");
            $stmt->execute([$service_name, $service_description, $service_id]);
        }

        $_SESSION['success_message'] = "Le service a été mis à jour avec succès.";
        header("Location: manage_services.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
    }
}

// Récupérer les informations actuelles du service
$service_id = $_GET['id'];
try {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$service_id]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Mise à jour services</title>
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
                        <span class="text">Services</span>
                    </a>
                </li>
                <li>
                    <a href=""manage_horaires.php>
                    <i class='bx bxs-hourglass' ></i>
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
                        <h1>Gérer les services</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a class="active" href="admin_dashboard.php">Tableau de borad</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="update_service.php">Mettre à jour le service</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <a href="update_service.php">
                                <h3>Mettre à jour le service</h3>
                            </a>
                        </div>


       
        <form method="POST" action="update_service.php" enctype="multipart/form-data">
            <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nom du service:</label>
                <input class="form-control" type="text" id="name" name="name" value="<?php echo htmlspecialchars($service['name']); ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($service['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Choisir un fichier:</label>
                <input class="form-control" type="file" id="photo" name="photo">
            </div>
            <button class="btn btn-success submit" type="submit">Mettre à jour</button>
        </form>
        
                    </div>
            </main>
        </section>
        <!-- CONTENU -->
    </div>
    <script src="js/script.js"></script>
</body>

</html>