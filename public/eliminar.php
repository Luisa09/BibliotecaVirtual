<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM libros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error al eliminar el libro: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>
