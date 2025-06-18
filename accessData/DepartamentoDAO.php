<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/Departamento.php';

class DepartamentoDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los departamentos
    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM g2_departamentos ORDER BY nombre;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new Departamento(
                $row['id'],
                $row['nombre']
            );
        }

        return $resultado;
    }

    // Obtener departamento por ID
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_departamentos WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Departamento(
                $row['id'],
                $row['nombre']
            );
        }

        return null;
    }

    // Insertar nuevo departamento
    public function insertar(Departamento $objeto) {
        $sql = "INSERT INTO g2_departamentos (nombre) VALUES (?);";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$objeto->nombre]);
    }

    // Actualizar departamento
    public function actualizar(Departamento $objeto) {
        $sql = "UPDATE g2_departamentos SET nombre = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$objeto->nombre, $objeto->id]);
    }

    // Eliminar departamento
    public function eliminar($id) {
        $sql = "DELETE FROM g2_departamentos WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>
