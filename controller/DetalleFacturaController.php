<?php

require_once __DIR__ . '/../accessData/DetalleFacturaDAO.php';
require_once __DIR__ . '/../model/DetalleFactura.php';

class DetalleFacturaController {
    private $dao;

    public function __construct() {
        $this->dao = new DetalleFacturaDAO();
    }

    // 🔍 Obtener todos los detalles de factura
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    // 🔍 Obtener un detalle por ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    // ➕ Insertar un nuevo detalle de factura
    public function insertar($datos) {
        if (empty($datos['factura_id']) || empty($datos['medicamento_id']) || empty($datos['cantidad']) || empty($datos['precio_unitario'])) {
            throw new Exception("Faltan datos obligatorios para el detalle de factura.");
        }

        $detalle = new DetalleFactura(
            null,
            $datos['factura_id'],
            $datos['medicamento_id'],
            $datos['cantidad'],
            $datos['precio_unitario']
        );

        return $this->dao->insertar($detalle);
    }

    // ✏️ Actualizar un detalle existente
    public function actualizar($id, $datos) {
        $detalle = $this->dao->obtenerPorId($id);
        if (!$detalle) {
            throw new Exception("Detalle de factura no encontrado.");
        }

        if (!empty($datos['factura_id'])) {
            $detalle->factura_id = $datos['factura_id'];
        }
        if (!empty($datos['medicamento_id'])) {
            $detalle->medicamento_id = $datos['medicamento_id'];
        }
        if (!empty($datos['cantidad'])) {
            $detalle->cantidad = $datos['cantidad'];
        }
        if (!empty($datos['precio_unitario'])) {
            $detalle->precio_unitario = $datos['precio_unitario'];
        }

        return $this->dao->actualizar($detalle);
    }

    // 🗑️ Eliminar un detalle por ID
    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

?>
