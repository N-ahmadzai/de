<?php
require_once('../../config/db_connect.php');

// Nombre de commentaires par page
$comments_per_page = 10;

// Page actuelle
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

try {
    // Récupérer le nombre total de commentaires
    $pdo = getPDO();
    $count_stmt = $pdo->query("SELECT COUNT(*) FROM comments");
    $total_comments = $count_stmt->fetchColumn();

    // Calcul du nombre total de pages
    $total_pages = ceil($total_comments / $comments_per_page);

    // Assurez-vous que la page actuelle est dans les limites
    if ($current_page < 1) {
        $current_page = 1;
    } elseif ($current_page > $total_pages) {
        $current_page = $total_pages;
    }

    // Calcul de l'indice de départ pour la requête SQL
    $start_index = ($current_page - 1) * $comments_per_page;

    // Récupérer les commentaires pour la page actuelle
    $stmt = $pdo->prepare("SELECT * FROM comments ORDER BY id DESC LIMIT :start, :limit");
    $stmt->bindParam(':start', $start_index, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $comments_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Liste des commentaires</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../admin/css/employer.css">
</head>

<body>
    <div class="container">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Avis</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($comment['id']); ?></td>
                        <td><?php echo htmlspecialchars($comment['pseudo']); ?></td>
                        <td><?php echo htmlspecialchars($comment['avis']); ?></td>
                        <td><?php echo htmlspecialchars($comment['status']); ?></td>
                        <td>
                            <a href="approve_comment.php?id=<?php echo $comment['id']; ?>" style="color:#2EB872;"><i class='bx bx-edit'></i></a>
                            <a href="delete_comment.php?id=<?php echo $comment['id']; ?>" style="color:#2EB872;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');"><i class='bx bx-trash'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($current_page > 1) : ?>
                <a href="?page=<?php echo $current_page - 1; ?>" class="btn btn-secondary">&laquo; Précédent</a>
            <?php endif; ?>

            <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                <a href="?page=<?php echo $page; ?>" class="btn btn-secondary <?php if ($page === $current_page) echo 'active'; ?>"><?php echo $page; ?></a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages) : ?>
                <a href="?page=<?php echo $current_page + 1; ?>" class="btn btn-secondary">Suivant &raquo;</a>
            <?php endif; ?>
        </div>

        <!-- Affichage des messages -->
        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger mt-3">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>