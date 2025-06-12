<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/Cita.php';

class CitaDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todas las citas
    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM B86781_citas;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new Cita(
                $row['id'],
                $row['paciente_id'],
                $row['doctor_id'],
                $row['fecha'],
                $row['estado']
            );
        }

        return $resultado;
    }

    // Obtener una cita por ID
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM B86781_citas WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Cita(
                $row['id'],
                $row['paciente_id'],
                $row['doctor_id'],
                $row['fecha'],
                $row['estado']
            );
        }

        return null;
    }

    // Insertar nueva cita
    public function insertar(Cita $objeto) {
        $sql = "INSERT INTO B86781_citas (paciente_id, doctor_id, fecha, estado) VALUES (?, ?, ?, ?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->paciente_id,
            $objeto->doctor_id,
            $objeto->fecha,
            $objeto->estado
        ]);
    }

    // Actualizar una cita existente
    public function actualizar(Cita $objeto) {
        $sql = "UPDATE B86781_citas SET paciente_id = ?, doctor_id = ?, fecha = ?, estado = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->paciente_id,
            $objeto->doctor_id,
            $objeto->fecha,
            $objeto->estado,
            $objeto->id
        ]);
    }

    // Eliminar una cita
    public function eliminar($id) {
        $sql = "DELETE FROM B86781_citas WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>
