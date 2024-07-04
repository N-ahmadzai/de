<?php
session_start(); // Démarrer la session pour utiliser les messages de session
require_once('../config/db_connect.php'); // Inclusion du fichier de connexion à la base de données

try {
    $pdo = getPDO(); // Connexion à la base de données
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Erreur de connexion à la base de données : " . $e->getMessage();
    header("Location: manage_habitats.php");
    exit();
}

// Vérifier si les données nécessaires sont fournies
if (isset($_POST['habitat_id']) && !empty($_POST['habitat_id']) && isset($_POST['name']) && isset($_POST['description'])) {
    $habitat_id = $_POST['habitat_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    try {
        // Mettre à jour les détails de l'habitat
        $stmt = $pdo->prepare("UPDATE habitats SET name = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $description, $habitat_id]);

        // Gérer le téléchargement de l'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_name = basename($_FILES['image']['name']);
            $upload_dir = '../uploads/habitats/';
            $image_path = $upload_dir . $image_name;

            // Créer le répertoire de téléchargement s'il n'existe pas
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Déplacer le fichier téléchargé vers le répertoire cible
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                // Vérifier si une image existe déjà pour cet habitat
                $stmt = $pdo->prepare("SELECT id FROM habitat_images WHERE habitat_id = ?");
                $stmt->execute([$habitat_id]);
                $image_record = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($image_record) {
                    // Mettre à jour l'image existante
                    $stmt = $pdo->prepare("UPDATE habitat_images SET image_url = ? WHERE habitat_id = ?");
                    $stmt->execute([$image_path, $habitat_id]);
                } else {
                    // Insérer une nouvelle image
                    $stmt = $pdo->prepare("INSERT INTO habitat_images (habitat_id, image_url) VALUES (?, ?)");
                    $stmt->execute([$habitat_id, $image_path]);
                }
            } else {
                $_SESSION['error_message'] = "Erreur lors du téléchargement de l'image.";
                header("Location: habitat_detail.php?id=$habitat_id");
                exit();
            }
        }

        $_SESSION['success_message'] = "L'habitat a été mis à jour avec succès.";
        header("Location: habitat_detail.php?id=$habitat_id");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la mise à jour de l'habitat : " . $e->getMessage();
        header("Location: habitat_detail.php?id=$habitat_id");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Données manquantes pour la mise à jour de l'habitat.";
    header("Location: manage_habitats.php");
    exit();
}
