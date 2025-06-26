<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/Rol.php';

class RolDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los roles
    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM g2_rol;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new Rol(
                $row['id_rol'],
                $row['nombre']
            );
        }

        return $resultado;
    }

    // Insertar un nuevo rol
    public function insertar(Rol $objeto) {
        $sql = "INSERT INTO g2_rol (nombre) VALUES (?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$objeto->nombre]);
    }

    // Actualizar un rol existente
    public function actualizar(Rol $objeto) {
        $sql = "UPDATE g2_rol SET nombre = ? WHERE id_rol = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$objeto->nombre, $objeto->id]);
    }

    // Eliminar un rol por ID
    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM g2_rol WHERE id_rol = ?;");
        return $stmt->execute([$id]);
    }
}

?>
