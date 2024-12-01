<?php
require_once '../db/db.php';

/**
 * Insère une demande d'étudiant dans la base de données.
 */
function insertStudentRequest($id_etud, $filename, $filetype, $filepath) {
    global $conn;

    try {
        $sql = "INSERT INTO documents (id_etud, filename, filetype, status, date_de_Depot, filepath)
                VALUES (?, ?, ?, 'Pending', CURDATE(), ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erreur lors de la préparation de la requête : " . $conn->error);
        }

        $stmt->bind_param("isss", $id_etud, $filename, $filetype, $filepath);

        if ($stmt->execute()) {
            return "Demande soumise avec succès.";
        } else {
            throw new Exception("Erreur lors de l'insertion : " . $stmt->error);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return "Une erreur est survenue. Veuillez réessayer.";
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
        $sql = "SELECT filename, filetype, status, date_de_Depot FROM documents WHERE id_etud = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erreur lors de la préparation de la requête : " . $conn->error);
        }

        $stmt->bind_param("i", $id_etud);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new Exception("Erreur lors de l'exécution : " . $stmt->error);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    } finally {
        $stmt->close();
    }
}
?>
