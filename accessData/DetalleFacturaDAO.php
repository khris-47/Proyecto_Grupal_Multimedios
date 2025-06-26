<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/DetalleFactura.php';

class DetalleFacturaDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los detalles de factura
    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM g2_detalle_factura;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new DetalleFactura(
                $row['id'],
                $row['factura_id'],
                $row['medicamento_id'],
                $row['cantidad'],
                $row['precio_unitario']
            );
        }

        return $resultado;
    }

    // Obtener detalle por ID
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_detalle_factura WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new DetalleFactura(
                $row['id'],
                $row['factura_id'],
                $row['medicamento_id'],
                $row['cantidad'],
                $row['precio_unitario']
            );
        }

        return null;
    }

    // Insertar nuevo detalle
    public function insertar(DetalleFactura $objeto) {
        $sql = "INSERT INTO g2_detalle_factura (factura_id, medicamento_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->factura_id,
            $objeto->medicamento_id,
            $objeto->cantidad,
            $objeto->precio_unitario
        ]);
    }

    // Actualizar detalle existente
    public function actualizar(DetalleFactura $objeto) {
        $sql = "UPDATE g2_detalle_factura SET factura_id = ?, medicamento_id = ?, cantidad = ?, precio_unitario = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->factura_id,
            $objeto->medicamento_id,
            $objeto->cantidad,
            $objeto->precio_unitario,
            $objeto->id
        ]);
    }

    // Eliminar detalle por ID
    public function eliminar($id) {
        $sql = "DELETE FROM g2_detalle_factura WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>
