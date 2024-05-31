<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'employe'){
    header("location: ../login.php");
    exit;
}
require_once "../config.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_feeding'])){
    $animal_id = $_POST['animal_id'];
    $employee_id = $_SESSION['id'];
    $food = $_POST['food'];
    $quantity = $_POST['quantity'];
    $feeding_time = $_POST['feeding_time'];

    $sql = "INSERT INTO feedings (animal_id, employee_id, food, quantity, feeding_time) VALUES (?, ?, ?, ?, ?)";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "iisss", $animal_id, $employee_id, $food, $quantity, $feeding_time);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

$sql = "SELECT id, name FROM animals";
$result = mysqli_query($conn, $sql);
$animals = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gestion des nourritures</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
    <div class="container">
        <h1>Gestion des nourritures</h1>
        <a href="dashboard.php" class="btn btn-primary">Retour au tableau de bord</a>
        <h2>Ajouter une nourriture</h2>
        <form action="manage_feedings.php" method="post">
            <div class="form-group">
                <label>Animal</label>
                <select name="animal_id" class="form-control" required>
                    <?php foreach($animals as $animal): ?>
                    <option value="<?= $animal['id'] ?>"><?= $animal['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nourriture</label>
                <input type="text" name="food" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Quantité</label>
                <input type="text" name="quantity" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Date et heure</label>
                <input type="datetime-local" name="feeding_time" class="form-control" required>
            </div>
            <button type="submit" name="add_feeding" class="btn btn-success">Ajouter</button>
        </form>
    </div>
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../vendor/bootstrap/js/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
