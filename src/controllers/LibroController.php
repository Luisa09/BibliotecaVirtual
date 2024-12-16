<?php
require_once '../config/database.php';
require_once '../models/Libro.php';

class LibroController {
    private $database;
    private $db;
    private $libro;

    public function __construct() {
        $this->database = new Database();
        $this->db = $this->database->getConnection();
        $this->libro = new Libro($this->db);
    }

    public function createLibro($data) {
        $this->libro->titulo = $data['titulo'];
        $this->libro->autor = $data['autor'];
        $this->libro->anio_publicacion = $data['anio'];
        $this->libro->genero = $data['genero'];
        return $this->libro->create();
    }

    public function listLibros() {
        return $this->libro->readAll();
    }

    public function updateLibro($data) {
        $this->libro->id = $data['id'];
        $this->libro->titulo = $data['titulo'];
        $this->libro->autor = $data['autor'];
        $this->libro->anio_publicacion = $data['anio'];
        $this->libro->genero = $data['genero'];
        return $this->libro->update();
    }

    public function deleteLibro($id) {
        $this->libro->id = $id;
        return $this->libro->delete();
    }
}
