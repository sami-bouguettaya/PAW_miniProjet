<?php
include '../db/admin_bd.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate the input
    if (isset($_POST['id_file'], $_POST['status'])) {
        $id_file = intval($_POST['id_file']); // Assurez-vous que c'est un entier
        $status = $conn->real_escape_string($_POST['status']); // Protection contre l'injection SQL
    
        $sql = "UPDATE documents SET status = ? WHERE id_file = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("si", $status, $id_file);
    
            if ($stmt->execute()) {
                header("Location: ../pages/admin.php");
                exit;
            } else {
                echo "Erreur lors de la mise à jour : " . $stmt->error;
            }
    
            $stmt->close();
        } else {
            echo "Erreur de préparation de la requête : " . $conn->error;
        }
    } else {
        echo "Données invalides.";
    }
    
} else {
    // Reject non-POST requests
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>




