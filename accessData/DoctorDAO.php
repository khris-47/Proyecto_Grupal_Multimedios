<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/Doctor.php';

class DoctorDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los doctores (sin importar estado)
    public function obtenerTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM g2_doctores;");
        $resultado = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = new Doctor(
                $row['id'],
                $row['nombre'],
                $row['telefono'],
                $row['email'],
                $row['password'],
                $row['id_rol'],
                $row['departamento_id'],
                $row['estado']
            );
        }

        return $resultado;
    }

    // Obtener doctor por ID
    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_doctores WHERE id = ?;");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Doctor(
                $row['id'],
                $row['nombre'],
                $row['telefono'],
                $row['email'],
                $row['password'],
                $row['id_rol'],
                $row['departamento_id'],
                $row['estado']
            );
        }

        return null;
    }

    // Insertar nuevo doctor con categorías
    public function insertar(Doctor $objeto)
    {
        $sql = "INSERT INTO g2_doctores (nombre, telefono, email, password, id_rol, departamento_id, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $objeto->nombre,
            $objeto->telefono,
            $objeto->email,
            $objeto->password,
            $objeto->id_rol,
            $objeto->departamento_id,
            $objeto->estado ?? 'activo'
        ]);

        $doctorId = $this->pdo->lastInsertId();

        // Insertar relaciones con categorías
        if (!empty($objeto->categorias) && is_array($objeto->categorias)) {
            foreach ($objeto->categorias as $categoriaId) {
                $stmtCat = $this->pdo->prepare("INSERT INTO g2_categorias_doctores (doctor_id, categoria_id) VALUES (?, ?)");
                $stmtCat->execute([$doctorId, $categoriaId]);
            }
        }

        return true;
    }

    // Actualizar doctor existente
    public function actualizar(Doctor $objeto)
    {
        $sql = "UPDATE g2_doctores 
                SET nombre = ?, telefono = ?, email = ?, password = ?, id_rol = ?, departamento_id = ?, estado = ?
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $objeto->nombre,
            $objeto->telefono,
            $objeto->email,
            $objeto->password,
            $objeto->id_rol,
            $objeto->departamento_id,
            $objeto->estado,
            $objeto->id
        ]);
    }

    // Eliminar doctor lógicamente (estado = 'inactivo')
    public function eliminar($id)
    {
        $sql = "UPDATE g2_doctores SET estado = 'inactivo' WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Buscar doctor por email (para login)
    public function obtenerPorEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM g2_doctores WHERE email = ?;");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Doctor(
                $row['id'],
                $row['nombre'],
                $row['telefono'],
                $row['email'],
                $row['password'],
                $row['id_rol'],
                $row['departamento_id'],
                $row['estado']
            );
        }

        return null;
    }

    public function obtenerCategoriasPorDoctorId($doctorId)
    {
        $sql = "SELECT c.id, c.nombre
            FROM g2_categorias c
            INNER JOIN g2_categorias_doctores cd ON c.id = cd.categoria_id
            WHERE cd.doctor_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$doctorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenerTodosConCategorias()
    {
        $doctores = $this->obtenerTodos();  // Reusa método existente
        foreach ($doctores as $doctor) {
            $doctor->categorias = $this->obtenerCategoriasPorDoctorId($doctor->id);
        }
        return $doctores;
    }

}
