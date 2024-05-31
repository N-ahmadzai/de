<?php
// Connexion à la base de données
require_once('../config/db_connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Charger l'autoloader de Composer
require_once '../../vendor/autoload.php'; 


// Définir l'en-tête de la réponse en JSON
header('Content-Type: application/json');

// Initialiser la réponse
$response = array('status' => 'error', 'message' => 'Une erreur est survenue.');

// Vérifier la méthode de la requête
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire et les nettoyer
    $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']), ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');

    // Valider les données
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $response['message'] = "Tous les champs sont obligatoires.";
        echo json_encode($response);
        exit();
    }

    // Connexion à la base de données
    try {
        $pdo = getPDO(); // Utilisation de la fonction getPDO() définie dans db_connect.php
    } catch (PDOException $e) {
        $response['message'] = "La connexion à la base de données a échoué : " . $e->getMessage();
        echo json_encode($response);
        exit();
    }

    // Insérer les données dans la base de données en utilisant des requêtes préparées
    try {
        $stmt = $pdo->prepare("INSERT INTO contact_form (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        // Envoi de l'email avec PHPMailer
        $mail = new PHPMailer(true);

        // Activer le débogage SMTP (désactiver en production)
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        // $mail->Debugoutput = 'html';

        try {
            // Paramètres du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'arcadia78100@gmail.com'; // Votre adresse email Gmail
            $mail->Password = 'yguvllvoakbclikc'; // Votre mot de passe d'application Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Activer le chiffrement TLS
            $mail->Port = 587; // Port SMTP

            // Destinataires
            $mail->setFrom('arcadia78100@gmail.com', 'Zoo Arcadia');
            $mail->addAddress('n.ahmadzai@outlook.fr'); // destinataire

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "<p>Nom: $name</p><p>Email: $email</p><p>Message: $message</p>";
            $mail->AltBody = "Nom: $name\nEmail: $email\nMessage: $message";

            $mail->send();

            $response['status'] = 'success';
            $response['message'] = 'Votre message a été envoyé avec succès.';
        } catch (Exception $e) {
            $response['message'] = "Échec de l'envoi du message. Erreur : {$mail->ErrorInfo}";
        }
    } catch (PDOException $e) {
        $response['message'] = "Erreur lors de l'insertion des données : " . $e->getMessage();
    }
}

echo json_encode($response);
exit();
