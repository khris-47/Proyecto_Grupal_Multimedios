<?php

require_once __DIR__ . '/../accessData/AuditoriaDoctorDAO.php';
require_once __DIR__ . '/../model/AuditoriaDoctor.php';

class AuditoriaDoctorController {
    private $dao;

    public function __construct() {
        $this->dao = new AuditoriaDoctorDAO();
    }

    // 🔍 Obtener todas las auditorías de doctores
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    // 🔍 Obtener una auditoría específica por ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }
}

?>
