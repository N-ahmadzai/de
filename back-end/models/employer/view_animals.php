<?php
require_once('../../config/db_connect.php');

// Récupérer la liste des animaux depuis la base de données
try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT a.id, a.name, a.race, a.image_url, h.name as habitat_name FROM animals a JOIN habitats h ON a.habitat_id = h.id");
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Erreur : " . $e->getMessage();
}

// Recherche
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Filtrer les animaux en fonction de la recherche
if ($search_query !== '') {
    $filtered_animals = array_filter($animals, function ($animal) use ($search_query) {
        return stripos($animal['name'], $search_query) !== false || stripos($animal['race'], $search_query) !== false;
    });
} else {
    $filtered_animals = $animals;
}

// Nombre d'animaux par page
$animals_per_page = 7;

// Total des animaux après filtrage
$total_filtered_animals = count($filtered_animals);

// Calcul du nombre de pages
$total_pages = ceil($total_filtered_animals / $animals_per_page);

// Page actuelle
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Assurez-vous que la page actuelle est dans les limites
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages) {
    $current_page = $total_pages;
}

// Limite inférieure pour la requête SQL ou array_slice
$start_index = ($current_page - 1) * $animals_per_page;

// Animaux à afficher sur la page actuelle
$current_page_animals = array_slice($filtered_animals, $start_index, $animals_per_page);


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Afficher les animaux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../admin/css/employer.css">
</head>

<body>
    <div class="container">
        <!-- Afficher les messages d'erreur ou de succès -->
        <?php if (isset($_GET['success'])) : ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])) : ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <div class="container">
            <!-- Formulaire de recherche -->
            <form class="search-form" method="GET" action="">
                <input type="text" class="mb-3" name="search" placeholder="Rechercher par nom ou race" value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Race</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Habitat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($current_page_animals) > 0) : ?>
                        <?php foreach ($current_page_animals as $animal) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($animal['id']); ?></td>
                                <td><?php echo htmlspecialchars($animal['name']); ?></td>
                                <td><?php echo htmlspecialchars($animal['race']); ?></td>
                                <td>
                                    <?php if (!empty($animal['image_url'])) : ?>
                                        <?php $imagePath = "../../admin/" . htmlspecialchars($animal['image_url']); ?>
                                        <?php if (file_exists($imagePath)) : ?>
                                            <img src="<?php echo $imagePath; ?>" alt="Image de l'animal" width="50">
                                        <?php else : ?>
                                            Image introuvable
                                        <?php endif; ?>
                                    <?php else : ?>
                                        Pas de photo
                                    <?php endif; ?>
                                </td>


                                <td><?php echo htmlspecialchars($animal['habitat_name']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Aucun animal trouvé</td>
                        </tr>
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
        </div>
</body>

</html>