<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/login.css"> 
    <title>Student Login</title>
</head>

<body>
    <div class="container" id="container">
        <!-- Formulaire de connexion -->
        <div class="form-container sign-in">
            <form action="db/login.php" method="POST">
                <h1>Sign In</h1>
                <!--  message d'erreur -->
                <?php
                session_start();
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
                    unset($_SESSION['error_message']); // Supprime le message d'erreur après l'affichage
                }
                ?>
                <span>Use your email and password</span>
                <input type="text" name="identifier" placeholder="Matricule or Admin ID" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign In</button>
            </form>
        </div>

       
        <div class="form-container sign-up">
            <form>
                <img src="assets/images/logo.png" alt="Student Portal Logo">
                <h1>Portal Student</h1>
                <p>
                    The Student Portal of the University of M'hamed Bougara Boumerdès is a user-friendly
                    digital platform designed to streamline academic and administrative interactions for students.
                    It provides a centralized hub for accessing essential university services, ensuring
                    that students can focus on their educational journey with ease.
                </p>
            </form>
        </div>

        
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of the site's features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Student!</h1>
                    <p>
                        The Student Portal of the University of M'hamed Bougara Boumerdès is a user-friendly
                        digital platform designed...
                    </p>
                    <button class="hidden" id="register">More</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/login.js"></script> 
</body>

</html>



