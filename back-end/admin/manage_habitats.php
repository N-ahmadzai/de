<?php
include 'db.php';

function createHabitat($name, $description) {
    global $conn;
    $sql = "INSERT INTO habitats (name, description) VALUES ('$name', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "New habitat created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function updateHabitat($id, $name, $description) {
    global $conn;
    $sql = "UPDATE habitats SET name='$name', description='$description' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Habitat updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function deleteHabitat($id) {
    global $conn;
    $sql = "DELETE FROM habitats WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Habitat deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Example usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    if ($action == 'create') {
        createHabitat($name, $description);
    } elseif ($action == 'update') {
        updateHabitat($id, $name, $description);
    } elseif ($action == 'delete') {
        deleteHabitat($id);
    }
}
?>
