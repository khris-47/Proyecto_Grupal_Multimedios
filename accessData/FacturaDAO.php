<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/Factura.php';

class FacturaDAO {

    public $pdo;

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
                $row['fecha'],
                $row['total'],
                $row['usuario_id']
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
                $row['fecha'],
                $row['total'],
                $row['usuario_id']
            );
        }

        return null;
    }

    // Insertar nueva factura
   public function insertar(Factura $objeto) {
    $sql = "INSERT INTO g2_facturas (usuario_id, fecha, total) VALUES (?, ?, ?);";
    $stmt = $this->pdo->prepare($sql);
    $success = $stmt->execute([
        $objeto->usuario_id,
        $objeto->fecha,
        $objeto->total
    ]);
    if ($success) {
        return $this->pdo->lastInsertId();  // Devuelve el id insertado
    }
    return false;
}


    // Actualizar factura existente
    public function actualizar(Factura $objeto) {
        $sql = "UPDATE g2_facturas SET  fecha = ?, total = ?, usuario_id = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->fecha,
            $objeto->total,
            $objeto->usuario_id,
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
