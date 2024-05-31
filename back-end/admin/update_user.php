<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Mise à jour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <?php
    require_once('../config/db_connect.php');
    // Pages de mise à jour
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = $_POST['email'];
                $role = $_POST['role'];
                $name = $_POST['name'];

                $stmt = $pdo->prepare("UPDATE users SET email = ?, role = ?, name = ? WHERE id = ?");
                if ($stmt->execute([$email, $role, $name, $id])) {
                    $success_message = "membre mis à jour avec succès.";
                } else {
                    $error_message = "Erreur lors de la mise à jour.";
                }
            }
        } catch (PDOException $e) {
            $error_message = "Erreur : " . $e->getMessage();
        }
    } else {
        header("Location: create_user.php");
        exit;
    }


    // Récupérer la liste des utilisateurs
    try {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_message = "Erreur : " . $e->getMessage();
    }
    ?>
    <div class="container-fluid">
        <!-- SIDEBAR -->
        <section id="sidebar">
            <a href="#" class="brand">
                <i class='bx bxs-smile'></i>
                <span class="text">AdminHub</span>
            </a>
            <ul class="side-menu top">
                <li>
                    <a href="admin_dashboard.php">
                        <i class='bx bxs-dashboard'></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="create_user.php">
                        <i class='bx bxs-shopping-bag-alt'></i>
                        <span class="text">Membre</span>
                    </a>
                </li>
                <li class="active">
                    <a href="#">
                        <i class='bx bxs-doughnut-chart'></i>
                        <span class="text">Mise a jour d'un membre</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class='bx bxs-message-dots'></i>
                        <span class="text">Message</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class='bx bxs-group'></i>
                        <span class="text">Team</span>
                    </a>
                </li>
            </ul>
            <ul class="side-menu">
                <li>
                    <a href="#">
                        <i class='bx bxs-cog'></i>
                        <span class="text">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="logout">
                        <i class='bx bxs-log-out-circle'></i>
                        <span class="text">Logout</span>
                    </a>
                </li>
            </ul>
        </section>
        <!-- SIDEBAR -->

        <!-- CONTENU -->
        <section id="content">
            <main>
                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <a href="create_user.php">
                                <h3>Créer un nouveau membre</h3>
                            </a>
                        </div>
                        <!-- Formulaire de création d'utilisateur -->
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <select class="form-select" name="role" aria-label="Default select example" required>
                                <option value="">Choisir un rôle</option>
                                <option value="employe" <?php echo $user['role'] === 'employee' ? 'selected' : ''; ?>>Employé</option>
                                <option value="veterinaire" <?php echo $user['role'] === 'veterinarian' ? 'selected' : ''; ?>>Vétérinaire</option>
                            </select>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom :</label>
                                <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($user['name']); ?>">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success submit" type="submit">Mettre à jour</button>
                            </div>
                        </form>
                        <!-- Afficher les messages d'erreur ou de succès -->
                        <?php if (!empty($error_message)) : ?>
                            <div type="button" class="error-message btn btn-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>

                        <?php if (!empty($success_message)) : ?>
                            <div type="button" class="success-message btn btn-success"><?php echo $success_message; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="todo">

                    </div>
            </main>
        </section>
        <!-- CONTENU -->
    </div>
    <script src="js/script.js"></script>
</body>

</html>