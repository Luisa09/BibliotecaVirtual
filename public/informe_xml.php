<?php
include 'conexion.php';

// Consultar todos los libros
$sql = "SELECT libros.id, libros.titulo, libros.autor, generos.nombre AS genero, libros.año_publicacion, libros.portada_url, libros.sinopsis
        FROM libros 
        JOIN generos ON libros.genero_id = generos.id";

$result = $conn->query($sql);

// Crear un nuevo objeto XML
$xml = new SimpleXMLElement('<?xml version="1.0"?><catalogoLibros></catalogoLibros>');

// Agregar los libros al XML
while ($row = $result->fetch_assoc()) {
    $libro = $xml->addChild('libro');
    $libro->addChild('id', $row['id']);
    $libro->addChild('titulo', htmlspecialchars($row['titulo']));
    $libro->addChild('autor', htmlspecialchars($row['autor']));
    $libro->addChild('genero', htmlspecialchars($row['genero']));
    $libro->addChild('ano_publicacion', $row['año_publicacion']);
    $libro->addChild('portada_url', htmlspecialchars($row['portada_url']));
    $libro->addChild('sinopsis', htmlspecialchars($row['sinopsis']));
}

// Establecer el encabezado para descargar el archivo XML
header('Content-Type: application/xml');
header('Content-Disposition: attachment; filename="informe_libros.xml"');

// Imprimir el XML
echo $xml->asXML();

$conn->close();
?>
