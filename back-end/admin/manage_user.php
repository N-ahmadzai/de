<?php
session_start();
require_once('../config/db_connect.php');
require_once('delete_user.php');

$email = $password = $role = $name = $vet_specialty = $employee_department = "";

// Vérification si la méthode de la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $name = $_POST['name'];
    $vet_specialty = isset($_POST['vet_specialty']) ? $_POST['vet_specialty'] : null;
    $employee_department = isset($_POST['employee_department']) ? $_POST['employee_department'] : null;

    // Liste des rôles autorisés
    $allowed_roles = ['employe', 'veterinaire'];

    // Vérifiez si l'email est valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Erreur : L'adresse email n'est pas valide.";
    } elseif (!in_array($role, $allowed_roles)) {
        $error_message = 'Erreur : Vous n\'êtes pas autorisé à créer cet utilisateur.';
    } else {
        try {
            // Obtenir une connexion PDO
            $pdo = getPDO();

            // Vérifier si l'email existe déjà
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $email_exists = $stmt->fetchColumn();

            if ($email_exists) {
                $error_message = "Erreur : Un compte avec cet email existe déjà.";
            } else {
                // Valider le mot de passe
                if (strlen($password) < 8) {
                    $error_message = "Le mot de passe doit contenir au moins 8 caractères.";
                } elseif (!preg_match('/[A-Z]/', $password)) {
                    $error_message = "Le mot de passe doit contenir au moins une lettre majuscule.";
                } elseif (!preg_match('/[a-z]/', $password)) {
                    $error_message = "Le mot de passe doit contenir au moins une lettre minuscule.";
                } elseif (!preg_match('/[0-9]/', $password)) {
                    $error_message = "Le mot de passe doit contenir au moins un chiffre.";
                } else {
                    // Hacher le mot de passe avant de le stocker
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                    // Préparer une instruction SQL pour éviter les injections SQL
                    $stmt = $pdo->prepare("INSERT INTO users (email, password, role, name, vet_specialty, employee_department) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$email, $hashed_password, $role, $name, $vet_specialty, $employee_department]);

                    $success_message = "Un nouveau membre créé avec succès.";
                    // Réinitialiser les valeurs des champs après succès
                    $email = $password = $role = $name = $vet_specialty = $employee_department = "";
                }
            }
        } catch (PDOException $e) {
            $error_message = "Erreur : " . $e->getMessage();
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
    <title>Créer un membre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="container-fluid">
        <!-- SIDEBAR -->
        <section id="sidebar">
            <a href="admin_dashboard.php" class="brand">
                <i class='bx bxs-smile'></i>
                <span class="text">Arcadia</span>
            </a>
            <ul class="side-menu top">
                <li>
                    <a href="admin_dashboard.php">
                        <i class='bx bxs-dashboard'></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="manage_user.php">
                        <i class='bx bxs-user-account'></i>
                        <span class="text">Membres</span>
                    </a>
                </li>
                <li>
                    <a href="manage_services.php">
                        <i class='bx bxs-doughnut-chart'></i>
                        <span class="text">Services</span>
                    </a>
                </li>
                <li>
                    <a href="manage_horaires.php">
                        <i class='bx bxs-hourglass'></i>
                        <span class="text">Horaires</span>
                    </a>
                </li>
                <li>
                    <a href="manage_habitats.php">
                        <i class='bx bxs-home-smile'></i>
                        <span class="text">Habitats</span>
                    </a>
                </li>
                <li>
                    <a href="manage_animals.php">
                        <i class='bx bxl-baidu'></i>
                        <span class="text">Animaux</span>
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
                    <a href="../login/logout.php" class="logout">
                        <i class='bx bxs-log-out-circle'></i>
                        <span class="text">Déconnexion</span>
                    </a>
                </li>
            </ul>
        </section>
        <!-- SIDEBAR -->

        <!-- CONTENU -->
        <section id="content">
            <main>
                <div class="head-title">
                    <div class="left">
                        <h1>Gérer les membres</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a class="active" href="admin_dashboard.php">Tableau de bord</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="manage_user.php">Membres</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <a href="manage_user.php">
                                <h3>Créer un nouveau membre</h3>
                            </a>
                        </div>
                        <!-- Formulaire de création d'utilisateur -->
                        <form method="POST" action="" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Rôle :</label>
                                <select class="form-select" name="role" aria-label="Default select example" required>
                                    <option value="">Choisir un rôle</option>
                                    <option value="employe" <?php echo $role === 'employe' ? 'selected' : ''; ?>>Employé</option>
                                    <option value="veterinaire" <?php echo $role === 'veterinaire' ? 'selected' : ''; ?>>Vétérinaire</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom :</label>
                                <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($name); ?>">
                            </div>
                            <div class="mb-3" id="vet_specialty_div" style="display: none;">
                                <label for="vet_specialty" class="form-label">Spécialité Vétérinaire :</label>
                                <input type="text" name="vet_specialty" class="form-control" value="<?php echo htmlspecialchars($vet_specialty); ?>">
                            </div>
                            <div class="mb-3" id="employee_department_div" style="display: none;">
                                <label for="employee_department" class="form-label">Département Employé :</label>
                                <input type="text" name="employee_department" class="form-control" value="<?php echo htmlspecialchars($employee_department); ?>">
                            </div>
                            <button class="btn btn-success submit mb-3" type="submit">Créer</button>
                        </form>
                        <!-- Afficher les messages d'erreur ou de succès -->
                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($success_message)) : ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="todo">
                        <ul class="todo-list">
                            <li class="completed">
                                <h3>Liste des membres</h3>
                                <i class='bx bx-list-ul'></i>
                            </li>
                        </ul>
                        <!-- Inclure la page afficher les membres -->
                        <?php include_once('view_user.php'); ?>
                    </div>
                </div>
            </main>
        </section>
        <!-- CONTENU -->
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.querySelector('select[name="role"]');
            const vetSpecialtyDiv = document.getElementById('vet_specialty_div');
            const employeeDepartmentDiv = document.getElementById('employee_department_div');

            function toggleSpecialFields() {
                if (roleSelect.value === 'veterinaire') {
                    vetSpecialtyDiv.style.display = 'block';
                    employeeDepartmentDiv.style.display = 'none';
                } else if (roleSelect.value === 'employe') {
                    vetSpecialtyDiv.style.display = 'none';
                    employeeDepartmentDiv.style.display = 'block';
                } else {
                    vetSpecialtyDiv.style.display = 'none';
                    employeeDepartmentDiv.style.display = 'none';
                }
            }

            roleSelect.addEventListener('change', toggleSpecialFields);
            toggleSpecialFields();
        });
    </script>
</body>
</html>
