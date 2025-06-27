<?php

require_once __DIR__ . '/../accessData/DoctorDAO.php';
require_once __DIR__ . '/../model/Doctor.php';

class DoctorController
{
    private $dao;

    public function __construct()
    {
        $this->dao = new DoctorDAO();
    }

    public function obtenerTodos()
    {
        return $this->dao->obtenerTodos();
    }

    public function obtenerPorId($id)
    {
        return $this->dao->obtenerPorId($id);
    }

    public function insertar($datos)
    {
        $camposRequeridos = ['nombre', 'telefono', 'email', 'password', 'id_rol', 'departamento_id'];
        foreach ($camposRequeridos as $campo) {
            if (empty($datos[$campo])) {
                throw new Exception("Falta el campo obligatorio: $campo");
            }
        }

        $passwordHasheada = hash('sha256', $datos['password']);

        $estado = isset($datos['estado']) ? $datos['estado'] : 'activo';
        $categorias = isset($datos['categorias']) ? $datos['categorias'] : [];

        $doctor = new Doctor(
            null,
            $datos['nombre'],
            $datos['telefono'],
            $datos['email'],
            $passwordHasheada,
            $datos['id_rol'],
            $datos['departamento_id'],
            $estado
        );

        // Asignar categorías al objeto Doctor
        $doctor->categorias = $categorias;

        return $this->dao->insertar($doctor);
    }

    public function actualizar($id, $datos)
    {
        $doctor = $this->dao->obtenerPorId($id);
        if (!$doctor) {
            throw new Exception("Doctor no encontrado.");
        }

        if (!empty($datos['nombre']))
            $doctor->nombre = $datos['nombre'];
        if (!empty($datos['telefono']))
            $doctor->telefono = $datos['telefono'];
        if (!empty($datos['email']))
            $doctor->email = $datos['email'];
        if (!empty($datos['password']))
            $doctor->password = hash('sha256', $datos['password']);
        if (isset($datos['id_rol']))
            $doctor->id_rol = $datos['id_rol'];
        if (isset($datos['departamento_id']))
            $doctor->departamento_id = $datos['departamento_id'];
        if (isset($datos['estado']))
            $doctor->estado = $datos['estado'];

        return $this->dao->actualizar($doctor);
    }

    public function eliminar($id)
    {
        $doctor = $this->obtenerPorId($id);
        if (!$doctor) {
            throw new Exception("No existe un doctor con este id.");
        }

        return $this->dao->eliminar($id);
    }

    public function autenticar($email, $password)
    {
        $doctor = $this->dao->obtenerPorEmail($email);

        if (!$doctor) {
            return null;
        }

        if (hash('sha256', $password) === $doctor->password) {
            return $doctor;
        }

        return null;
    }

    public function obtenerCategoriasPorDoctorId($doctorId)
    {
        return $this->dao->obtenerCategoriasPorDoctorId($doctorId);
    }
    public function obtenerTodosConCategorias()
    {
        return $this->dao->obtenerTodosConCategorias();
    }

}
