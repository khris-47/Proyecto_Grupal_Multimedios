<?php

require_once __DIR__ . '/../accessData/HistorialMedicoUsuarioDAO.php';
require_once __DIR__ . '/../model/HistorialMedicoUsuario.php';

class HistorialUsuarioController {
    private $dao;

    public function __construct() {
        $this->dao = new HistorialMedicoUsuarioDAO();  // nombre correcto del DAO
    }

    // Obtener todos los registros del historial
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    // Obtener un historial específico por ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    // Insertar un nuevo historial
    public function insertar($datos) {
        if (empty($datos['cita_id']) || empty($datos['descripcion']) || empty($datos['observaciones']) || empty($datos['fecha'])) {
            throw new Exception("Faltan datos obligatorios.");
        }

        $historial = new HistorialMedicoUsuario(
            null, // id nulo para insertar
            $datos['cita_id'],
            $datos['descripcion'],
            $datos['observaciones'],
            $datos['fecha']
        );

        return $this->dao->insertar($historial);
    }


}

?>
