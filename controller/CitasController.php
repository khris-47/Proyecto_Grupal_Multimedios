<?php

require_once __DIR__ . '/../accessData/CitaDAO.php';
require_once __DIR__ . '/../model/Cita.php';

class CitasController {
    private $dao;

    public function __construct() {
        $this->dao = new CitaDAO();
    }

    // 🔍 Obtener todas las citas
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    // 🔍 Obtener una cita por ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    // ➕ Insertar una nueva cita
    public function insertar($datos) {
        if (empty($datos['paciente_id']) || empty($datos['doctor_id']) || empty($datos['fecha'])) {
            throw new Exception("Faltan datos obligatorios.");
        }

        $cita = new Cita(null, $datos['paciente_id'], $datos['doctor_id'], $datos['fecha'], $datos['estado'] ?? 'en espera');
        return $this->dao->insertar($cita);
    }

    // ✏️ Actualizar una cita existente
    public function actualizar($id, $datos) {
        $cita = $this->dao->obtenerPorId($id);
        if (!$cita) {
            throw new Exception("Cita no encontrada.");
        }

        if (!empty($datos['paciente_id'])) {
            $cita->paciente_id = $datos['paciente_id'];
        }
        if (!empty($datos['doctor_id'])) {
            $cita->doctor_id = $datos['doctor_id'];
        }
        if (!empty($datos['fecha'])) {
            $cita->fecha = $datos['fecha'];
        }
        if (!empty($datos['estado'])) {
            $cita->estado = $datos['estado'];
        }

        return $this->dao->actualizar($cita);
    }

    // 🗑️ Eliminar una cita por ID
    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

?>
