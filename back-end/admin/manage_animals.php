<?php
include 'db.php';

function createAnimal($name, $species, $habitat_id, $image_url) {
    global $conn;
    $sql = "INSERT INTO animals (name, species, habitat_id, image_url) VALUES ('$name', '$species', $habitat_id, '$image_url')";

    if ($conn->query($sql) === TRUE) {
        echo "New animal created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function updateAnimal($id, $name, $species, $habitat_id, $image_url) {
    global $conn;
    $sql = "UPDATE animals SET name='$name', species='$species', habitat_id=$habitat_id, image_url='$image_url' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Animal updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function deleteAnimal($id) {
    global $conn;
    $sql = "DELETE FROM animals WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Animal deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Example usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $id = $_POST['id'];
    $name = $_POST['name'];
    $species = $_POST['species'];
    $habitat_id = $_POST['habitat_id'];
    $image_url = $_POST['image_url'];

    if ($action == 'create') {
        createAnimal($name, $species, $habitat_id, $image_url);
    } elseif ($action == 'update') {
        updateAnimal($id, $name, $species, $habitat_id, $image_url);
    } elseif ($action == 'delete') {
        deleteAnimal($id);
    }
}
?>
