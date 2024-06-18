<?php
require_once('../../config/db_connect.php');
session_start();

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $comment_id = $_POST['comment_id'];
    $status = $_POST['status'];

    try {
        // Mise à jour du statut du commentaire dans la base de données
        $pdo = getPDO();
        $stmt = $pdo->prepare("UPDATE comments SET status = ? WHERE id = ?");
        $stmt->execute([$status, $comment_id]);

        // Message de succès et redirection
        $_SESSION['success_message'] = "Commentaire mis à jour avec succès.";
        header("Location: employe_dashboard.php");
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, message d'erreur et redirection
        $_SESSION['error_message'] = "Erreur lors de la mise à jour du commentaire : " . $e->getMessage();
        header("Location: employe_dashboard.php");
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
            $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ?");
            $stmt->execute([$comment_id]);
            $comment = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification de l'existence du commentaire
            if (!$comment) {
                $_SESSION['error_message'] = "Commentaire introuvable.";
                header("Location: employe_dashboard.php");
                exit();
            }
        } catch (PDOException $e) {
            // En cas d'erreur, message d'erreur et redirection
            $_SESSION['error_message'] = "Erreur lors de la récupération du commentaire : " . $e->getMessage();
            header("Location: employe_dashboard.php");
            exit();
        }
    } else {
        // Redirection si l'ID n'est pas présent dans l'URL
        $_SESSION['error_message'] = "Aucun ID de commentaire fourni.";
        header("Location: employe_dashboard.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Approuver le Commentaire</title>
    <link rel="stylesheet" href="../../admin/css/dashboard.css">
</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="employe_dashboard.php" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Arcadia</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="employe_dashboard.php">
                <i class='bx bxs-comment-check' ></i>
                    <span class="text">Valider un avis</span>
                </a>
            </li>
            <li>
                <a href="view_service.php">
                <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Service</span>
                </a>
            </li>
            <li>
                <a href="add_animal_food.php">
                <i class='bx bxs-add-to-queue' ></i>
                    <span class="text">Ajout de nourriture</span>
                </a>
            </li>
            <li class="active">
                <a href="habitat_comments.php">
                <i class='bx bxs-comment-detail' ></i>
                    <span class="text">Commentaires</span>
                </a>
            </li>
            <li>
                <a href="list_animal_food.php   ">
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
                    <h2>Approuver le Commentaire</h2>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h4>Modifier le statut du commentaire</h4>
                    </div>
                    <form action="" method="POST">
                        <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment['id']); ?>">
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Statut:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending" <?php echo $comment['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="approved" <?php echo $comment['status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                                <option value="rejected" <?php echo $comment['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success submit">Mettre à jour le statut</button>
                    </form>
                    
                </div>
            </div>
        </main>
        <!-- PRINCIPAL -->
    </section>
    <!-- CONTENU -->

</body>

</html>
