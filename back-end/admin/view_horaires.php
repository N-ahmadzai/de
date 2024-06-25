<?php
require_once('../config/db_connect.php');
$pdo = getPDO();

$horaires = $pdo->query("SELECT * FROM horaires")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Afficher les horaires</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/horaire.css">
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

        <table  class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jour de la semaine</th>
                    <th>Heure d'ouverture</th>
                    <th>Heure de fermeture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horaires as $horaire) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($horaire['id']); ?></td>
                        <td><?php echo htmlspecialchars($horaire['jour_semaine']); ?></td>
                        <td><?php echo htmlspecialchars($horaire['heure_ouverture']); ?></td>
                        <td><?php echo htmlspecialchars($horaire['heure_fermeture']); ?></td>
                        <td>
                            <a  href="update_horaires.php?id=<?php echo $horaire['id']; ?>"><i class='bx bx-edit' style='color: #2EB872;'></i></a>
                            <a  href="manage_horaires.php?id=<?php echo $horaire['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet horaire ?');"><i class='bx bxs-trash' style='color: #2EB872;'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>