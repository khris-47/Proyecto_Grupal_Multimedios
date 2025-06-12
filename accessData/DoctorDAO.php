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
        $stmt = $this->pdo->query("SELECT * FROM B86781_doctores;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new Doctor(
                $row['id'],
                $row['nombre'],
                $row['correo'],
                $row['telefono']
            );
        }

        return $resultado;
    }

    // Obtener doctor por ID
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM B86781_doctores WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Doctor(
                $row['id'],
                $row['nombre'],
                $row['correo'],
                $row['telefono']
            );
        }

        return null;
    }

    // Insertar nuevo doctor
    public function insertar(Doctor $objeto) {
        $sql = "INSERT INTO B86781_doctores (nombre, correo, telefono) VALUES (?, ?, ?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->nombre,
            $objeto->correo,
            $objeto->telefono
        ]);
    }

    // Actualizar doctor existente
    public function actualizar(Doctor $objeto) {
        $sql = "UPDATE B86781_doctores SET nombre = ?, correo = ?, telefono = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->nombre,
            $objeto->correo,
            $objeto->telefono,
            $objeto->id
        ]);
    }

    // Eliminar doctor
    public function eliminar($id) {
        $sql = "DELETE FROM B86781_doctores WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>
