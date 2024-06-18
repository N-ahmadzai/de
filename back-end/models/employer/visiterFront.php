<!-- Page d'accueil (pour les visiteurs) : -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
</head>
<body>
    <h1>Livre d'or</h1>
    <h2>Ajouter un commentaire</h2>
    <form action="submit_comment.php" method="POST">
        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required><br>
        <label for="avis">Avis :</label><br>
        <textarea id="avis" name="avis" rows="4" cols="50" required></textarea><br>
        <button type="submit">Soumettre</button>
    </form>
</body>
</html>
