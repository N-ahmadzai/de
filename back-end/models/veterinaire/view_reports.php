<?php
require_once('../../config/db_connect.php');

// Récupérer tous les rapports vétérinaires depuis la base de données
try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM vet_reports");
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Erreur : " . $e->getMessage();
}

// Recherche
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Filtrer les rapports en fonction de la recherche
if ($search_query !== '') {
    $filtered_reports = array_filter($reports, function ($report) use ($search_query) {
        return stripos($report['animal_status'], $search_query) !== false || stripos($report['animal_food'], $search_query) !== false;
    });
} else {
    $filtered_reports = $reports;
}

// Nombre de rapports par page
$reports_per_page = 7;

// Total des rapports après filtrage
$total_filtered_reports = count($filtered_reports);

// Calcul du nombre de pages
$total_pages = ceil($total_filtered_reports / $reports_per_page);

// Page actuelle
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Assurez-vous que la page actuelle est dans les limites
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages) {
    $current_page = $total_pages;
}

// Limite inférieure pour la requête SQL ou array_slice
$start_index = ($current_page - 1) * $reports_per_page;

// Rapports à afficher sur la page actuelle
$current_page_reports = array_slice($filtered_reports, $start_index, $reports_per_page);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Tableau de bord des rapports vétérinaires</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../admin/css/veterinaire.css">
</head>

<body>
<!-- Formulaire de recherche -->
 <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Rechercher par statut ou nourriture" value="<?php echo htmlspecialchars($search_query); ?>" class="form-control">
        <button type="submit" class="btn btn-primary"><i class='bx bx-search'></i> Rechercher</button>
    </form>

    <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">ID de l'animal</th>
                    <th scope="col">État de l'animal</th>
                    <th scope="col">Nourriture</th>
                    <th scope="col">Grammage de la nourriture</th>
                    <th scope="col">Date de passage</th>
                    <th scope="col">Détails</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($current_page_reports as $report) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['id']); ?></td>
                        <td><?php echo htmlspecialchars($report['animal_id']); ?></td>
                        <td><?php echo htmlspecialchars($report['animal_status']); ?></td>
                        <td><?php echo htmlspecialchars($report['animal_food']); ?></td>
                        <td><?php echo htmlspecialchars($report['animal_food_weight']); ?></td>
                        <td><?php echo htmlspecialchars($report['visit_date']); ?></td>
                        <td><?php echo htmlspecialchars($report['details']); ?></td>
                        <td class="actions">
                            <a href="update_report.php?id=<?php echo $report['id']; ?>"><i class='bx bx-edit'></i></a>
                            <a href="delete_report.php?id=<?php echo $report['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rapport ?');"><i class='bx bxs-trash'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <!-- Pagination -->
    <div class="pagination">
            <?php if ($current_page > 1) : ?>
                <a href="?page=<?php echo $current_page - 1; ?>&search=<?php echo urlencode($search_query); ?>" class="btn btn-secondary">&laquo; Précédent</a>
            <?php endif; ?>

            <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                <a href="?page=<?php echo $page; ?>&search=<?php echo urlencode($search_query); ?>" class="btn btn-secondary <?php if ($page == $current_page) echo 'active'; ?>">
                    <?php echo $page; ?>
                </a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages) : ?>
                <a href="?page=<?php echo $current_page + 1; ?>&search=<?php echo urlencode($search_query); ?>" class="btn btn-secondary">Suivant &raquo;</a>
            <?php endif; ?>
        </div>

          <!-- Affichage des messages -->
          <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
            <div class="alert alert-success mt-3">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
            <div class="alert alert-danger mt-3">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
</body>

</html>