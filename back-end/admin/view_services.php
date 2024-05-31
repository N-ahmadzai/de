<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les services</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assurez-vous d'avoir un fichier CSS -->
</head>
<body>
    <h1>Gérer les services</h1>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="success-message">
            <?php echo htmlspecialchars($_SESSION['success_message']); ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($_SESSION['error_message']); ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Formulaire pour créer un nouveau service -->
    <h2>Créer un nouveau service</h2>
    <form method="POST" action="manage_services.php">
        <input type="hidden" name="action" value="create">
        <label for="name">Nom du service:</label>
        <input type="text" id="name" name="name" required>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <button type="submit">Créer</button>
    </form>

    <!-- Liste des services existants avec options de mise à jour et suppression -->
    <h2>Services existants</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?php echo htmlspecialchars($service['id']); ?></td>
                    <td><?php echo htmlspecialchars($service['name']); ?></td>
                    <td><?php echo htmlspecialchars($service['description']); ?></td>
                    <td>
                        <!-- Formulaire de mise à jour -->
                        <form method="POST" action="manage_services.php" style="display:inline;">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="service_id" value="<?php echo htmlspecialchars($service['id']); ?>">
                            <input type="text" name="name" value="<?php echo htmlspecialchars($service['name']); ?>" required>
                            <textarea name="description" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                            <button type="submit">Mettre à jour</button>
                        </form>

                        <!-- Formulaire de suppression -->
                        <form method="POST" action="manage_services.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="service_id" value="<?php echo htmlspecialchars($service['id']); ?>">
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
