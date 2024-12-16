<?php include 'conexion.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero_id = $_POST['genero_id'];
    $año_publicacion = $_POST['año_publicacion'];
    $sinopsis = $_POST['sinopsis'];
    $portada_url = $_POST['portada_url'];

    $stmt = $conn->prepare("INSERT INTO libros (titulo, autor, genero_id, año_publicacion, sinopsis, portada_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiss", $titulo, $autor, $genero_id, $año_publicacion, $sinopsis, $portada_url);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error al agregar libro: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Libro - Biblioteca Virtual</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Agregar Nuevo Libro</h1>
        <p class="text-center">Completa los datos del libro para añadirlo a la colección.</p>
        <form method="POST" action="agregar.php">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="autor">Autor</label>
                <input type="text" class="form-control" id="autor" name="autor" required>
            </div>
            <div class="form-group">
                <label for="genero_id">Género</label>
                <select class="form-control" id="genero_id" name="genero_id" required>
                    <option value="">Seleccione un género</option>
                    <?php
                    $sql = "SELECT id, nombre FROM generos";
                    $result = $conn->query($sql);
                    
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="año_publicacion">Año de Publicación</label>
                <input type="number" class="form-control" id="año_publicacion" name="año_publicacion" min="0" max="2100">
            </div>
            <div class="form-group">
                <label for="sinopsis">Sinopsis</label>
                <textarea class="form-control" id="sinopsis" name="sinopsis" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="portada_url">URL de la Portada</label>
                <input type="url" class="form-control" id="portada_url" name="portada_url">
            </div>
            <button type="submit" class="btn btn-success">Agregar Libro</button>
            <a href="index.php" class="btn btn-secondary">Volver al Catálogo</a>
        </form>
    </div>
</body>
</html>
