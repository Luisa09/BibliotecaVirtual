<?php
class Libro {
    private $conn;
    private $table_name = "libros";

    public $id;
    public $titulo;
    public $autor;
    public $anio_publicacion;
    public $genero;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET titulo=:titulo, autor=:autor, anio_publicacion=:anio, genero=:genero";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":anio", $this->anio_publicacion);
        $stmt->bindParam(":genero", $this->genero);
        return $stmt->execute();
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET titulo=:titulo, autor=:autor, anio_publicacion=:anio, genero=:genero WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":anio", $this->anio_publicacion);
        $stmt->bindParam(":genero", $this->genero);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
