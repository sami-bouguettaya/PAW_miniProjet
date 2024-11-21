<?php
// Function to fetch student requests from the database
function fetchStudentRequests($student_matricule) {
    // Database connection details
    $host = 'localhost';
    $dbname = 'paw';
    $username = 'root';
    $password = 'sami12345'; // Replace with your actual database password

    // Create a new connection to the database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query to fetch the student requests
    $query = $conn->prepare("SELECT filename, filetype, status, date_de_Depot FROM documents WHERE id_etud = ?");
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





