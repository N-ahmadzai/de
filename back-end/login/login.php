<?php
session_start();
require_once '../config/db_connect.php';

// Obtenir une connexion PDO
$pdo = getPDO();

$email = $password = $role = "";
$email_err = $password_err = $role_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["email"]))){
        $email_err = "Veuillez entrer votre email.";
    } else {
        $email = trim($_POST["email"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Veuillez entrer votre mot de passe.";
    } else {
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["role"]))){
        $role_err = "Veuillez choisir un rôle.";
    } else {
        $role = trim($_POST["role"]);
    }

    if(empty($email_err) && empty($password_err) && empty($role_err)){
        $sql = "SELECT id, email, password, role FROM users WHERE email = :email AND role = :role";
        
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":role", $role, PDO::PARAM_STR);
            
            if($stmt->execute()){
                if($stmt->rowCount() == 1){                    
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $email = $row["email"];
                        $hashed_password = $row["password"];
                        $role = $row["role"];
                        
                        if(password_verify($password, $hashed_password)){
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["role"] = $role;                            
                            
                            if($role === 'admin'){
                                header("location: ../admin/admin_dashboard.php");
                            } elseif($role === 'veterinaire'){
                                header("location: ../models/veterinaire/veterinaire_dashboard.php");
                            } elseif($role === 'employe'){
                                header("location: ../models/employer/employe_dashboard.php");
                            }
                        } else {
                            $password_err = "Le mot de passe n'est pas valide.";
                        }
                    }
                } else {
                    $email_err = "Aucun compte trouvé avec cet email et rôle.";
                }
            } else {
                echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
            }
        } else {
            echo "Erreur lors de la préparation de la requête.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Connexion</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="images/img-01.png" alt="IMG">
                </div>
                <form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <span class="login100-form-title">Member Login</span>

                    <div class="wrap-input100 validate-input <?php echo (!empty($role_err)) ? 'has-error' : ''; ?>">
                        <select class="input100" name="role" required>
                            <option value="">Choisir un rôle</option>
                            <option value="admin">Admin</option>
                            <option value="veterinaire">Vétérinaire</option>
                            <option value="employe">Employé</option>
                        </select>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <span class="help-block"><?php echo $role_err; ?></span>
                    </div>

                    <div class="wrap-input100 validate-input <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <input class="input100" type="text" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <span class="help-block"><?php echo $email_err; ?></span>
                    </div>

                    <div class="wrap-input100 validate-input <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <input class="input100" type="password" name="password" placeholder="Password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100"><i class="fa fa-lock" aria-hidden="true"></i></span>
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">Login</button>
                    </div>

                    <div class="text-center p-t-12">
                        <span class="txt1">Forgot</span>
                        <a class="txt2" href="#">Username / Password?</a>
                    </div>
                    <div class="mb-5 pb-5"></div>
                    <div class="text-center p-t-12">
                        <a class="txt2" href="../../index.php">Retour vers le site</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({ scale: 1.1 })
    </script>
    <script src="js/main.js"></script>
</body>
</html>
