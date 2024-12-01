<?php
// Configuration de la base de données
$host = "localhost";
$dbname = "paw";
$username = "root"; // Changez si nécessaire
$password = "sami12345"; // Changez si nécessaire

// Connexion MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Définir l'encodage UTF-8
$conn->set_charset("utf8");
?>

