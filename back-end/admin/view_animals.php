<?php
require_once('../config/db_connect.php');

// Nombre d'animaux par page
$animals_per_page = 8;

// Récupérer le nombre total d'animaux
try {
    $pdo = getPDO();

    // Si une recherche est effectuée
    if (isset($_GET['q'])) {
        $searchQuery = $_GET['q'];
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM animals WHERE name LIKE :search OR race LIKE :search");
        $stmt->bindValue(':search', '%' . $searchQuery . '%', PDO::PARAM_STR);
    } else {
        $stmt = $pdo->query("SELECT COUNT(*) FROM animals");
    }

    $total_animals = $stmt->fetchColumn();
} catch (PDOException $e) {
    $error_message = "Erreur : " . $e->getMessage();
}

// Calculer le nombre total de pages
$total_pages = ceil($total_animals / $animals_per_page);

// Déterminer la page actuelle
$current_page = isset($_GET['page']) ? max(1, min((int)$_GET['page'], $total_pages)) : 1;

// Calculer l'index de départ pour l'extraction des animaux sur la page actuelle
$start_index = ($current_page - 1) * $animals_per_page;

try {
    $pdo = getPDO();

    // Requête SQL pour récupérer les animaux avec pagination et recherche si applicable
    if (isset($_GET['q'])) {
        $searchQuery = $_GET['q'];
        $stmt = $pdo->prepare("SELECT a.id, a.name, a.race, a.image_url, h.name as habitat_name 
                               FROM animals a 
                               JOIN habitats h ON a.habitat_id = h.id 
                               WHERE a.name LIKE :search OR a.race LIKE :search 
                               LIMIT :start_index, :animals_per_page");
        $stmt->bindValue(':search', '%' . $searchQuery . '%', PDO::PARAM_STR);
    } else {
        $stmt = $pdo->prepare("SELECT a.id, a.name, a.race, a.image_url, h.name as habitat_name 
                               FROM animals a 
                               JOIN habitats h ON a.habitat_id = h.id 
                               LIMIT :start_index, :animals_per_page");
    }
    $stmt->bindValue(':start_index', $start_index, PDO::PARAM_INT);
    $stmt->bindValue(':animals_per_page', $animals_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Afficher les animaux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/service.css">
    <style>
        .pagination .page-item a {
            color: #2EB872;
        }

        .pagination .page-item.active a {
            background-color: #2EB872;
            border-color: #2EB872;
        }
    </style>
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

        <!-- Formulaire de recherche -->
        <form class="d-flex mb-3" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <input class="form-control me-2" type="search" placeholder="Rechercher par nom ou race..." aria-label="Rechercher" name="q" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
            <button class="btn btn-outline-success submit" type="submit" style="color:white;">Rechercher</button>
        </form>

        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Race</th>
                    <th>Image</th>
                    <th>Habitat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($animals as $animal) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($animal['id']); ?></td>
                        <td><?php echo htmlspecialchars($animal['name']); ?></td>
                        <td><?php echo htmlspecialchars($animal['race']); ?></td>
                        <td>
                            <?php if (!empty($animal['image_url'])) : ?>
                                <img src="<?php echo htmlspecialchars($animal['image_url']); ?>" alt="Image de l'animal" width="50">
                            <?php else : ?>
                                Pas de photo
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($animal['habitat_name']); ?></td>
                        <td>
                            <a href="update_animal.php?id=<?php echo $animal['id']; ?>"><i class='bx bx-edit' style='color: #2EB872;'></i></a>
                            <a href="delete_animal.php?id=<?php echo $animal['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ?');"><i class='bx bxs-trash' style='color: #2EB872;'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Liens de pagination -->
        <nav aria-label="Pagination">
            <ul class="pagination justify-content-center">
                <?php if ($current_page > 1) : ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page - 1; ?><?php echo isset($_GET['q']) ? '&q=' . htmlspecialchars($_GET['q']) : ''; ?>">Précédent</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?><?php echo isset($_GET['q']) ? '&q=' . htmlspecialchars($_GET['q']) : ''; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages) : ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page + 1; ?><?php echo isset($_GET['q']) ? '&q=' . htmlspecialchars($_GET['q']) : ''; ?>">Suivant</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

</body>

</html>
