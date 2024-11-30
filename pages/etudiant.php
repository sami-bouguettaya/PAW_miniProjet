<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Espace Étudiant</title>
    <style>
        body {
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .header {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            backdrop-filter: blur(10px);
        }

        .header h1 {
            font-size: 2rem;
        }

        .header .btn {
            background: #ff6f61;
            border: none;
            transition: 0.3s;
        }

        .header .btn:hover {
            background: #e65a50;
        }

        .container-card {
            background-color: #fff;
            color: #333;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            flex-grow: 1; /* Permet à cette section de s'étendre pour combler l'espace disponible */
        }

        table th, table td {
            text-align: center;
        }

        .form-control, .form-select {
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        button {
            border-radius: 20px;
            padding: 10px 20px;
            transition: 0.3s;
        }

        button:hover {
            transform: scale(1.05);
            background-color: #218838;
        }

        footer {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            background-color: #4e73df;
            padding: 10px 0;
            margin-top: auto; /* Place le footer en bas lorsque le contenu principal est insuffisant */
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="container my-4">
        <div class="header d-flex justify-content-between align-items-center">
            <h1><i class="fas fa-user-graduate"></i> Bienvenue, <?= $student_name; ?> !</h1>
            <a href="../index.php" class="btn btn-danger">Déconnexion</a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container">
        <div class="container-card">
            <h2 class="text-center mb-4"><i class="fas fa-folder-open"></i> Vos Demandes de Documents</h2>
            <!-- Table for Viewing Requests -->
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-primary">
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
                                <td>
                                    <?php if ($request['status'] === 'Pending') { ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php } elseif ($request['status'] === 'Approved') { ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php } else { ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php } ?>
                                </td>
                                <td><?= htmlspecialchars($request['date_de_Depot']); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4" class="text-muted text-center">Aucune demande trouvée.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Form for Submitting a New Request -->
            <div class="mt-5">
                <h2 class="text-center mb-3"><i class="fas fa-plus-circle"></i> Nouvelle Demande</h2>
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="request-type" class="form-label">Type de Demande</label>
                        <select id="request-type" name="filetype" class="form-select" required>
                            <option value="certificate">Certificat de scolarité</option>
                            <option value="transcript">Relevé de notes</option>
                            <option value="attestation">Attestation de conduite</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="filename" class="form-label">Nom du Fichier</label>
                        <input type="text" id="filename" name="filename" class="form-control" placeholder="Nom du fichier demandé" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg">Soumettre la Demande</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Portail Étudiant. Tous droits réservés.</p>
    </footer>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>



















