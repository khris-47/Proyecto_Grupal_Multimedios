<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/Categoria.php';

class CategoriasDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todas las categorías
    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM B86781_categorias;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new Categoria(
                $row['id'],
                $row['nombre']
            );
        }

        return $resultado;
    }

    // Obtener categoría por ID
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM B86781_categorias WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Categoria($row['id'], $row['nombre']);
        }

        return null;
    }

    // Insertar nueva categoría
    public function insertar(Categoria $objeto) {
        $sql = "INSERT INTO B86781_categorias (nombre) VALUES (?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$objeto->nombre]);
    }

    // Actualizar categoría
    public function actualizar(Categoria $objeto) {
        $sql = "UPDATE B86781_categorias SET nombre = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$objeto->nombre, $objeto->id]);
    }

    // Eliminar categoría
    public function eliminar($id) {
        $sql = "DELETE FROM B86781_categorias WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}


?>
