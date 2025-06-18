<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/HistorialMedicoUsuario.php';

class HistorialMedicoUsuarioDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los registros
    public function obtenerTodos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM g2_historial_medico_usuario;");
            $resultado = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultado[] = new HistorialMedicoUsuario(
                    $row['id'],
                    $row['cita_id'],
                    $row['descripcion'],
                    $row['observaciones'],
                    $row['fecha']
                );
            }

            return $resultado;
        } catch (PDOException $e) {
            return []; // se puede cambiar por null como los demás
        }
    }

    // Obtener uno por ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM g2_historial_medico_usuario WHERE id = ?;");
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new HistorialMedicoUsuario(
                    $row['id'],
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

    // Insertar nuevo registro
    public function insertar(HistorialMedicoUsuario $objeto) {
        try {
            $sql = "INSERT INTO g2_historial_medico_usuario (cita_id, descripcion, observaciones) VALUES (?, ?, ?);";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->cita_id,
                $objeto->descripcion,
                $objeto->observaciones
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
