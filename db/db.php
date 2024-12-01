<?php
// Configuration de la base de données
$host = "localhost";
$dbname = "paw";
$username = "root"; // Remplace par ton nom d'utilisateur
$password = "sami12345"; // Remplace par ton mot de passe

// Connexion MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Assure que l'encodage est UTF-8
$conn->set_charset("utf8");
?>
