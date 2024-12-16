<?php
require_once '../controllers/LibroController.php';

$libroController = new LibroController();

$resolvers = [
    'Query' => [
        'libros' => function() use ($libroController) {
            return $libroController->listLibros();
        },
    ],
    'Mutation' => [
        'agregarLibro' => function($root, $args) use ($libroController) {
            return $libroController->createLibro($args);
        },
        'actualizarLibro' => function($root, $args) use ($libroController) {
            return $libroController->updateLibro($args);
        },
        'eliminarLibro' => function($root, $args) use ($libroController) {
            return $libroController->deleteLibro($args['id']);
        },
    ]
];
