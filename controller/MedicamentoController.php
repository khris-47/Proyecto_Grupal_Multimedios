<?php

require_once __DIR__ . '/../accessData/MedicamentoDAO.php';
require_once __DIR__ . '/../model/Medicamento.php';

class MedicamentoController {
    private $dao;

    public function __construct() {
        $this->dao = new MedicamentoDAO();
    }

    // 🔍 Obtener todos los medicamentos
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    // 🔍 Obtener un medicamento por ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    // ➕ Insertar un nuevo medicamento
    public function insertar($datos) {
        if (empty($datos['nombre']) || empty($datos['descripcion'])) {
            throw new Exception("Faltan datos obligatorios.");
        }

        $medicamento = new Medicamento(
            null,
            $datos['nombre'],
            $datos['descripcion']
        );

        return $this->dao->insertar($medicamento);
    }

    // ✏️ Actualizar un medicamento existente
    public function actualizar($id, $datos) {
        $medicamento = $this->dao->obtenerPorId($id);
        if (!$medicamento) {
            throw new Exception("Medicamento no encontrado.");
        }

        if (!empty($datos['nombre'])) {
            $medicamento->nombre = $datos['nombre'];
        }
        if (!empty($datos['descripcion'])) {
            $medicamento->descripcion = $datos['descripcion'];
        }

        return $this->dao->actualizar($medicamento);
    }

    // 🗑️ Eliminar un medicamento por ID
    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

?>
