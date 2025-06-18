<?php

require_once __DIR__ . '/../accessData/CategoriasDoctoresDAO.php';
require_once __DIR__ . '/../model/CategoriaDoctor.php';

class CategoriaDoctorController {
    private $dao;

    public function __construct() {
        $this->dao = new CategoriasDoctoresDAO();
    }

    //  Obtener todas las relaciones doctor-categoría
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    //  Obtener una relación específica por ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    //  Insertar una nueva relación
    public function insertar($datos) {
        if (empty($datos['doctor_id']) || empty($datos['categoria_id'])) {
            throw new Exception("Faltan datos obligatorios.");
        }

        $categoriaDoctor = new CategoriaDoctor(null, $datos['doctor_id'], $datos['categoria_id']);
        return $this->dao->insertar($categoriaDoctor);
    }

    //  Actualizar una relación existente
    public function actualizar($id, $datos) {
        $categoriaDoctor = $this->dao->obtenerPorId($id);
        if (!$categoriaDoctor) {
            throw new Exception("Relación no encontrada.");
        }

        if (!empty($datos['doctor_id'])) {
            $categoriaDoctor->doctor_id = $datos['doctor_id'];
        }
        if (!empty($datos['categoria_id'])) {
            $categoriaDoctor->categoria_id = $datos['categoria_id'];
        }

        return $this->dao->actualizar($categoriaDoctor);
    }

    //  Eliminar una relación por ID
    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

?>
