<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "biblioteca_virtual";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los libros y sus géneros
$sql = "SELECT libros.id, libros.titulo, libros.autor, libros.año_publicacion, libros.sinopsis, libros.portada_url, generos.nombre AS genero, libros.precio
        FROM libros
        LEFT JOIN generos ON libros.genero_id = generos.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Crear un objeto SimpleXMLElement para estructurar los datos en XML
    $xml = new SimpleXMLElement('<catalogo/>');

    while ($row = $result->fetch_assoc()) {
        $libro = $xml->addChild('libro');
        $libro->addAttribute('id', $row['id']);
        $libro->addChild('titulo', $row['titulo']);
        $libro->addChild('autor', $row['autor']);
        $libro->addChild('genero', $row['genero']);
        $libro->addChild('año_publicacion', $row['año_publicacion']);
        $libro->addChild('sinopsis', $row['sinopsis']);
        $libro->addChild('portada_url', $row['portada_url']);
        $libro->addChild('precio', $row['precio']);
    }

    // Guardar el XML en un archivo
    $xml->asXML('libros.xml');
    echo "Archivo XML generado con éxito.";
} else {
    echo "No se encontraron registros en la base de datos.";
}

$conn->close();
?>
