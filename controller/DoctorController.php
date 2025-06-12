<?php

require_once __DIR__ . '/../accessData/DoctorDAO.php'; // Incluye el DAO de doctores
require_once __DIR__ . '/../model/Doctor.php';  // Incluye el modelo Doctor

class DoctorController {
    private $dao; // Propiedad para acceder al DAO

    public function __construct() {
        $this->dao = new DoctorDAO(); // Instancia del DAO
    }

    // 🔍 Obtener todos los doctores
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    // 🔍 Obtener un doctor por ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    // ➕ Insertar un nuevo doctor
    public function insertar($datos) {
        // Validación de datos
        if (empty($datos['nombre']) || empty($datos['correo']) || empty($datos['telefono'])) {
            throw new Exception("Faltan datos obligatorios.");
        }

        // Crear instancia de Doctor
        $doctor = new Doctor(
            null, // ID nulo porque será autoincremental
            $datos['nombre'],
            $datos['correo'],
            $datos['telefono']
        );

        return $this->dao->insertar($doctor);
    }

    // ✏️ Actualizar un doctor existente
    public function actualizar($id, $datos) {
        $doctor = $this->dao->obtenerPorId($id);
        if (!$doctor) {
            throw new Exception("Doctor no encontrado.");
        }

        // Actualización de datos si existen
        if (!empty($datos['nombre'])) $doctor->nombre = $datos['nombre'];
        if (!empty($datos['correo'])) $doctor->correo = $datos['correo'];
        if (!empty($datos['telefono'])) $doctor->telefono = $datos['telefono'];

        return $this->dao->actualizar($doctor);
    }

    // 🗑️ Eliminar un doctor por ID
    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

?>
