<?php
include 'conexion.php';

// Consulta para obtener los libros
$sql = "SELECT libros.id, libros.titulo, libros.autor, generos.nombre AS genero, libros.año_publicacion, libros.sinopsis 
        FROM libros 
        JOIN generos ON libros.genero_id = generos.id";
$result = $conn->query($sql);

// Crear un objeto SimpleXMLElement
$xml = new SimpleXMLElement('<biblioteca/>');

// Agregar libros al XML
while ($row = $result->fetch_assoc()) {
    $libro = $xml->addChild('libro');
    $libro->addChild('id', $row['id']);
    $libro->addChild('titulo', htmlspecialchars($row['titulo']));
    $libro->addChild('autor', htmlspecialchars($row['autor']));
    $libro->addChild('genero', htmlspecialchars($row['genero']));
    $libro->addChild('año_publicacion', $row['año_publicacion']);
    $libro->addChild('sinopsis', htmlspecialchars($row['sinopsis']));
}

// Guardar el XML en un archivo
$xml->asXML('biblioteca.xml');

echo "XML generado con éxito.";
?>
