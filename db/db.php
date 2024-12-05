<?php

$host = "localhost";
$dbname = "paw";
$username = "root"; 
$password = "sami12345"; 

// Cnx my sql
$conn = new mysqli($host, $username, $password, $dbname);

// Vérification cnx
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}


$conn->set_charset("utf8");
?>

