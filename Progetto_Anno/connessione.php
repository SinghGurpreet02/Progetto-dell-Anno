<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "progetto_anno";

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}
?>