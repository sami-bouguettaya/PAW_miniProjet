


<?php
require_once '../db/db.php';


/**
 * Insère une demande d'étudiant dans la base de données.
 */
function insertStudentRequest($id_etud, $filename, $filetype, $data) {
    global $conn;

    try {
        $sql = "INSERT INTO documents (id_etud, filename, filetype, status, date_de_Depot, data) 
                VALUES (?, ?, ?, 'Pending', NOW(), ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erreur lors de la préparation de la requête : " . $conn->error);
        }

        $stmt->bind_param("isss", $id_etud, $filename, $filetype, $data);

        if ($stmt->execute()) {
            return "La demande a été soumise avec succès.";
        } else {
            throw new Exception("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $stmt->close();
    }
}

/**
 * Récupère les demandes d'un étudiant.
 */
function fetchStudentRequests($id_etud) {
    global $conn;

    try {
        $sql = "SELECT filename, filetype, status, date_de_Depot 
                FROM documents WHERE id_etud = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erreur lors de la préparation de la requête : " . $conn->error);
        }

        $stmt->bind_param("i", $id_etud);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new Exception("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    } catch (Exception $e) {
        die("Erreur : " . $e->getMessage());
    } finally {
        $stmt->close();
    }
}
?>
