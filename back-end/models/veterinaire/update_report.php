<?php
require_once('../../config/db_connect.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $report_id = $_POST['report_id'];
    $animal_id = $_POST['animal_id'];
    $status = $_POST['status'];
    $food = $_POST['food'];
    $food_weight = $_POST['food_weight'];
    $visit_date = $_POST['visit_date'];
    $details = isset($_POST['details']) ? $_POST['details'] : '';

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("UPDATE vet_reports SET animal_id = ?, animal_status = ?, animal_food = ?, animal_food_weight = ?, visit_date = ?, details = ? WHERE id = ?");
        $stmt->execute([$animal_id, $status, $food, $food_weight, $visit_date, $details, $report_id]);

        $_SESSION['success_message'] = "Rapport mis à jour avec succès.";
        header("Location: veterinaire_dashboard.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
        header("Location: veterinaire_dashboard.php");
        exit();
    }
} else {
    if (isset($_GET['id'])) {
        $report_id = $_GET['id'];

        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("SELECT * FROM vet_reports WHERE id = ?");
            $stmt->execute([$report_id]);
            $report = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
            header("Location: veterinaire_dashboard.php");
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
    <title>Mettre à jour le rapport vétérinaire</title>
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
            <li>
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
                    <h2>Mettre à jour le rapport vétérinaire</h2>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h4>Modifier le rapport vétérinaire</h4>
                        <i class='bx bx-filter'></i>
                    </div>
                    <form action="update_report.php" method="POST">
                        <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($report['id']); ?>">
                        <div class="mb-1">
                            <label for="animal_id" class="form-label">Animal ID:</label>
                            <input type="number" class="form-control" id="animal_id" name="animal_id" value="<?php echo htmlspecialchars($report['animal_id']); ?>" required>
                        </div>

                        <div class="mb-1">
                            <label for="status" class="form-label">État de l'animal:</label>
                            <input type="text" class="form-control" id="status" name="status" value="<?php echo htmlspecialchars($report['animal_status']); ?>" required>
                        </div>

                        <div class="mb-1">
                            <label for="food" class="form-label">Nourriture proposée:</label>
                            <input type="text" class="form-control" id="food" name="food" value="<?php echo htmlspecialchars($report['animal_food']); ?>" required>
                        </div>

                        <div class="mb-1">
                            <label for="food
                            _weight" class="form-label">Grammage de la nourriture:</label>
                            <input type="number" class="form-control" id="food_weight" name="food_weight" value="<?php echo htmlspecialchars($report['animal_food_weight']); ?>" required>
                        </div>

                        <div class="mb-1">
                            <label for="visit_date" class="form-label">Date de passage:</label>
                            <input type="date" class="form-control" id="visit_date" name="visit_date" value="<?php echo htmlspecialchars($report['visit_date']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="details" class="form-label">Détail de l'état de l'animal (facultatif):</label>
                            <textarea class="form-control" id="details" name="details" rows="2"><?php echo htmlspecialchars($report['details']); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-success submit">Mettre à jour le rapport</button>
                    </form>
                </div>
            </div>
        </main>
        <!-- PRINCIPAL -->
    </section>
    <!-- CONTENU -->

</body>

</html>