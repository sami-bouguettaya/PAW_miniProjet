<?php
session_start();
include '../db/etudiant_bd.php';

// Check if the student is logged in
if (!isset($_SESSION['student_matricule'])) {
    header("Location: ../index.php"); // Redirect to login if not logged in
    exit;
}

// Retrieve student information
$student_name = isset($_SESSION['student_name']) ? htmlspecialchars($_SESSION['student_name']) : "Étudiant";
$student_matricule = $_SESSION['student_matricule'];

// Handle form submission to insert a new request
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filename'], $_POST['filetype'])) {
        $filename = $_POST['filename'];
        $filetype = $_POST['filetype'];

        // Call function to insert new request into database
        insertStudentRequest($student_matricule, $filename, $filetype);
    } else {
        throw new Exception("Invalid request or missing parameters.");
    }
} catch (Exception $e) {
    // Log the error and provide a user-friendly message
    error_log("Error: " . $e->getMessage());
    echo "An error occurred while processing your request. Please try again.";
}


// Fetch student requests
$requests = fetchStudentRequests($student_matricule);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/etudiant.css">
    <title>Espace Étudiant</title>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Bienvenue, <?= $student_name; ?> !</h1>
        <a href="../index.php" class="logout">Déconnexion</a>
    </div>

    <!-- Main Container -->
    <div class="container">
        <h2>Vos Demandes de Documents</h2>

        <!-- Table of Requests -->
        <table>
            <thead>
                <tr>
                    <th>Nom du Fichier</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Date de Dépôt</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($requests)) { ?>
                    <?php foreach ($requests as $request) { ?>
                        <tr>
                            <td><?= htmlspecialchars($request['filename']); ?></td>
                            <td><?= htmlspecialchars($request['filetype']); ?></td>
                            <td><?= htmlspecialchars($request['status']); ?></td>
                            <td><?= htmlspecialchars($request['date_de_Depot']); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4">Aucune demande trouvée.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Form for Submitting a New Request -->
        <div class="new-request">
            <h2>Nouvelle Demande</h2>
            <form method="POST" action="etudiant.php">
                <input type="hidden" name="student_matricule" value="<?= $_SESSION['student_matricule']; ?>" />
                <label for="request-type">Type de Demande</label>
                <select id="request-type" name="filetype" required>
                    <option value="certificate">Certificat de scolarité</option>
                    <option value="transcript">Relevé de notes</option>
                    <option value="attestation">Attestation de conduite</option>
                </select>

                <label for="filename">Nom du Fichier</label>
                <input type="text" id="filename" name="filename" placeholder="Nom du fichier demandé" required>

                <button type="submit">Soumettre la Demande</button>
            </form>
        </div>
    </div>
</body>

</html>



