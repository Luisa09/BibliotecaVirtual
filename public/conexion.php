<?php
$servername = "localhost";
$username = "root"; // Cambia por tu usuario
$password = ""; // Cambia por tu contraseña
$database = "biblioteca_virtual";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>