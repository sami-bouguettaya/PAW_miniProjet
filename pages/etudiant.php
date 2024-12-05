<?php
session_start();
require_once '../db/etudiant_fct.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['student_matricule'])) {
    header("Location: ../db/login.php");
}

$student_matricule = $_SESSION['student_matricule'];
$student_name = $_SESSION['student_name'];

// Récupère les demandes
$requests = fetchStudentRequests($student_matricule);
// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    $filename = $_POST['filename'];
    $filetype = $_POST['filetype'];
    $status = "Pending"; // Statut par défaut
    if (isset($_SESSION['admin_id'])) {
        $id_admin = $_SESSION['admin_id'];
    } else {
        echo "L'administrateur deconnecter ";
    }
    // Appel de la fonction d'insertion
    try {
        insertStudentRequest($id_admin, $student_matricule, $filename, $filetype, $status); // Dernier paramètre null si pas de fichier binaire
        $message = "Request submitted successfully!";
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Space</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
        }

        .header {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        footer {
        text-align: center;
        color: #555;
    }
    </style>
</head>

<body>
  
    <div class="container my-4">
        <div class="header d-flex justify-content-between align-items-center">
            <h1><i class="fas fa-user-graduate"></i> Welcome, <?= htmlspecialchars($student_name); ?>!</h1>
            <a href="../index.php" class="btn btn-danger">Log Out</a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container mt-4">
        <!-- Tabs -->
        <ul class="nav nav-tabs" id="student-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="requests-tab" data-bs-toggle="tab" data-bs-target="#requests" type="button" role="tab">
                    <i class="fas fa-folder-open"></i> Requests
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="new-request-tab" data-bs-toggle="tab" data-bs-target="#new-request" type="button" role="tab">
                    <i class="fas fa-plus-circle"></i> New Request
                </button>
            </li>
        </ul>

        <div class="tab-content mt-4" id="student-tabs-content">
            <!-- Requests Tab -->
            <div class="tab-pane fade show active" id="requests" role="tabpanel">
                <h2 class="text-center mb-4">Your Document Requests</h2>
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>File Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Submission Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($requests)) { 
                            foreach ($requests as $request) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($request['filename']); ?></td>
                                    <td><?= htmlspecialchars($request['filetype']); ?></td>
                                    <td><?= htmlspecialchars($request['status']); ?></td>
                                    <td><?= htmlspecialchars($request['date']); ?></td>
                                </tr>
                            <?php } 
                        } else { ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">No requests found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- New Request Tab -->
            <div class="tab-pane fade" id="new-request" role="tabpanel">
                <h2 class="text-center mb-3">Submit a New Request</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="filetype" class="form-label">Request Type</label>
                        <select id="filetype" name="filetype" class="form-select">
                            <option value="certificate">Certificate</option>
                            <option value="transcript">Transcript</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="filename" class="form-label">File Name</label>
                        <input type="text" id="filename" name="filename" class="form-control" required>
                    </div>
                 
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Submit Request</button>
                    </div>
                </form>
                <?php if (isset($message)) { ?>
                    <div class="alert alert-info mt-3"><?= htmlspecialchars($message); ?></div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <body class="d-flex flex-column min-vh-100">
    <div class="container flex-grow-1">
        <!-- Contenu principal ici -->
    </div>

    <footer class="mt-auto">
        <p>&copy; 2024 Student Portal. All rights reserved.</p>
    </footer>
</body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
