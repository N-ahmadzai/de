<?php
require_once('../config/db_connect.php');
$pdo = getPDO();

$habitats = $pdo->query("SELECT * FROM habitats")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Afficher les Habitats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/service.css">

</head>

<body>
    <div class="container">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($habitats as $habitat) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($habitat['name']); ?></td>
                        <td><?php echo htmlspecialchars($habitat['description']); ?></td>
                        <td>
                            <?php if ($habitat['image_url']) : ?>
                                <img src="<?php echo htmlspecialchars($habitat['image_url']); ?>" alt="Image" style="width: 100px;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="update_habitat.php?id=<?php echo $habitat['id']; ?>"><i class='bx bx-edit' style='color: #2EB872;'></i></a>
                            <a href="delete_habitat.php?id=<?php echo $habitat['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet habitat?')"><i class='bx bxs-trash' style='color: #2EB872;'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>