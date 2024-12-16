<?php
// Verificar si el archivo XML existe
if (!file_exists("libros.xml")) {
    echo "El archivo XML no existe. Primero ejecuta exportar_xml.php para generar el archivo.";
    exit;
}

$xml = simplexml_load_file("libros.xml");

// Calcular el total de precios y agrupar por género
$totalPrecio = 0;
$librosPorGenero = [];

foreach ($xml->libro as $libro) {
    $precio = (float)$libro->precio;
    $totalPrecio += $precio;

    $genero = (string)$libro->genero;
    if (!isset($librosPorGenero[$genero])) {
        $librosPorGenero[$genero] = [];
    }
    $librosPorGenero[$genero][] = $libro;
}

// Filtro por género (si está definido en la URL)
$filtroGenero = isset($_GET['genero']) ? $_GET['genero'] : null;
$librosFiltrados = $filtroGenero ? $librosPorGenero[$filtroGenero] : $xml->libro;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Libros</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Listado de Libros</h1>

        <!-- Mostrar Árbol XML -->
        <button onclick="document.getElementById('xmlTree').style.display='block';" class="btn btn-info">Mostrar Árbol XML</button>
        <pre id="xmlTree" style="display:none;"><?php echo htmlspecialchars($xml->asXML()); ?></pre>

        <!-- Filtro por Género -->
        <form method="get" class="mb-3">
            <label for="genero">Filtrar por Género:</label>
            <select name="genero" id="genero" class="form-control" onchange="this.form.submit()">
                <option value="">Todos</option>
                <?php foreach (array_keys($librosPorGenero) as $genero): ?>
                    <option value="<?php echo $genero; ?>" <?php if ($filtroGenero === $genero) echo 'selected'; ?>>
                        <?php echo $genero; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <!-- Tabla de Libros -->
        <table class="table table-bordered table-hover mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Género</th>
                    <th>Año de Publicación</th>
                    <th>Sinopsis</th>
                    <th>Portada</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalFiltrados = 0;
                foreach ($librosFiltrados as $libro): 
                    $totalFiltrados += (float)$libro->precio;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($libro->titulo); ?></td>
                        <td><?php echo htmlspecialchars($libro->autor); ?></td>
                        <td><?php echo htmlspecialchars($libro->genero); ?></td>
                        <td><?php echo htmlspecialchars($libro->año_publicacion); ?></td>
                        <td><?php echo htmlspecialchars($libro->sinopsis); ?></td>
                        <td><img src="<?php echo htmlspecialchars($libro->portada_url); ?>" alt="Portada de <?php echo htmlspecialchars($libro->titulo); ?>" style="width: 80px;"></td>
                        <td><?php echo number_format((float)$libro->precio, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Mostrar Totales -->
        <p><strong>Valor Total de Libros:</strong> $<?php echo number_format($totalPrecio, 2); ?></p>
        <?php if ($filtroGenero): ?>
            <p><strong>Total Filtrado (<?php echo $filtroGenero; ?>):</strong> $<?php echo number_format($totalFiltrados, 2); ?></p>
            <p><strong>Porcentaje Filtrado:</strong> <?php echo number_format(($totalFiltrados / $totalPrecio) * 100, 2); ?>%</p>
        <?php endif; ?>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
