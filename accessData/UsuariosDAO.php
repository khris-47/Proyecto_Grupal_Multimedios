<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los usuarios
    public function obtenerTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM g2_usuarios;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new Usuario(
                $row['id'],
                $row['cedula'],
                $row['nombre'],
                $row['email'],
                $row['password'],
                $row['id_rol']
            );
        }

        return $resultado;
    }

    // Obtener usuario por ID
    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_usuarios WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Usuario(
                $row['id'],
                $row['cedula'],
                $row['nombre'],
                $row['email'],
                $row['password'],
                $row['id_rol']
            );
        }
        return null; // Usuario no encontrado
    }

    // Insertar nuevo usuario
    public function insertar(Usuario $usuario)
    {
        $sql = "INSERT INTO g2_usuarios (cedula, nombre, email, password, id_rol) VALUES (?, ?, ?, ?, ?);";
        $stmt = $this->pdo->prepare($sql);



        return $stmt->execute([
            $usuario->cedula,
            $usuario->nombre,
            $usuario->email,
            $usuario->password,
            $usuario->id_rol
        ]);
    }

    // Actualizar usuario
    public function actualizar(Usuario $usuario)
    {
        $sql = "UPDATE g2_usuarios SET cedula = ?, nombre = ?, email = ?, password = ?, id_rol = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $usuario->cedula,
            $usuario->nombre,
            $usuario->email,
            $usuario->password,
            $usuario->id_rol,
            $usuario->id
        ]);

    }

    // Eliminar usuario
    public function eliminar($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM g2_usuarios WHERE id = ?;");
        return $stmt->execute([$id]);
    }

    public function obtenerPorEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_usuarios WHERE email = ?;");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Usuario(
                $row['id'],
                $row['cedula'],
                $row['nombre'],
                $row['email'],
                $row['password'],
                $row['id_rol']
            );
        }
        return null;
    }

}



?>