<?php
require_once('../../config/db_connect.php');

session_start();

// Vérification de la connexion de l'utilisateur et de son rôle
if (isset($_SESSION['id']) && $_SESSION['role'] === 'veterinaire') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $habitat_id = filter_input(INPUT_POST, 'habitat_id', FILTER_SANITIZE_NUMBER_INT);
        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($habitat_id && $comment) {
            try {
                $pdo = getPDO();
                $stmt = $pdo->prepare("INSERT INTO habitat_comments (habitat_id, vet_id, comment_date, comment_text) VALUES (?, ?, ?, ?)");
                $stmt->execute([$habitat_id, $_SESSION['id'], date('Y-m-d'), $comment]);

                $_SESSION['success_message'] = "Commentaire ajouté avec succès.";
            } catch (PDOException $e) {
                $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = "Erreur : Tous les champs sont obligatoires.";
        }
    }

    try {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT hc.id, hc.comment_text, h.name AS habitat_name FROM habitat_comments hc JOIN habitats h ON hc.habitat_id = h.id");
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
        $comments = []; // S'assurer que $comments est défini même en cas d'erreur
    }
} else {
    $_SESSION['error_message'] = "Erreur : L'utilisateur n'est pas connecté ou n'a pas les autorisations nécessaires.";
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté ou n'a pas le bon rôle
    header("Location: ../../login/login.php");
    exit(); // Arrête l'exécution du script après la redirection
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Commentaires des Habitats</title>
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
                <a href="veterinaire_dashboard.php">
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
                    <i class='bx bxs-comment-detail'></i>
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
                <a href="../../login/logout.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Déconnexion</span>
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
                    <h2>Tableau de bord Vétérinaire</h2>
                </div>
            </div>

            <div class="head-title">
                <div class="left">
                    <ul class="breadcrumb">
                        <li>
                            <a class="active" href="veterinaire_dashboard.php">Tableau de bord</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="habitat_comments.php">Commentaires</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h4>Ajouter un commentaire</h4>
                    </div>
                    <form action="habitat_comments.php" method="POST">
                        <div class="mb-1">
                            <label for="habitat_id" class="form-label">ID de l'Habitat:</label>
                            <input type="number" class="form-control" id="habitat_id" name="habitat_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Commentaire:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success submit">Ajouter le commentaire</button>
                    </form>
                </div>
                <div class="todo">
                    <ul class="todo-list">
                        <li class="completed">
                            <h4>Liste des commentaires</h4>
                            <i class='bx bx-list-ul'></i>
                        </li>
                    </ul>


                    <?php if (isset($_SESSION['success_message'])) : ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                            <?php unset($_SESSION['success_message']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_message'])) : ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                            <?php unset($_SESSION['error_message']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="order mt-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Habitat</th>
                                    <th scope="col">Commentaire</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($comments)) : ?>
                                    <?php foreach ($comments as $comment) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($comment['habitat_name']); ?></td>
                                            <td><?php echo htmlspecialchars($comment['comment_text']); ?></td>

                                            <td class="actions">
                                                <a href="update_comment.php?id=<?php echo $comment['id']; ?>"><i class='bx bx-edit'></i></a>
                                                <a href="delete_comments.php?id=<?php echo $comment['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rapport ?');"><i class='bx bxs-trash'></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4">Aucun commentaire trouvé.</td>
                                    </tr>
                                <?php
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </main>
        <!-- PRINCIPAL -->
    </section>
    <!-- CONTENU -->
</body>

</html>