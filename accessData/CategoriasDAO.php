<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/Categoria.php';

class CategoriasDAO
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todas las categorías
    public function obtenerTodos()
    {
        // Ejemplo: obtener solo activas
        $stmt = $this->pdo->query("SELECT * FROM g2_categorias");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new Categoria(
                $row['id'],
                $row['nombre'],
                $row['estado']
            );
        }

        return $resultado;
    }

    // Obtener categoría por ID
    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_categorias WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Categoria($row['id'], $row['nombre'], $row['estado']);
        }

        return null;
    }

    // Insertar nueva categoría
    public function insertar(Categoria $objeto)
    {
        $sql = "INSERT INTO g2_categorias (nombre, estado) VALUES (?, ?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$objeto->nombre, $objeto->estado ?? 'activo']);
    }

    // Actualizar con estado
    public function actualizar(Categoria $objeto)
    {
        $sql = "UPDATE g2_categorias SET nombre = ?, estado = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$objeto->nombre, $objeto->estado, $objeto->id]);
    }

    // Eliminar lógico (cambiar estado a inactivo)
    public function eliminar($id)
    {
        $sql = "UPDATE g2_categorias SET estado = 'inactivo' WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}


?>