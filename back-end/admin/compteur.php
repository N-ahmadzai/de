<!-- Mise à jour du compteur -->


Étape 1 : Création de la structure de la base de données non relationnelle
Vous pouvez utiliser une base de données NoSQL comme MongoDB pour stocker les données de consultation des habitats. Voici un exemple de structure de données :

json
Copy code
{
  "habitat": "nom de l'habitat",
  "consultations": {
    "animal_1": 10,
    "animal_2": 5,
    "animal_3": 3
  }
}










Étape 2 : Mise à jour du compteur de consultations
Lorsqu'un visiteur clique sur un animal pour consulter ses détails, vous devez mettre à jour le compteur de consultations dans la base de données. Voici comment vous pouvez le faire en utilisant MongoDB avec PHP :

php
<?php
require_once('../config/db_connect.php');
$mongo = new MongoDB\Driver\Manager("mongodb://localhost:27017");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['animal_id'])) {
    $animal_id = $_GET['animal_id'];

    // Recherche de l'habitat dans la base de données
    $filter = ['habitat' => 'nom de l\'habitat'];
    $query = new MongoDB\Driver\Query($filter);
    $habitats = $mongo->executeQuery('database.habitats', $query);

    // Mise à jour du compteur de consultations pour l'animal donné dans l'habitat
    foreach ($habitats as $habitat) {
        if (isset($habitat->consultations->$animal_id)) {
            $habitat->consultations->$animal_id += 1;
        } else {
            $habitat->consultations->$animal_id = 1;
        }

        // Mise à jour du document dans la base de données
        $bulk = new MongoDB\Driver\BulkWrite();
        $bulk->update(['_id' => $habitat->_id], ['$set' => ['consultations' => $habitat->consultations]]);
        $mongo->executeBulkWrite('database.habitats', $bulk);
    }

    // Redirection vers la page de détails de l'animal
    header("Location: animal_detail.php?id=$animal_id");
    exit();
} else {
    // Gérer les autres cas d'utilisation
}
?>



Avec ce code, chaque fois qu'un visiteur consulte les détails d'un animal, le compteur de consultations pour cet animal dans l'habitat correspondant est mis à jour dans la base de données MongoDB.

Étape 3 : Affichage des statistiques dans le tableau de bord administrateur
Pour afficher les statistiques dans le tableau de bord administrateur, vous pouvez récupérer les données de consultation depuis la base de données MongoDB et les afficher sous forme de tableau ou de graphique. Vous pouvez utiliser des bibliothèques comme Chart.js ou D3.js pour créer des graphiques interactifs.

Étape 4 : Déploiement de l'application
Une fois que vous avez implémenté toutes les fonctionnalités nécessaires, vous pouvez déployer votre application sur un serveur en ligne pour qu'elle soit accessible aux utilisateurs. Assurez-vous de configurer correctement le serveur pour prendre en charge votre application et la base de données NoSQL.





