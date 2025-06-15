<?php

require_once __DIR__ . '/../accessData/FacturaDAO.php';
require_once __DIR__ . '/../model/Factura.php';

class FacturaController {
    private $dao;

    public function __construct() {
        $this->dao = new FacturaDAO();
    }

    // 🔍 Obtener todas las facturas
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    // 🔍 Obtener una factura por ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    // ➕ Insertar una nueva factura
    public function insertar($datos) {
        if (empty($datos['cita_id']) || empty($datos['fecha']) || !isset($datos['total'])) {
            throw new Exception("Faltan datos obligatorios.");
        }

        $factura = new Factura(
            null,
            $datos['cita_id'],
            $datos['fecha'],
            $datos['total']
        );

        return $this->dao->insertar($factura);
    }

    // ✏️ Actualizar una factura existente
    public function actualizar($id, $datos) {
        $factura = $this->dao->obtenerPorId($id);
        if (!$factura) {
            throw new Exception("Factura no encontrada.");
        }

        if (!empty($datos['cita_id'])) {
            $factura->cita_id = $datos['cita_id'];
        }
        if (!empty($datos['fecha'])) {
            $factura->fecha = $datos['fecha'];
        }
        if (isset($datos['total'])) {
            $factura->total = $datos['total'];
        }

        return $this->dao->actualizar($factura);
    }

    // 🗑️ Eliminar una factura por ID
    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

?>
