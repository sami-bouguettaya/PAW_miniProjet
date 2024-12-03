<?php
// Database connection
include("db.php");
// Function to fetch submissions from the database
function fetchSubmissions()
{
    global $conn;

    // Variables de filtre
    $filterName = $_GET['filter_name'] ?? '';
    $filterStatus = $_GET['filter_status'] ?? '';

    // Construction de la requête SQL avec filtres
    $sql = "
        SELECT 
            e.name, 
            e.last_name, 
            d.filename, 
            d.filetype, 
            d.status, 
            d.date_de_Depot, 
            d.id_file, 
            d.id_etud
        FROM documents d
        INNER JOIN etudiant e ON d.id_etud = e.matricule
        WHERE 1
    ";

    // Ajout des filtres
    $params = [];
    if ($filterName) {
        $sql .= " AND (e.name LIKE ? OR e.last_name LIKE ?)";
        $params[] = '%' . $filterName . '%';
        $params[] = '%' . $filterName . '%';
    }
    if ($filterStatus) {
        $sql .= " AND d.status = ?";
        $params[] = $filterStatus;
    }

    // Préparation et exécution de la requête
    $stmt = $conn->prepare($sql);
    if ($params) {
        $types = str_repeat('s', count($params)); // Détermine les types de données
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}



?>

