<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'employe'){
    header("location: ../login.php");
    exit;
}
require_once "../config.php";

if(isset($_POST['approve'])){
    $id = $_POST['review_id'];
    $sql = "UPDATE reviews SET approved = 1 WHERE id = ?";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

$sql = "SELECT * FROM reviews WHERE approved = 0";
$result = mysqli_query($conn, $sql);
$reviews = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Valider les avis</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
    <div class="container">
        <h1>Valider les avis</h1>
        <a href="dashboard.php" class="btn btn-primary">Retour au tableau de bord</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pseudo</th>
                    <th>Avis</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($reviews as $review): ?>
                <tr>
                    <td><?= $review['id'] ?></td>
                    <td><?= $review['pseudo'] ?></td>
                    <td><?= $review['avis'] ?></td>
                    <td>
                        <form action="manage_reviews.php" method="post">
                            <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                            <button type="submit" name="approve" class="btn btn-success">Approuver</button>
                        </form>
                    </td>
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
