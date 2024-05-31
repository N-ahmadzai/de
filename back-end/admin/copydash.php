<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Tableau de bord Admin</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php" class="d-flex align-items-center justify-content-center">
            <span class="d-none d-md-inline">Tableau de bord</span>
            <i class="fa fa-home"></i>
        </a>
        <!-- Ajoutez d'autres liens de la barre latérale ici -->
        <a href="../login/logout.php" class="btn btn-danger mt-3">Déconnexion</a>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <nav class="navbar navbar-light">
            <span class="navbar-brand mb-0 h1">Tableau de bord Admin</span>
        </nav>
        
        <div class="container mt-4">
            <h2 class="mb-4">Statistiques</h2>
            <div class="card p-3">
                <p class="mb-3">Nombre de consultations par animal :</p>
                <?php
                $pdo = getPDO();
                $query = "SELECT animal_id, COUNT(*) AS consultations FROM veterinary_reports GROUP BY animal_id";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                echo "<table class='table table-bordered'>";
                echo "<tr><th>ID de l'animal</th><th>Nombre de consultations</th></tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['animal_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['consultations']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                ?>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
