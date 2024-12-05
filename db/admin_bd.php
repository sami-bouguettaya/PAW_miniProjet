<?php

include("db.php");

function fetchSubmissions($sort = 'name')
{
    global $conn;


    $filterName = $_GET['filter_name'] ?? '';
    $filterStatus = $_GET['filter_status'] ?? '';

   
    $sql = "
        SELECT 
            e.name, 
            e.last_name, 
            d.filename, 
            d.filetype, 
            d.status, 
            d.date, 
            d.id_file, 
            d.id_etud
        FROM documents d
        INNER JOIN etudiant e ON d.id_etud = e.matricule
        WHERE 1
    ";

  
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

    // Ajout du tri
    if ($sort === 'date') {
        $sql .= " ORDER BY d.date DESC"; // Tri par date 
    } else {
        $sql .= " ORDER BY e.name ASC, e.last_name ASC"; // Tri par ordre alphabétique
    }

   
    $stmt = $conn->prepare($sql);
    if ($params) {
        $types = str_repeat('s', count($params)); 
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}



?>

