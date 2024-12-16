<?php
// Cargar el archivo XML
$xml = simplexml_load_file("libros.xml") or die("No se pudo cargar el archivo XML.");
?>

<table border="1">
    <tr>
        <th>Título</th>
        <th>Autor</th>
        <th>Género</th>
        <th>Año de Publicación</th>
        <th>Sinopsis</th>
    </tr>
    <?php foreach ($xml->libro as $libro): ?>
        <tr>
            <td><?php echo $libro->titulo; ?></td>
            <td><?php echo $libro->autor; ?></td>
            <td><?php echo $libro->genero; ?></td>
            <td><?php echo $libro->año_publicacion; ?></td>
            <td><?php echo $libro->sinopsis; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
