<?php
include 'conexion.php';

// Obtener todos los géneros para el filtro
$generos_sql = "SELECT nombre FROM generos";
$generos_result = $conn->query($generos_sql);
$generos = [];
while ($row = $generos_result->fetch_assoc()) {
    $generos[] = $row['nombre'];
}

// Cálculo del total de libros
$totalLibros = 0;

// Cálculo del número de libros por género
$librosPorGenero = [];
foreach ($generos as $genero) {
    $sqlGenero = "SELECT COUNT(*) as cantidad FROM libros JOIN generos ON libros.genero_id = generos.id WHERE generos.nombre = '" . $conn->real_escape_string($genero) . "'";
    $resultadoGenero = $conn->query($sqlGenero);
    $cantidad = $resultadoGenero->fetch_assoc()['cantidad'];
    $librosPorGenero[$genero] = $cantidad;
    $totalLibros += $cantidad; // Sumar a total
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Libros</title>
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra suave para el contenedor */
            padding: 20px;
            border-radius: 8px; /* Bordes redondeados */
            background-color: #ffffff; /* Fondo blanco para la tabla */
        }
        .table {
            background-color: #ffffff; /* Color de fondo de la tabla */
            border-radius: 8px; /* Bordes redondeados en la tabla */
            overflow: hidden; /* Oculta los bordes redondeados en las esquinas */
        }
        .table th {
            background-color: #6AC8D9; /* Color del encabezado de la tabla */
            color: white; /* Color del texto en el encabezado */
            text-align: center; /* Centrar texto en encabezado */
        }
        .table td {
            text-align: center; /* Centrar texto en celdas */
        }
        .alert {
            margin-top: 20px; /* Espaciado para alertas */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Resumen de Libros</h1>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Género</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($librosPorGenero as $genero => $cantidad): 
                    $porcentaje = ($totalLibros > 0) ? ($cantidad / $totalLibros) * 100 : 0; ?>
                    <tr>
                        <td><?php echo htmlspecialchars($genero); ?></td>
                        <td><?php echo $cantidad; ?></td>
                        <td><?php echo number_format($porcentaje, 2) . '%'; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong><?php echo $totalLibros; ?></strong></td>
                    <td><strong>100%</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
