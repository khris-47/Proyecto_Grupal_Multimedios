<?php

require_once __DIR__ . '/../accessData/DoctorDAO.php'; // Incluye el DAO de doctores
require_once __DIR__ . '/../model/Doctor.php';  // Incluye el modelo Doctor

class DoctorController
{
    private $dao; // Propiedad para acceder al DAO

    public function __construct()
    {
        $this->dao = new DoctorDAO(); // Instancia del DAO
    }

    //  Obtener todos los doctores
    public function obtenerTodos()
    {
        return $this->dao->obtenerTodos();
    }

    //  Obtener un doctor por ID
    public function obtenerPorId($id)
    {
        return $this->dao->obtenerPorId($id);
    }

    // Insertar un nuevo doctor
    public function insertar($datos)
    {
        // Validación básica
        $camposRequeridos = ['nombre', 'correo', 'telefono', 'email', 'password', 'id_rol', 'departamento_id'];
        foreach ($camposRequeridos as $campo) {
            if (empty($datos[$campo])) {
                throw new Exception("Falta el campo obligatorio: $campo");
            }
        }

        // Hashear la contraseña antes de guardar
        $passwordHasheada = hash('sha256', $datos['password']);

        // Crear instancia de Doctor con todos los campos
        $doctor = new Doctor(
            null, // ID nulo para insertar (autoincremental)
            $datos['nombre'],
            $datos['correo'],
            $datos['telefono'],
            $datos['email'],
            $passwordHasheada,
            $datos['id_rol'],
            $datos['departamento_id']
        );

        return $this->dao->insertar($doctor);
    }

    // Actualizar un doctor existente
    public function actualizar($id, $datos)
    {
        $doctor = $this->dao->obtenerPorId($id);
        if (!$doctor) {
            throw new Exception("Doctor no encontrado.");
        }

        if (!empty($datos['nombre']))
            $doctor->nombre = $datos['nombre'];
        if (!empty($datos['correo']))
            $doctor->correo = $datos['correo'];
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

        return $this->dao->actualizar($doctor);
    }

    // Eliminar un doctor por ID
    public function eliminar($id)
    {
        $doctor = $this->obtenerPorId($id);
        if (!$doctor) {
            throw new Exception("No existe un doctor con este id.");
        }

        return $this->dao->eliminar($id);
    }


    // Método para autenticar un doctor
    public function autenticar($email, $password)
    {
        // Obtener el doctor por su email
        $doctor = $this->dao->obtenerPorEmail($email);

        // Si no existe un doctor con ese correo, retornar null
        if (!$doctor) {
            return null;
        }

        // Verificar que la contraseña hasheada coincida
        if (hash('sha256', $password) === $doctor->password) {
            return $doctor;
        }

        // Si la contraseña no coincide
        return null;
    }


}

?>