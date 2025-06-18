<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/AuditoriaCita.php';

class AuditoriaCitasDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los registros
    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM g2_auditoria_citas ORDER BY fecha DESC;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new AuditoriaCita(
                $row['id'],
                $row['cita_id'],
                $row['accion'],
                $row['realizada_por'],
                $row['detalle'],        // <-- AÑADIDO
                $row['fecha']
            );
        }

        return $resultado;
    }

    // Obtener uno por ID
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_auditoria_citas WHERE id = ?;");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new AuditoriaCita(
                $row['id'],
                $row['cita_id'],
                $row['accion'],
                $row['realizada_por'],
                $row['detalle'],        // <-- AÑADIDO
                $row['fecha']
            );
        }

        return null;
    }
    
}

?>
