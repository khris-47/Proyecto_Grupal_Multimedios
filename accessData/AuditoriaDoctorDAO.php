<?php

require_once __DIR__.'/../misc/Conexion.php';
require_once __DIR__.'/../model/AuditoriaDoctor.php';

class AuditoriaDoctorDAO {
    private $pdo;

    public function __construct(){
        $this->pdo = Conexion::conectar();
    }

    // Obtener todas las auditorías
    public function obtenerTodos(){
        $stmt = $this->pdo->query("SELECT * FROM g2_auditoria_doctores ORDER BY fecha DESC;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new AuditoriaDoctor(
                $row['id'],
                $row['doctor_id'],
                $row['accion'],
                $row['realizada_por'],
                $row['detalle'],       // ← AÑADIDO
                $row['fecha']
            );
        }

        return $resultado;
    }

    // Obtener auditoría por ID
    public function obtenerPorId($id){
        $stmt = $this->pdo->prepare("SELECT * FROM g2_auditoria_doctores WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new AuditoriaDoctor(
                $row['id'],
                $row['doctor_id'],
                $row['accion'],
                $row['realizada_por'],
                $row['detalle'],       // ← AÑADIDO
                $row['fecha']
            );
        }

        return null;
    }
}
?>
