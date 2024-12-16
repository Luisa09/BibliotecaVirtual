<?php
include 'conexion.php';


// Consultar todos los libros
$sql = "SELECT libros.id, libros.titulo, libros.autor, generos.nombre AS genero, libros.año_publicacion, libros.portada_url, libros.sinopsis
        FROM libros 
        JOIN generos ON libros.genero_id = generos.id";

// Filtrar por género si se ha seleccionado
if (isset($_GET['filtroGenero']) && !empty($_GET['filtroGenero'])) {
    $filtroGenero = $_GET['filtroGenero'];
    $sql .= " WHERE generos.nombre = '" . $conn->real_escape_string($filtroGenero) . "'";
}

$result = $conn->query($sql);

// Obtener todos los géneros para el filtro
$generos_sql = "SELECT nombre FROM generos";
$generos_result = $conn->query($generos_sql);
$generos = [];
while ($row = $generos_result->fetch_assoc()) {
    $generos[] = $row['nombre'];
}

// Cálculo del total de libros
$totalLibros = $result->num_rows;

// Cálculo del número de libros por género
$librosPorGenero = [];
foreach ($generos as $genero) {
    $sqlGenero = "SELECT COUNT(*) as cantidad FROM libros JOIN generos ON libros.genero_id = generos.id WHERE generos.nombre = '" . $conn->real_escape_string($genero) . "'";
    $resultadoGenero = $conn->query($sqlGenero);
    $cantidad = $resultadoGenero->fetch_assoc()['cantidad'];
    $librosPorGenero[$genero] = $cantidad;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Libros</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        background-color: #f8f9fa; /* Color de fondo suave */
    }
    h1 {
        font-family: 'Arial', sans-serif;
        color: #343a40; /* Color del encabezado */
    }
    .container {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra suave para la contenedor */
        padding: 20px;
        border-radius: 8px; /* Bordes redondeados */
        background-color: #ffffff; /* Fondo blanco para la tabla */
    }
    .table {
        background-color: #ffffff; /* Color de fondo de la tabla */
    }
    .table th {
        background-color: #6AC8D9; /* Color del encabezado de la tabla */
        color: white; /* Color del texto en el encabezado */
    }
    .btn {
        margin-right: 5px; /* Espaciado entre botones */
    }
    .alert {
        margin-top: 20px; /* Espaciado para alertas */
    }
</style>

</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Catálogo de Libros</h1>
        <p class="text-center">Consulta y gestiona nuestra colección de libros.</p>
        
        <a href="agregar.php" class="btn btn-success mb-3">Agregar Nuevo Libro</a>

        <!-- Formulario de Filtrado -->
        <form method="GET" class="mb-4">
            <div class="form-group">
                <label for="filtroGenero">Filtrar por Género:</label>
                <select name="filtroGenero" id="filtroGenero" class="form-control">
                    <option value="">Todos</option>
                    <?php foreach ($generos as $genero): ?>
                        <option value="<?php echo htmlspecialchars($genero); ?>" <?php echo (isset($filtroGenero) && $filtroGenero == $genero) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($genero); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Género</th>
                    <th>Año de Publicación</th>
                    <th>Portada</th>
                    <th>Sinopsis</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($row['autor']); ?></td>
                        <td><?php echo htmlspecialchars($row['genero']); ?></td>
                        <td><?php echo htmlspecialchars($row['año_publicacion']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['portada_url']); ?>" alt="Portada" style="width: 50px; height: auto;"></td>
                        <td><?php echo htmlspecialchars($row['sinopsis']); ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este libro?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Mensaje si no hay libros -->
        <?php if ($result->num_rows === 0): ?>
            <div class="alert alert-warning text-center">No hay libros disponibles.</div>
        <?php endif; ?>

        <!-- Botones para redireccionar a los archivos XML -->
<div class="text-center mt-4">
    <h3>Reportes en XML</h3>
    <a href="visualizar_xml.php" class="btn btn-info mb-2" target="_blank">Arbol XML</a>
    <a href="listado_libros_xml.php" class="btn btn-info mb-2" target="_blank">Listado XML</a>
    <a href="resumen.php" class="btn btn-info mb-2" target="_blank">Resumen Libros</a>
    <a href="informe_xml.php" class="btn btn-info mb-2" target="_blank">Descargar Informe en XML</a>

</div>


  

<?php
$conn->close();
?>
