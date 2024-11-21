<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <title>Student Login</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
        <form action="db/login.php" method="POST">
    <input type="text" name="admin_id" placeholder="Admin ID" required>
    <input type="password" name="admin_password" placeholder="Password" required>
    <button type="submit" name="login_admin">Sign In</button>
</form>

</form>

        </div>
        <div class="form-container sign-in">
            <form action="db/login.php" method="POST">
                <h1>Student</h1>
                <span>Use your matricule and password</span>
                <input type="text" name="student_matricule" placeholder="Matricule" required>
                <input type="password" name="student_password" placeholder="Password" required>
                <button type="submit" name="login_student">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Admin!</h1>
                    <button class="hidden" id="login">Student</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Student!</h1>
                    <p>Register with your personal details to use all of the site features</p>
                    <button class="hidden" id="register">Admin</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>
