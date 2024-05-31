<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'veterinaire'){
    header("location: ../login.php");
    exit;
}
require_once "../config.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_comment'])){
    $habitat_id = $_POST['habitat_id'];
    $veterinarian_id = $_SESSION['id'];
    $comment = $_POST['comment'];
    $comment_time = $_POST['comment_time'];

    $sql = "INSERT INTO habitat_comments (habitat_id, veterinarian_id, comment, comment_time) VALUES (?, ?, ?, ?)";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "iiss", $habitat_id, $veterinarian_id, $comment, $comment_time);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

$sql = "SELECT id, name FROM habitats";
$result = mysqli_query($conn, $sql);
$habitats = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Commentaires sur les habitats</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
    <div class="container">
        <h1>Commentaires sur les habitats</h1>
        <a href="dashboard.php" class="btn btn-primary">Retour au tableau de bord</a>
        <h2>Ajouter un commentaire</h2>
        <form action="manage_comments.php" method="post">
            <div class="form-group">
                <label>Habitat</label>
                <select name="habitat_id" class="form-control" required>
                    <?php foreach($habitats as $habitat): ?>
                    <option value="<?= $habitat['id'] ?>"><?= $habitat['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Commentaire</label>
                <textarea name="comment" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Date et heure</label>
                <input type="datetime-local" name="comment_time" class="form-control" required>
            </div>
            <button type="submit" name="add_comment" class="btn btn-success">Ajouter</button>
        </form>
    </div>
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../vendor/bootstrap/js/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
