<?php

// Function to insert a new document request
function insertStudentRequest($student_matricule, $filename, $filetype) {
    // Database connection details
    $host = 'localhost';
    $dbname = 'paw';
    $username = 'root';
    $password = 'sami12345'; // Replace with your actual database password

    // Create a new connection to the database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query to insert the new request
    $query = $conn->prepare("INSERT INTO documents (id_etud, filename, filetype, status, date_de_Depot) VALUES (?, ?, ?, 'Pending', YEAR(CURDATE()))");
    if (!$query) {
        die("SQL query preparation failed: " . $conn->error);
    }

    // Bind the student matricule and other fields to the query (prevent SQL injection)
    $query->bind_param("iss", $student_matricule, $filename, $filetype);

    // Execute the query
    if (!$query->execute()) {
        die("Query execution failed: " . $query->error);
    }

    // Close the query and the database connection
    $query->close();
    $conn->close();
}

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = 'localhost';
$dbname = 'paw';
$username = 'root';
$password = 'sami12345'; // Replace with your MySQL root password

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login_admin'])) {
        // Admin login
        $admin_id = $conn->real_escape_string($_POST['admin_id']);
        $admin_password = $conn->real_escape_string($_POST['admin_password']);

        // Query to check admin credentials
        $query = "SELECT * FROM admin WHERE id = '$admin_id'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            if ($admin_password === $admin['password']) {
                echo "Welcome, Admin!";
                // Redirect to admin dashboard (example: admin.php)
                header("Location: ../pages/admin.php");
                exit();
            } else {
                echo "Invalid Admin Password.";
            }
        } else {
            echo "Admin ID not found.";
        }
    } elseif (isset($_POST['login_student'])) {
        // Student login
        $student_matricule = $conn->real_escape_string($_POST['student_matricule']);
        $student_password = $conn->real_escape_string($_POST['student_password']);

        // Query to check student credentials
        $query = "SELECT * FROM etudiant WHERE matricule = '$student_matricule'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
            if ($student_password === $student['password']) {
                echo "Welcome, Student!";
                // Redirect to student dashboard (example: student.php)
                header("Location: ../pages/etudiant.php");
                exit();
            } else {
                echo "Invalid Student Password.";
            }
        } else {
            echo "Matricule not found.";
        }
    } else {
        echo "No login type specified.";
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
