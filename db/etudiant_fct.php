<?php
function insertStudentRequest($id_admin, $id_etud, $filename, $filetype, $status,  $data = null) {
    require '../db/db.php'; // Inclure le fichier de connexion à la base de données
    session_start();
    // Requête d'insertion dans la table `documents`
    $sql = "INSERT INTO documents (id_admin, filename, filetype, status,  id_etud) 
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isssi", $id_admin, $filename, $filetype, $status, $id_etud);

        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }

        $stmt->close();
    } else {
        throw new Exception("Error preparing query: " . $conn->error);
    }

    $conn->close();
}


function fetchStudentRequests($student_matricule) {
    include("db.php");

    // Prepare the SQL query to fetch the student requests
    $query = $conn->prepare("SELECT filename, filetype, status, date FROM documents WHERE id_etud = ?");
    if (!$query) {
        die("SQL query preparation failed: " . $conn->error);
    }

    // Bind the student matricule to the query (prevent SQL injection)
    $query->bind_param("i", $student_matricule);

    // Execute the query
    if (!$query->execute()) {
        die("Query execution failed: " . $query->error);
    }

    // Get the result set
    $result = $query->get_result();

    // Fetch all rows as an associative array
    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }

    // Close the query and the database connection
    $query->close();
    $conn->close();

    // Return the list of requests
    return $requests;
}
?>