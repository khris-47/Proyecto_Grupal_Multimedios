<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/Doctor.php';

class DoctorDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los doctores
    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM g2_doctores;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new Doctor(
                $row['id'],
                $row['nombre'],
                $row['correo'],
                $row['telefono'],
                $row['email'],
                $row['password'],
                $row['id_rol'],
                $row['departamento_id']
            );
        }

        return $resultado;
    }

    // Obtener doctor por ID
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_doctores WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Doctor(
                $row['id'],
                $row['nombre'],
                $row['correo'],
                $row['telefono'],
                $row['email'],
                $row['password'],
                $row['id_rol'],
                $row['departamento_id']
            );
        }

        return null;
    }

    // Insertar nuevo doctor
    public function insertar(Doctor $objeto) {
        $sql = "INSERT INTO g2_doctores (nombre, correo, telefono, email, password, id_rol, departamento_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->nombre,
            $objeto->correo,
            $objeto->telefono,
            $objeto->email,
            $objeto->password,
            $objeto->id_rol,
            $objeto->departamento_id
        ]);
    }

    // Actualizar doctor existente
    public function actualizar(Doctor $objeto) {
        $sql = "UPDATE g2_doctores 
                SET nombre = ?, correo = ?, telefono = ?, email = ?, password = ?, id_rol = ?, departamento_id = ?
                WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->nombre,
            $objeto->correo,
            $objeto->telefono,
            $objeto->email,
            $objeto->password,
            $objeto->id_rol,
            $objeto->departamento_id,
            $objeto->id
        ]);
    }

    // Eliminar doctor
    public function eliminar($id) {
        $sql = "DELETE FROM g2_doctores WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Opcional: Buscar doctor por email (por ejemplo, para login)
    public function obtenerPorEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_doctores WHERE email = ?;");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Doctor(
                $row['id'],
                $row['nombre'],
                $row['correo'],
                $row['telefono'],
                $row['email'],
                $row['password'],
                $row['id_rol'],
                $row['departamento_id']
            );
        }

        return null;
    }
    
}
?>
