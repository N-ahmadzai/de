<?php
// Inclure le fichier de configuration externe
require_once('config.php');
function getPDO()
{
    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

        // Définir le mode d'erreur PDO sur Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        // En cas d'erreur lors de la connexion, afficher l'erreur
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
