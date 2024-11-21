<?php
include '../db/admin_bd.php';

// Fetch all submissions
$submissions = fetchSubmissions();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title>Admin Panel</title>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Admin Panel</h1>
        <a href="../index.php" class="logout">Déconnexion</a>
    </div>

    <!-- Submissions Table -->
    <table>
        <thead>
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
                        <td><?= htmlspecialchars($row['filename']); ?></td>
                        <td><?= htmlspecialchars($row['filetype']); ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td><?= htmlspecialchars($row['date_de_Depot']); ?></td>
                        <td>
                            <!-- Form to Update Status -->
                            <form action="update_status.php" method="POST">
                                <input type="hidden" name="id_etud" value="<?= htmlspecialchars($row['id_etud']); ?>">
                                <select name="status" required>
                                    <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Approved" <?= $row['status'] === 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                    <option value="Rejected" <?= $row['status'] === 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No submissions found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>

