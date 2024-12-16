<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Árbol XML</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        ul {
            list-style-type: none; /* Elimina los puntos de las listas */
            margin: 0;
            padding: 0;
        }
        li {
            margin: 5px 0; /* Espaciado entre elementos de la lista */
            padding: 5px; /* Espaciado interno */
            border: 1px solid #ddd; /* Borde alrededor de cada elemento */
            border-radius: 4px; /* Bordes redondeados */
            background-color: #f9f9f9; /* Color de fondo */
        }
        li ul {
            margin-left: 20px; /* Margen izquierdo para listas anidadas */
            display: none; /* Oculta las sublistas inicialmente */
        }
        li:hover {
            background-color: #e9ecef; /* Color de fondo al pasar el mouse */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Árbol XML de Libros</h1>
        <div id="xmlTree" class="mt-4"></div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "biblioteca.xml",
                dataType: "xml",
                success: function(xml) {
                    function createTree(xml) {
                        let $tree = $('<ul/>');
                        $(xml).find('libro').each(function() {
                            let $li = $('<li/>').text($(this).find('titulo').text());
                            let $details = $('<ul/>');
                            $details.append($('<li/>').text('Autor: ' + $(this).find('autor').text()));
                            $details.append($('<li/>').text('Género: ' + $(this).find('genero').text()));
                            $details.append($('<li/>').text('Año de Publicación: ' + $(this).find('año_publicacion').text()));
                            $details.append($('<li/>').text('Sinopsis: ' + $(this).find('sinopsis').text()));
                            $li.append($details);
                            $tree.append($li);

                            // Mostrar/ocultar sublistas al hacer clic
                            $li.on('click', function(event) {
                                event.stopPropagation(); // Prevenir el evento de clic en el padre
                                $details.toggle(); // Alternar la visibilidad de la sublista
                            });
                        });
                        return $tree;
                    }
                    $('#xmlTree').append(createTree(xml));
                },
                error: function() {
                    alert("Error al cargar el archivo XML.");
                }
            });
        });
    </script>
</body>
</html>
