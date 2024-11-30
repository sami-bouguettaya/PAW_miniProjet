<?php
session_start(); // Start a session to track logged-in users

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
include("db.php");  // Make sure this file connects to your DB

// Initialize error message variable
$error_message = "";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user inputs
    $identifier = $conn->real_escape_string($_POST['identifier']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if the identifier is for an admin or student
    // Check admin first
    $query_admin = "SELECT * FROM admin WHERE id = '$identifier'";
    $result_admin = $conn->query($query_admin);

    if ($result_admin->num_rows > 0) {
        // Admin found
        $admin = $result_admin->fetch_assoc();
        if ($password === $admin['password']) {
            // Set session for the admin
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['role'] = 'admin';
            header("Location: ../pages/admin.php");
            exit();
        } else {
            $error_message = "Invalid Admin Password.";
        }
    } else {
        // Admin not found, check if it's a student
        $query_student = "SELECT * FROM etudiant WHERE matricule = '$identifier'";
        $result_student = $conn->query($query_student);

        if ($result_student->num_rows > 0) {
            // Student found
            $student = $result_student->fetch_assoc();
            if ($password === $student['password']) {
                // Set session for the student
                $_SESSION['student_matricule'] = $student['matricule'];
                $_SESSION['student_name'] = $student['name'];
                $_SESSION['role'] = 'student';
                header("Location: ../pages/etudiant.php");
                exit();
            } else {
                $error_message = "Invalid Student Password.";
            }
        } else {
            $error_message = "Identifier not found.";
        }
    }

    // If an error message exists, pass it to the login page
    if (!empty($error_message)) {
        // Store the error message in a session variable to use on the login page
        $_SESSION['error_message'] = $error_message;
        header("Location: ../index.php"); // Redirect to the login page
        exit();
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
