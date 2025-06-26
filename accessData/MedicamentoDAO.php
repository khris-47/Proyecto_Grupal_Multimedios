<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/Medicamento.php';

class MedicamentoDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los medicamentos
    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM g2_medicamentos;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new Medicamento(
                $row['id'],
                $row['nombre'],
                $row['descripcion'],
                $row['cantidad'],
                $row['precio_unitario']
            );
        }

        return $resultado;
    }

    // Obtener medicamento por ID
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_medicamentos WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Medicamento(
                $row['id'],
                $row['nombre'],
                $row['descripcion'],
                $row['cantidad'],
                $row['precio_unitario']
            );
        }

        return null;
    }

    // Insertar nuevo medicamento
    public function insertar(Medicamento $objeto) {
        $sql = "INSERT INTO g2_medicamentos (nombre, descripcion, cantidad, precio_unitario) VALUES (?, ?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->nombre,
            $objeto->descripcion,
            $objeto->cantidad,
            $objeto->precio_unitario
        ]);
    }

    // Actualizar medicamento existente
    public function actualizar(Medicamento $objeto) {
        $sql = "UPDATE g2_medicamentos SET nombre = ?, descripcion = ?, cantidad = ?, precio_unitario = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->nombre,
            $objeto->descripcion,
            $objeto->cantidad,
            $objeto->precio_unitario,
            $objeto->id
        ]);
    }

    // Eliminar medicamento
    public function eliminar($id) {
        $sql = "DELETE FROM g2_medicamentos WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>
