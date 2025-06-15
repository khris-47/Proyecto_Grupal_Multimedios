<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/HistorialMedicoUsuario.php'; // <--- Nombre corregido

class HistorialMedicoUsuarioDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los registros
    public function obtenerTodos() {
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
    }

    // Obtener uno por ID
    public function obtenerPorId($id) {
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
    }

    // Insertar nuevo registro (si se usa fuera del trigger)
    public function insertar(HistorialMedicoUsuario $objeto) {
        $sql = "INSERT INTO g2_historial_medico_usuario (cita_id, descripcion, observaciones) VALUES (?, ?, ?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->cita_id,
            $objeto->descripcion,
            $objeto->observaciones
        ]);
    }
}

?>
