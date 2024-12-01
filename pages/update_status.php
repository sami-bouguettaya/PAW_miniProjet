<?php
include '../db/admin_bd.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate the input
    if (isset($_POST['id_etud'], $_POST['status'])) {
        $id_etud = intval($_POST['id_etud']); // Ensure id_etud is an integer
        $status = $conn->real_escape_string($_POST['status']); // Sanitize input to prevent SQL injection

        // Prepare the SQL statement to update the status
        $sql = "UPDATE documents SET status = ? WHERE id_etud = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute the statement
            $stmt->bind_param("si", $status, $id_etud);

            if ($stmt->execute()) {
                // Redirect back to admin panel on success
                header("Location: ../pages/admin.php");
                exit;
            } else {
                // Error handling for query execution
                echo "Error updating record: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            // Error handling for SQL preparation
            echo "Failed to prepare statement: " . $conn->error;
        }
    } else {
        // Input validation failed
        echo "Invalid input data.";
    }
} else {
    // Reject non-POST requests
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>




