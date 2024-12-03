<?php
// Database connection
include("db.php");
// Function to fetch submissions from the database
function fetchSubmissions()
{
    global $conn;
    $sql = "
        SELECT 
            e.name, 
            e.last_name, 
            d.id_file, 
            d.filename, 
            d.filetype, 
            d.status, 
            d.date_de_Depot
        FROM documents d
        INNER JOIN etudiant e ON d.id_etud = e.matricule";

    $result = $conn->query($sql);

    if (!$result) {
        die("Erreur lors de l'exécution de la requête : " . $conn->error);
    }

    return $result;
}


?>

