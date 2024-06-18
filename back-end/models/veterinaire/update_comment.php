<?php
require_once('../../config/db_connect.php');

session_start();

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $comment_id = $_POST['comment_id'];
    $habitat_id = $_POST['habitat_id'];
    $comment_text = $_POST['comment_text'];

    try {
        // Mise à jour du commentaire dans la base de données
        $pdo = getPDO();
        $stmt = $pdo->prepare("UPDATE habitat_comments SET habitat_id = ?, comment_text = ? WHERE id = ?");
        $stmt->execute([$habitat_id, $comment_text, $comment_id]);

        // Message de succès et redirection
        $_SESSION['success_message'] = "Commentaire mis à jour avec succès.";
        header("Location: habitat_comments.php");
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, message d'erreur et redirection
        $_SESSION['error_message'] = "Erreur lors de la mise à jour du commentaire : " . $e->getMessage();
        header("Location: habitat_comments.php");
        exit();
    }
} else {
    // Vérification si l'ID du commentaire est présent dans l'URL
    if (isset($_GET['id'])) {
        // Récupération de l'ID du commentaire depuis l'URL
        $comment_id = $_GET['id'];

        try {
            // Récupération des données du commentaire depuis la base de données
            $pdo = getPDO();
            $stmt = $pdo->prepare("SELECT * FROM habitat_comments WHERE id = ?");
            $stmt->execute([$comment_id]);
            $comment = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En cas d'erreur, message d'erreur et redirection
            $_SESSION['error_message'] = "Erreur lors de la récupération du commentaire : " . $e->getMessage();
            header("Location: habitat_comments.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Mettre à jour le commentaire</title>
    <link rel="stylesheet" href="../../admin/css/dashboard.css">
</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="veterinaire_dashboard.php" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Arcadia</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="habitat_comments.php">
                    <i class='bx bxs-add-to-queue'></i>
                    <span class="text">Ajouter un rapport</span>
                </a>
            </li>
            <li>
                <a href="view_animals.php">
                    <i class='bx bxl-baidu'></i>
                    <span class="text">Animaux</span>
                </a>
            </li>
            <li class="active">
                <a href="habitat_comments.php">
                <i class='bx bxs-comment-detail' ></i>
                    <span class="text">Commentaires</span>
                </a>
            </li>
            <li>
                <a href="view_animal_food.php">
                    <i class='bx bx-food-menu'></i>
                    <span class="text">Alimentation</span>
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
                <a href="../../login/logout.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENU -->
    <section id="content">
        <!-- PRINCIPAL -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h2>Mettre à jour le commentaire</h2>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h4>Modifier le commentaire</h4>
                    </div>
                    <form action="" method="POST">
                        <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment['id']); ?>">
                        <div class="mb-1">
                            <label for="habitat_id" class="form-label">Habitat ID:</label>
                            <input type="number" class="form-control" id="habitat_id" name="habitat_id" value="<?php echo htmlspecialchars($comment['habitat_id']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="comment_text" class="form-label">Commentaire:</label>
                            <textarea class="form-control" id="comment_text" name="comment_text" rows="3" required><?php echo htmlspecialchars($comment['comment_text']); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-success submit">Mettre à jour le commentaire</button>
                    </form>
                </div>
            </div>
        </main>
        <!-- PRINCIPAL -->
    </section>
    <!-- CONTENU -->

</body>

</html>
