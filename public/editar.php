<?php
include 'conexion.php';

$id = $_GET['id'];
$sql = "SELECT * FROM libros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$libro = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero_id = $_POST['genero_id'];
    $año_publicacion = $_POST['año_publicacion'];
    $sinopsis = $_POST['sinopsis'];
    $portada_url = $_POST['portada_url'];

    $sql_update = "UPDATE libros SET titulo = ?, autor = ?, genero_id = ?, año_publicacion = ?, sinopsis = ?, portada_url = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssiissi", $titulo, $autor, $genero_id, $año_publicacion, $sinopsis, $portada_url, $id);

    if ($stmt_update->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error al actualizar el libro: " . $stmt_update->error . "</p>";
    }

    $stmt_update->close();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro - Biblioteca Virtual</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Libro</h1>
        <p class="text-center">Actualiza la información del libro seleccionado.</p>
        <form method="POST" action="">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="autor">Autor</label>
                <input type="text" class="form-control" id="autor" name="autor" value="<?php echo htmlspecialchars($libro['autor']); ?>" required>
            </div>
            <div class="form-group">
                <label for="genero_id">Género</label>
                <select class="form-control" id="genero_id" name="genero_id" required>
                    <option value="">Seleccione un género</option>
                    <?php
                    include 'conexion.php';
                    $sql_generos = "SELECT id, nombre FROM generos";
                    $result_generos = $conn->query($sql_generos);
                    
                    while ($row = $result_generos->fetch_assoc()) {
                        $selected = $libro['genero_id'] == $row['id'] ? 'selected' : '';
                        echo "<option value='" . $row['id'] . "' $selected>" . htmlspecialchars($row['nombre']) . "</option>";
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="año_publicacion">Año de Publicación</label>
                <input type="number" class="form-control" id="año_publicacion" name="año_publicacion" min="0" max="2100" value="<?php echo htmlspecialchars($libro['año_publicacion']); ?>">
            </div>
            <div class="form-group">
                <label for="sinopsis">Sinopsis</label>
                <textarea class="form-control" id="sinopsis" name="sinopsis" rows="3"><?php echo htmlspecialchars($libro['sinopsis']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="portada_url">URL de la Portada</label>
                <input type="url" class="form-control" id="portada_url" name="portada_url" value="<?php echo htmlspecialchars($libro['portada_url']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
