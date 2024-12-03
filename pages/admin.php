<?php
// Include the database connection and the function to fetch submissions
include("../db/admin_bd.php");

// Fetch submissions from the database
$submissions = fetchSubmissions();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .table-responsive {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table thead th {
            font-size: 0.9rem;
            text-transform: uppercase;
            font-weight: bold;
        }

        .btn-success,
        .btn-danger {
            font-size: 0.9rem;
        }

        footer {
            background: #4e73df;
            color: white;
        }

        .btn-update {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-user-shield"></i> Admin Panel
            </a>
            <div class="collapse navbar-collapse justify-content-end">
                <a href="../index.php" class="btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>
    </nav>

    <!-- Submissions Table -->
    <main class="container my-5">
        <h2 class="text-center mb-4 text-primary">
            <i class="fas fa-file-alt"></i> Gestion des Soumissions
        </h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th><i class="fas fa-user"></i> Nom Étudiant</th>
                        <th><i class="fas fa-user"></i> Prénom Étudiant</th>
                        <th><i class="fas fa-file"></i> Fichier</th>
                        <th><i class="fas fa-file-alt"></i> Type</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                        <th><i class="fas fa-calendar"></i> Date de Dépôt</th>
                        <th><i class="fas fa-cogs"></i> Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($submissions->num_rows > 0): ?>
                        <?php while ($row = $submissions->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td><?= htmlspecialchars($row['last_name']); ?></td>
                                <td>
                                    <a href="../uploads/<?= htmlspecialchars($row['filename']); ?>"
                                        class="text-decoration-none text-primary" target="_blank">
                                        <i class="fas <?= pathinfo($row['filename'], PATHINFO_EXTENSION) === 'pdf' ? 'fa-file-pdf' : 'fa-file'; ?>"></i>
                                        <?= htmlspecialchars($row['filename']); ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($row['filetype']); ?></td>
                                <td>
                                    <?php if ($row['status'] === 'Pending'): ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php elseif ($row['status'] === 'Approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['date_de_Depot']); ?></td>
                                <td>
                                    <form action="update_status.php" method="POST">
                                        <input type="hidden" name="id_file" value="<?= htmlspecialchars($row['id_file']); ?>">
                                        <select name="status" required>
                                            <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Approved" <?= $row['status'] === 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                            <option value="Rejected" <?= $row['status'] === 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                        </select>
                                        <button type="submit" class="btn btn-success btn-sm">Mettre à jour</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Aucune soumission trouvée.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-3 text-center">
        &copy; 2024 <i class="fas fa-graduation-cap"></i> Portail Étudiant - Tous droits réservés.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>