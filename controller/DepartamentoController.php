<?php

require_once __DIR__ . '/../accessData/DepartamentoDAO.php';
require_once __DIR__ . '/../model/Departamento.php';

class DepartamentoController {
    private $dao;

    public function __construct() {
        $this->dao = new DepartamentoDAO();
    }

    // 🔍 Obtener todos los departamentos
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    // 🔍 Obtener un departamento por ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    // ➕ Insertar un nuevo departamento
    public function insertar($datos) {
        if (empty($datos['nombre'])) {
            throw new Exception("El nombre del departamento es obligatorio.");
        }

        $departamento = new Departamento(null, $datos['nombre']);
        return $this->dao->insertar($departamento);
    }

    // ✏️ Actualizar un departamento existente
    public function actualizar($id, $datos) {
        $departamento = $this->dao->obtenerPorId($id);
        if (!$departamento) {
            throw new Exception("Departamento no encontrado.");
        }

        if (!empty($datos['nombre'])) {
            $departamento->nombre = $datos['nombre'];
        }

        return $this->dao->actualizar($departamento);
    }

    // 🗑️ Eliminar un departamento por ID
    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

?>
