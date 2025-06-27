<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/HistorialMedicoUsuario.php';

class HistorialMedicoUsuarioDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    public function getPDO() {
        return $this->pdo;
    }
    
    // Obtener historiales por paciente_id
public function obtenerPorPaciente($paciente_id) {
    try {
        $sql = "SELECT h.*, c.paciente_id 
                FROM g2_historial_medico_usuario h
                JOIN g2_citas c ON h.cita_id = c.id
                WHERE c.paciente_id = ?;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$paciente_id]);

        $resultado = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new HistorialMedicoUsuario(
                $row['id'],
                $row['paciente_id'],
                $row['cita_id'],
                $row['descripcion'],
                $row['observaciones'],
                $row['fecha']
            );
        }

        return $resultado;
    } catch (PDOException $e) {
        return [];
    }
}

    // Obtener todos los registros con paciente_id desde la tabla de citas
    public function obtenerTodos() {
        try {
            $stmt = $this->pdo->query("SELECT h.*, c.paciente_id 
                                       FROM g2_historial_medico_usuario h
                                       JOIN g2_citas c ON h.cita_id = c.id;");

            $resultado = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultado[] = new HistorialMedicoUsuario(
                    $row['id'],
                    $row['paciente_id'],
                    $row['cita_id'],
                    $row['descripcion'],
                    $row['observaciones'],
                    $row['fecha']
                );
            }

            return $resultado;
        } catch (PDOException $e) {
            return [];
        }
    }

    // Obtener uno por ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT h.*, c.paciente_id 
                                         FROM g2_historial_medico_usuario h
                                         JOIN g2_citas c ON h.cita_id = c.id
                                         WHERE h.id = ?;");
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new HistorialMedicoUsuario(
                    $row['id'],
                    $row['paciente_id'],
                    $row['cita_id'],
                    $row['descripcion'],
                    $row['observaciones'],
                    $row['fecha']
                );
            }

            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Insertar nuevo registro (paciente_id no se guarda porque se obtiene desde la cita)
    public function insertar(HistorialMedicoUsuario $objeto) {
        try {
            $sql = "INSERT INTO g2_historial_medico_usuario (cita_id, descripcion, observaciones, fecha) VALUES (?, ?, ?, ?);";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->cita_id,
                $objeto->descripcion,
                $objeto->observaciones,
                $objeto->fecha
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Eliminar por id
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM g2_historial_medico_usuario WHERE id = ?;";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
