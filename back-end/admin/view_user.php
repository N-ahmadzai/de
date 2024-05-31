<?php

//  Récupérer la liste 
// try {
//     $pdo = getPDO();
//     $stmt = $pdo->query("SELECT * FROM users");
//     $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// } catch (PDOException $e) {
//     $error_message = "Erreur : " . $e->getMessage();
// }

require_once('../config/db_connect.php');

// Récupérer la liste des utilisateurs avec rôle "employe" ou "veterinaire"
try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM users WHERE role IN ('employe', 'veterinaire')");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Erreur : " . $e->getMessage();
}


// Recherche
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Filtrer les utilisateurs en fonction de la recherche
if ($search_query !== '') {
    $filtered_users = array_filter($users, function ($user) use ($search_query) {
        return stripos($user['name'], $search_query) !== false || stripos($user['email'], $search_query) !== false;
    });
} else {
    $filtered_users = $users;
}

// Nombre d'utilisateurs par page
$users_per_page = 7;

// Total des utilisateurs après filtrage
$total_filtered_users = count($filtered_users);

// Calcul du nombre de pages
$total_pages = ceil($total_filtered_users / $users_per_page);

// Page actuelle
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Assurez-vous que la page actuelle est dans les limites
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages) {
    $current_page = $total_pages;
}

// Limite inférieure pour la requête SQL ou array_slice
$start_index = ($current_page - 1) * $users_per_page;

// Utilisateurs à afficher sur la page actuelle
$current_page_users = array_slice($filtered_users, $start_index, $users_per_page);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau d'utilisateurs avec pagination et recherche</title>
</head>

<body>
    <!-- Formulaire de recherche -->
    <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Rechercher par nom ou email" value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit"><i class='bx bx-search'></i></button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Email</th>
                <th scope="col">Nom</th>
                <th scope="col">Rôle</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($current_page_users) > 0) : ?>
                <?php foreach ($current_page_users as $user) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td class="actions">
                            <a href="update_user.php?id=<?php echo $user['id']; ?>"><i class='bx bx-edit'></i></a>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');"><i class='bx bxs-trash'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">Aucun utilisateur trouvé</td>
                </tr>
            <?php endif; ?>



            <!-- Affichage des messages -->
            <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
                <div class="success-message">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Liens de pagination -->
    <div class="pagination">
        <?php if ($current_page > 1) : ?>
            <a href="?page=<?php echo $current_page - 1; ?>&search=<?php echo urlencode($search_query); ?>">&laquo; Précédent</a>
        <?php endif; ?>

        <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
            <a href="?page=<?php echo $page; ?>&search=<?php echo urlencode($search_query); ?>" <?php if ($page == $current_page) echo 'class="active"'; ?>>
                <?php echo $page; ?>
            </a>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages) : ?>
            <a href="?page=<?php echo $current_page + 1; ?>&search=<?php echo urlencode($search_query); ?>">Suivant &raquo;</a>
        <?php endif; ?>
    </div>
</body>

</html>