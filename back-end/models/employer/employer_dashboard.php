<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'employe'){
    header("location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Tableau de bord Employé</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
    <div class="container">
        <h1>Tableau de bord Employé</h1>
        <a href="../administrateur/logout.php" class="btn btn-danger">Déconnexion</a>
        <div class="menu">
            <a href="manage_reviews.php" class="btn btn-primary">Valider les avis</a>
            <a href="manage_services.php" class="btn btn-primary">Modifier les services</a>
            <a href="manage_feedings.php" class="btn btn-primary">Gérer les nourritures</a>
        </div>
    </div>
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../vendor/bootstrap/js/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
