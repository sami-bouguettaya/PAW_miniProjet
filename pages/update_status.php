<?php
include '../db/admin_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_etud = $_POST['id_etud'];
    $status = $_POST['status'];

    $sql = "UPDATE documents SET status = ? WHERE id_etud = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id_etud);

    if ($stmt->execute()) {
        header("Location: ../pages/admin.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
$conn->close();
?>
