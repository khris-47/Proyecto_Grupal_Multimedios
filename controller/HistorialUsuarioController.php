<?php

require_once __DIR__ . '/../accessData/HistorialUsuarioDAO.php';
require_once __DIR__ . '/../model/HistorialUsuario.php';

class HistorialUsuarioController {
    private $dao;

    public function __construct() {
        $this->dao = new HistorialUsuarioDAO();
    }

    // 🔍 Obtener todos los registros del historial
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    // 🔍 Obtener un historial específico por ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    // ➕ Insertar un nuevo historial
    public function insertar($datos) {
        if (empty($datos['cita_id']) || empty($datos['descripcion']) || empty($datos['observaciones']) || empty($datos['fecha'])) {
            throw new Exception("Faltan datos obligatorios.");
        }

        $historial = new HistorialUsuario(null, $datos['cita_id'], $datos['descripcion'], $datos['observaciones'], $datos['fecha']);
        return $this->dao->insertar($historial);
    }

    // ✏️ Actualizar un historial existente
    public function actualizar($id, $datos) {
        $historial = $this->dao->obtenerPorId($id);
        if (!$historial) {
            throw new Exception("Registro no encontrado.");
        }

        if (!empty($datos['cita_id'])) {
            $historial->cita_id = $datos['cita_id'];
        }
        if (!empty($datos['descripcion'])) {
            $historial->descripcion = $datos['descripcion'];
        }
        if (!empty($datos['observaciones'])) {
            $historial->observaciones = $datos['observaciones'];
        }
        if (!empty($datos['fecha'])) {
            $historial->fecha = $datos['fecha'];
        }

        return $this->dao->actualizar($historial);
    }

    // 🗑️ Eliminar un historial por ID
    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

?>
