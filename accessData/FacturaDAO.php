<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/Factura.php';

class FacturaDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todas las facturas
    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM g2_facturas ORDER BY fecha DESC;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new Factura(
                $row['id'],
                $row['cita_id'],
                $row['fecha'],
                $row['total']
            );
        }

        return $resultado;
    }

    // Obtener factura por ID
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_facturas WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Factura(
                $row['id'],
                $row['cita_id'],
                $row['fecha'],
                $row['total']
            );
        }

        return null;
    }

    // Insertar nueva factura
    public function insertar(Factura $objeto) {
        $sql = "INSERT INTO g2_facturas (cita_id, fecha, total) VALUES (?, ?, ?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->cita_id,
            $objeto->fecha,
            $objeto->total
        ]);
    }

    // Actualizar factura existente
    public function actualizar(Factura $objeto) {
        $sql = "UPDATE g2_facturas SET cita_id = ?, fecha = ?, total = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->cita_id,
            $objeto->fecha,
            $objeto->total,
            $objeto->id
        ]);
    }

    // Eliminar factura
    public function eliminar($id) {
        $sql = "DELETE FROM g2_facturas WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>
