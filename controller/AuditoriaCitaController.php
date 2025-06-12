<?php

require_once __DIR__ . '/../accessData/AuditoriaCitasDAO.php';
require_once __DIR__ . '/../model/AuditoriaCita.php';

class AuditoriaCitaController {
    private $dao;

    public function __construct() {
        $this->dao = new AuditoriaCitasDAO();
    }

    // 🔍 Obtener todas las auditorías
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    // 🔍 Obtener una auditoría por ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }
}

?>
