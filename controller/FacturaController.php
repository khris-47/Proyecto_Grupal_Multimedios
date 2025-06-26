<?php

require_once __DIR__ . '/../accessData/FacturaDAO.php';
require_once __DIR__ . '/../accessData/DetalleFacturaDAO.php';
require_once __DIR__ . '/../accessData/MedicamentoDAO.php';
require_once __DIR__ . '/../model/Factura.php';
require_once __DIR__ . '/../model/DetalleFactura.php';

class FacturaController {
    private $dao;
    private $detalleFacturaDao;
    private $medicamentoDao;

    public function __construct() {
        $this->dao = new FacturaDAO();
        $this->detalleFacturaDao = new DetalleFacturaDAO();
        $this->medicamentoDao = new MedicamentoDAO();
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

     public function crearFacturaConDetalle($datosFactura, $detalle) {
        // 1. Validar stock suficiente para cada medicamento
        foreach ($detalle as $item) {
            $medicamento = $this->medicamentoDao->obtenerPorId($item['medicamento_id']);
            if (!$medicamento) {
                throw new Exception("Medicamento ID {$item['medicamento_id']} no encontrado");
            }
            if ($medicamento->cantidad < $item['cantidad']) {
                throw new Exception("Stock insuficiente para medicamento ID {$item['medicamento_id']}");
            }
        }

        // 2. Insertar factura y obtener id
        $factura = new Factura(null, $datosFactura['usuario_id'], $datosFactura['fecha'], $datosFactura['total']);
        $facturaId = $this->dao->insertar($factura);
        if (!$facturaId) {
            throw new Exception("Error al insertar factura");
        }

        // 3. Insertar cada detalle y actualizar stock
        foreach ($detalle as $item) {
            $detalleFactura = new DetalleFactura(null, $facturaId, $item['medicamento_id'], $item['cantidad'], $item['precio_unitario']);
            $this->detalleFacturaDao->insertar($detalleFactura);

            // Actualizar stock
            $medicamento = $this->medicamentoDao->obtenerPorId($item['medicamento_id']);
            $medicamento->cantidad -= $item['cantidad'];
            $this->medicamentoDao->actualizar($medicamento);
        }

        return $facturaId;
    }


    // ✏️ Actualizar una factura existente
    public function actualizar($id, $datos) {
        $factura = $this->dao->obtenerPorId($id);
        if (!$factura) {
            throw new Exception("Factura no encontrada.");
        }
        if (!empty($datos['fecha'])) {
            $factura->fecha = $datos['fecha'];
        }
        if (isset($datos['total'])) {
            $factura->total = $datos['total'];
        }
        if (!empty($datos['usuario_id'])) {
            $factura->cita_id = $datos['usuario_id'];
        }

        return $this->dao->actualizar($factura);
    }

    // 🗑️ Eliminar una factura por ID
    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

?>
