<?php

require_once __DIR__ . '/../accessData/CategoriasDAO.php';
require_once __DIR__ . '/../model/Categoria.php';

class CategoriasController
{
    private $dao;

    public function __construct()
    {
        $this->dao = new CategoriasDAO();
    }

    // 🔍 Obtener todas las categorías
    public function obtenerTodos()
    {
        return $this->dao->obtenerTodos();
    }

    // 🔍 Obtener una categoría por ID
    public function obtenerPorId($id)
    {
        return $this->dao->obtenerPorId($id);
    }

    // ➕ Insertar una nueva categoría
    public function insertar($datos)
    {
        if (empty($datos['nombre'])) {
            throw new Exception("El nombre de la categoría es obligatorio.");
        }
        $estado = $datos['estado'] ?? 'activo';

        $categoria = new Categoria(null, $datos['nombre'], $estado);
        return $this->dao->insertar($categoria);
    }

    public function actualizar($id, $datos)
    {
        $categoria = $this->dao->obtenerPorId($id);
        if (!$categoria) {
            throw new Exception("Categoría no encontrada.");
        }

        // Mantener el nombre anterior si no se envía uno nuevo
        $categoria->nombre = $datos['nombre'] ?? $categoria->nombre;

        if (isset($datos['estado'])) {
            $categoria->estado = $datos['estado'];
        }

        return $this->dao->actualizar($categoria);
    }


    // 🗑️ Eliminar una categoría por ID
    public function eliminar($id)
    {
        return $this->dao->eliminar($id);
    }
}

?>