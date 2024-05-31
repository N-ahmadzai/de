<?php
require_once('auth.php');
header("location: dashboard.php");
exit;



// index.php redirige vers admin_dashboard.php.
// auth.php vérifie si l'utilisateur est connecté et s'il a le rôle d'administrateur.
// db_connect.php contient la configuration de la base de données et la fonction pour se connecter avec PDO.