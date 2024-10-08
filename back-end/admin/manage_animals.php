<?php
session_start();
require_once('../config/db_connect.php');

// Fonction pour vérifier le type MIME
function checkMimeType($file)
{
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_mime_type = mime_content_type($file['tmp_name']);
    return in_array($file_mime_type, $allowed_types);
}

// Fonction pour nettoyer le nom du fichier
function sanitizeFileName($filename)
{
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
    return $filename;
}

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les données nécessaires sont fournies
    if (isset($_POST['name']) && isset($_POST['race']) && isset($_POST['habitat']) && isset($_FILES['image'])) {
        $name = $_POST['name'];
        $race = $_POST['race'];
        $habitat = $_POST['habitat'];
        $image = $_FILES['image'];

        // Vérifiez la taille de l'image (par exemple, 2MB maximum)
        if ($image['size'] > 2 * 1024 * 1024) {
            $_SESSION['error_message'] = "Le fichier est trop volumineux. La taille maximale autorisée est de 2MB.";
            header("Location: manage_animals.php");
            exit();
        }

        // Vérifiez le type MIME de l'image
        if (!checkMimeType($image)) {
            $_SESSION['error_message'] = "Type de fichier non valide. Seuls les fichiers JPEG, PNG et GIF sont autorisés.";
            header("Location: manage_animals.php");
            exit();
        }

        // Nettoyez le nom du fichier
        $image_name = sanitizeFileName(basename($image['name']));

        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("INSERT INTO animals (name, race, habitat_id, image_url) VALUES (?, ?, ?, ?)");

            // Déplacer l'image téléchargée vers un répertoire et enregistrer son chemin dans la base de données
            $image_path = 'uploads/animals/' . $image_name;
            move_uploaded_file($image['tmp_name'], $image_path);
            $stmt->execute([$name, $race, $habitat, $image_path]);

            // Définir le message de succès
            $_SESSION['success_message'] = "L'animal a été créé avec succès.";

            // Rediriger vers la page de gestion des animaux
            header("Location: manage_animals.php");
            exit();
        } catch (PDOException $e) {
            // En cas d'erreur, définir le message d'erreur
            $_SESSION['error_message'] = "Erreur lors de la création de l'animal : " . $e->getMessage();

            // Rediriger vers la page de gestion des animaux
            header("Location: manage_animals.php");
            exit();
        }
    } else {
        // Si des données nécessaires sont manquantes, définir le message d'erreur
        $_SESSION['error_message'] = "Données manquantes pour la création de l'animal.";

        // Rediriger vers la page de gestion des animaux
        header("Location: manage_animals.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Animaux</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
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
        <!-- SIDEBAR -->

        <!-- CONTENU -->
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
                                <h3>Créer un animal</h3>
                            </a>
                        </div>

                        <!-- Formulaire de création d'utilisateur -->

                        <!-- Formulaire de création d'animal -->
                        <form action="manage_animals.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom de l'animal</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="race" class="form-label">Race de l'animal</label>
                                <input type="text" class="form-control" id="race" name="race" required>
                            </div>
                            <div class="mb-3">
                                <label for="habitat" class="form-label">Habitat de l'animal</label>
                                <!-- Remplacez les options ci-dessous par les habitats disponibles dans votre base de données -->
                                <select class="form-select" id="habitat" name="habitat" required>
                                    <option value="" selected disabled>Choisissez un habitat</option>
                                    <option value="1">La savane</option>
                                    <option value="2">La jungle</option>
                                    <option value="3">Le Marais</option>
                                    <option value="4">La Forêt Tempérée</option>
                                    <option value="5">La Toundra</option>
                                    <option value="6">La Montagne</option>
                                    <option value="7">Le Désert</option>
                                    <option value="8">L'Océan</option>
                                    <option value="9">La Steppe</option>


                                    <!-- Ajoutez d'autres options si nécessaire -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image de l'animal</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>
                            <button type="submit" class="btn btn-success submit">Créer Animal</button>
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
                                <h3>Gestion des animaux</h3>
                                <i class='bx bx-list-ul'></i>
                            </li>
                        </ul>



                        <!-- inclure la page afficher les animaux -->
                        <?php include_once('view_animals.php') ?>

                    </div>
                </div>
            </main>
        </section>
        <!-- CONTENU -->
    </div>
</body>

</html>