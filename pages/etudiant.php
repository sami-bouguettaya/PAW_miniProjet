


<?php
session_start();
require_once 'fonction_et.php';


// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['student_matricule'])) {
    header("Location: ../db/login.php");
    exit();
}

$student_matricule = $_SESSION['student_matricule'];
$student_name = $_SESSION['student_name'];

// Récupère les demandes
$requests = fetchStudentRequests($student_matricule);

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filename = $_POST['filename'];
    $filetype = $_POST['filetype'];
    $filedata = '';

    if (isset($_FILES['filedata']) && $_FILES['filedata']['error'] === UPLOAD_ERR_OK) {
        $filedata = file_get_contents($_FILES['filedata']['tmp_name']);
    } else {
        $message = "Erreur lors de l'envoi du fichier.";
    }

    if ($filedata) {
        $message = insertStudentRequest($student_matricule, $filename, $filetype, $filedata);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Space</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(to right, #e2e2e2, #c9d6ff); }
        .header { padding: 15px; background: rgba(255, 255, 255, 0.8); }
        footer { margin-top: 30px; text-align: center; color: #555; }
    </style>
</head>
<body>
    <div class="container my-4">
        <div class="header d-flex justify-content-between align-items-center">
            <h1>Bienvenue, <?= htmlspecialchars($student_name); ?> !</h1>
            <a href="../index.php" class="btn btn-danger">Déconnexion</a>
        </div>
    </div>
    <div class="container mt-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#requests">Vos demandes</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#new-request">Nouvelle demande</button>
            </li>
        </ul>
        <div class="tab-content mt-4">
            <div class="tab-pane fade show active" id="requests">
                <h2>Vos demandes</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr><th>Nom</th><th>Type</th><th>Status</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($requests)) {
                            foreach ($requests as $request) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($request['filename']); ?></td>
                                    <td><?= htmlspecialchars($request['filetype']); ?></td>
                                    <td><?= htmlspecialchars($request['status']); ?></td>
                                    <td><?= htmlspecialchars($request['date_de_Depot']); ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr><td colspan="4">Aucune demande trouvée.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="new-request">
                <h2>Soumettre une nouvelle demande</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="filetype" class="form-label">Type</label>
                        <select id="filetype" name="filetype" class="form-select" required>
                            <option value="certificate">Certificat</option>
                            <option value="transcript">Relevé de notes</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="filename" class="form-label">Nom du fichier</label>
                        <input type="text" id="filename" name="filename" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="filedata" class="form-label">Fichier</label>
                        <input type="file" id="filedata" name="filedata" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Portail étudiant</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>












