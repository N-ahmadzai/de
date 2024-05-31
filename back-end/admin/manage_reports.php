<?php
require_once('../config/db_connect.php');
session_start();

$search_animal = $_GET['search_animal'] ?? '';
$search_date = $_GET['search_date'] ?? '';

try {
    $pdo = getPDO();
    $query = "SELECT * FROM reports WHERE 1=1";
    if ($search_animal) {
        $query .= " AND animal_name LIKE ?";
        $params[] = "%$search_animal%";
    }
    if ($search_date) {
        $query .= " AND report_date = ?";
        $params[] = $search_date;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params ?? []);
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Voir les rapports</title>
</head>
<body>
    <form method="GET" action="view_reports.php">
        <input type="text" name="search_animal" placeholder="Rechercher par animal" value="<?php echo htmlspecialchars($search_animal); ?>">
        <input type="date" name="search_date" value="<?php echo htmlspecialchars($search_date); ?>">
        <button type="submit">Filtrer</button>
    </form>

    <!-- Affichage des rapports -->
</body>
</html>
