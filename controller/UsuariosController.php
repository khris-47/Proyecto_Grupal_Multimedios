<?php

// Incluimos el DAO que maneja la conexión y las consultas a la base de datos
require_once __DIR__ . '/../accessData/UsuariosDAO.php';

class UsuarioController
{
    // Propiedad que almacenará la instancia del DAO
    private $dao;

    // Constructor: instancia el DAO para usarlo en los métodos
    public function __construct()
    {
        $this->dao = new UsuarioDAO();
    }

    // Método para obtener todos los usuarios
    public function obtenerTodos()
    {
        return $this->dao->obtenerTodos();
    }

    // Método para obtener un usuario por su ID
    public function obtenerPorId($id)
    {
        return $this->dao->obtenerPorId($id);
    }

    // Método para insertar un nuevo usuario
    // Recibe un array asociativo con datos de usuario
    public function insertar($datos)
    {
        // Validación básica (puedes mejorarla)
        if (empty($datos['cedula']) || empty($datos['nombre']) || empty($datos['email']) || empty($datos['password'])) {
            throw new Exception("Faltan datos obligatorios para crear usuario.");
        }

        // Hashear la contraseña antes de guardarla por seguridad
       $passwordHasheada = hash('sha256', $datos['password']);

        // Crear un nuevo objeto Usuario con los datos recibidos
        $usuario = new Usuario(
            null, // id nulo para insertar (autoincremental)
            $datos['cedula'],
            $datos['nombre'],
            $datos['email'],
            $passwordHasheada,
            $datos['id_rol'] ?? 3 // asignamos un rol por defecto (3 = paciente)
        );

        // Llamar al DAO para insertar en la base de datos
        return $this->dao->insertar($usuario);
    }

    // Método para actualizar un usuario existente
    // $id es el id del usuario a modificar, $datos es un array con los nuevos datos
    public function actualizar($id, $datos)
    {
        // Buscar usuario existente
        $usuario = $this->dao->obtenerPorId($id);

        if (!$usuario) {
            throw new Exception("Usuario no encontrado para actualizar.");
        }

        // Actualizar los atributos con los datos recibidos, si existen
        if (!empty($datos['cedula']))
            $usuario->cedula = $datos['cedula'];
        if (!empty($datos['nombre']))
            $usuario->nombre = $datos['nombre'];
        if (!empty($datos['email']))
            $usuario->email = $datos['email'];

        // Si se envió una nueva contraseña, hashearla antes de guardar
        if (!empty($datos['password'])) {
            $usuario->password = hash('sha256', $datos['password']);
        }

        // Actualizar rol si se envió (opcional)
        if (isset($datos['id_rol'])) {
            $usuario->id_rol = $datos['id_rol'];
        }

        // Llamar al DAO para guardar los cambios
        return $this->dao->actualizar($usuario);
    }

    // Método para eliminar un usuario por su ID
    public function eliminar($id)
    {
        // Opcional: aquí podrías validar permisos antes de eliminar
        return $this->dao->eliminar($id);
    }

    // Método para autenticar un usuario (login)
    public function autenticar($email, $password)
    {
        // Obtenemos el usuario por email
        $usuario = $this->dao->obtenerPorEmail($email);

        // Si no existe usuario con ese email, retornar null
        if (!$usuario) {
            return null;
        }

        // Verificar que la contraseña proporcionada coincida con la almacenada (hasheada)
        if (hash('sha256', $password) === $usuario->password) {
            return $usuario;
        }

        // Contraseña incorrecta
        return null;
    }
}

?>