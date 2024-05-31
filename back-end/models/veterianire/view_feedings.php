<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'veterinaire'){
    header("location: ../login.php");
    exit;
}
require_once "../config.php";

$sql = "SELECT feedings.*, animals.name AS animal_name, employees.email AS employee_email FROM feedings
        JOIN animals ON feedings.animal_id = animals.id
        JOIN employees ON feedings.employee_id = employees.id";
$result = mysqli_query($conn, $sql);
$feedings = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Voir les nourrissages</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
    <div class="container">
        <h1>Voir les nourrissages</h1>
        <a href="dashboard.php" class="btn btn-primary">Retour au tableau de bord</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Animal</th>
                    <th>Employé</th>
                    <th>Nourriture</th>
                    <th>Quantité</th>
                    <th>Date et heure</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($feedings as $feeding): ?>
                <tr>
                    <td><?= $feeding['id'] ?></td>
                    <td><?= $feeding['animal_name'] ?></td>
                    <td><?= $feeding['employee_email'] ?></td>
                    <td><?= $feeding['food'] ?></td>
                    <td><?= $feeding['quantity'] ?></td>
                    <td><?= $feeding['feeding_time'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../vendor/bootstrap/js/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
