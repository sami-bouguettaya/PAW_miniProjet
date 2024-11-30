<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #74ebd5, #9face6);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 400px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #4e73df;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .btn-primary {
            background-color: #4e73df;
            border: none;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #375a7f;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 5px rgba(78, 115, 223, 0.5);
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            Login
        </div>
        <div class="card-body">
            <h5 class="text-center mb-4">Sign In</h5>

            <!-- Display error message if set -->
            <?php
            session_start();
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']); // Clear the error message after displaying it
            }
            ?>

            <!-- Unified Login Form -->
            <form action="db/login.php" method="POST">
                <div class="mb-3">
                    <label for="identifier" class="form-label">Identifier (Matricule or Admin ID)</label>
                    <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter your Matricule or Admin ID" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


