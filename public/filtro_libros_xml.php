<?php
$xml = simplexml_load_file("libros.xml") or die("No se pudo cargar el archivo XML.");
$filtroGenero = "Novela"; // Cambia esto al género que desees filtrar

echo "<table border='1'>
    <tr>
        <th>Título</th>
        <th>Autor</th>
        <th>Género</th>
        <th>Año de Publicación</th>
    </tr>";

foreach ($xml->libro as $libro) {
    if ($libro->genero == $filtroGenero) {
        echo "<tr>";
        echo "<td>" . $libro->titulo . "</td>";
        echo "<td>" . $libro->autor . "</td>";
        echo "<td>" . $libro->genero . "</td>";
        echo "<td>" . $libro->año_publicacion . "</td>";     
        echo "</tr>";
    }
}

echo "</table>";
