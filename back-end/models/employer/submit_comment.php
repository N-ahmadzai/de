<?php
require_once('../../config/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Filtrer et valider les entrées
    $pseudo = html_entity_decode(htmlspecialchars(trim($_POST['pseudo']), ENT_QUOTES, 'UTF-8'));
    $avis = html_entity_decode(htmlspecialchars(trim($_POST['avis']), ENT_QUOTES, 'UTF-8'));

    // Compter le nombre de mots dans l'avis
    $word_count = str_word_count($avis);

    // Vérifier que les champs ne sont pas vides et que l'avis ne dépasse pas 150 mots
    if (!empty($pseudo) && !empty($avis) && $word_count <= 150) {
        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("INSERT INTO comments (pseudo, avis) VALUES (?, ?)");
            $stmt->execute([$pseudo, $avis]);
            $success_message = "Merci pour votre avis ! Il sera soumis à validation.";
            header("Location: ../../../index.php?success=" . urlencode($success_message) . "#form");
            exit();
        } catch (PDOException $e) {
            $error_message = "Erreur : " . $e->getMessage();
            header("Location: ../../../index.php?error=" . urlencode($error_message) . "#form");
            exit();
        }
    } else {
        $error_message = "Veuillez remplir tous les champs correctement et ne pas dépasser 150 mots pour l'avis.";
        header("Location: ../../../index.php?error=" . urlencode($error_message) . "#form");
        exit();
    }
} else {
    header("Location: ../../../index.php");
    exit();
}
