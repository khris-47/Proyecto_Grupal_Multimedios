<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/CategoriaDoctor.php';

class CategoriasDoctoresDAO
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los registros
    public function obtenerTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM g2_categorias_doctores;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new CategoriaDoctor(
                $row['id'],
                $row['doctor_id'],
                $row['categoria_id']
            );
        }

        return $resultado;
    }

    // Insertar nuevo
    public function insertar(CategoriaDoctor $objeto)
    {
        $sql = "INSERT INTO g2_categorias_doctores (doctor_id, categoria_id) VALUES (?, ?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$objeto->doctor_id, $objeto->categoria_id]);
    }

    // Actualizar
    public function actualizar(CategoriaDoctor $objeto)
    {
        $sql = "UPDATE g2_categorias_doctores SET doctor_id = ?, categoria_id = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$objeto->doctor_id, $objeto->categoria_id, $objeto->id]);
    }

    // Eliminar
    public function eliminar($id)
    {
        $sql = "DELETE FROM g2_categorias_doctores WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }


    // Obtener un registro por su ID
    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_categorias_doctores WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new CategoriaDoctor(
                $row['id'],
                $row['doctor_id'],
                $row['categoria_id']
            );
        }
        return null; // No encontrado
    }



}


?>