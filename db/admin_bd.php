<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "sami12345"; // Replace with your database password
$dbname = "paw";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch submissions from the database
function fetchSubmissions()
{
    global $conn;
    $sql = "
        SELECT 
            e.name, 
            e.last_name, 
            d.filename, 
            d.filetype, 
            d.status, 
            d.date_de_Depot, 
            d.id_etud
        FROM documents d
        INNER JOIN etudiant e ON d.id_etud = e.matricule";

    $result = $conn->query($sql);

    // Check if the query failed
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    return $result;
}
?>

