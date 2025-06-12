<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/HistorialUsuario.php';

class HistorialUsuarioDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los registros
    public function obtenerTodos() {
        $stmt = $this->pdo->query("select * from B86781_historial_usuario;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new HistorialUsuario(
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
        $stmt = $this->pdo->prepare("select * from B86781_historial_usuario where id = ?;");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new HistorialUsuario(
                $row['id'],
                $row['cita_id'],
                $row['descripcion'],
                $row['observaciones'],
                $row['fecha']
            );
        }

        return null;
    }

    // Insertar (solo si no es por trigger; en caso necesario)
    public function insertar(HistorialUsuario $objeto) {
        $sql = "insert into B86781_historial_usuario (cita_id, descripcion, observaciones) values (?, ?, ?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->cita_id,
            $objeto->descripcion,
            $objeto->observaciones
        ]);
    }
}

?>
