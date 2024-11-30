<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1; /* Prend tout l'espace restant entre le header et le footer */
        }
    </style>
</head>

<body class="bg-light">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand mx-auto fw-bold" href="#">Portail Étudiant - Admin Panel</a>
            <a href="../index.php" class="btn btn-danger">Déconnexion</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-5">
        <h2 class="text-center mb-4">Gestion des Soumissions</h2>
        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Nom Étudiant</th>
                        <th>Prénom Étudiant</th>
                        <th>Fichier</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date de Dépôt</th>
                        <th>Action</th>
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
                                       class="text-decoration-none" 
                                       target="_blank"><?= htmlspecialchars($row['filename']); ?></a>
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
                                    <form action="update_status.php" method="POST" class="d-flex justify-content-center align-items-center gap-2">
                                        <input type="hidden" name="id_etud" value="<?= htmlspecialchars($row['id_etud']); ?>">
                                        <select name="status" class="form-select form-select-sm w-auto" required>
                                            <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Approved" <?= $row['status'] === 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                            <option value="Rejected" <?= $row['status'] === 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                        </select>
                                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-muted">Aucune soumission trouvée.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-3 bg-primary text-white">
        &copy; 2024 Portail Étudiant - Tous droits réservés.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


