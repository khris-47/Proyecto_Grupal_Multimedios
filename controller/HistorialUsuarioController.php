<?php

// Requerimos el archivo que contiene el DAO (Data Access Object) para manejar la base de datos
require_once __DIR__ . '/../accessData/HistorialMedicoUsuarioDAO.php';

// Requerimos el modelo que representa un historial médico de usuario
require_once __DIR__ . '/../model/HistorialMedicoUsuario.php';

// Esta clase actúa como el "intermediario" entre la API y el DAO. Aquí va la lógica del negocio.
class HistorialUsuarioController {

    // Atributo privado que guarda la instancia del DAO (acceso a la base de datos)
    private $dao;

    // Constructor: crea una nueva instancia del DAO cuando se inicializa este controlador
    public function __construct() {
        $this->dao = new HistorialMedicoUsuarioDAO(); // El DAO se conecta con la BD
    }

    // Método que devuelve todos los historiales médicos almacenados
    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }

    // Método que busca y devuelve un historial médico específico por su ID
    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    // Método para insertar un nuevo historial médico en la base de datos
    public function insertar($datos) {
        // Validamos que no falten datos obligatorios
        if (empty($datos['cita_id']) || empty($datos['descripcion']) || empty($datos['observaciones']) || empty($datos['fecha'])) {
            throw new Exception("Faltan datos obligatorios.");
        }

        // Creamos una nueva instancia del modelo con los datos recibidos (el ID es nulo porque se autogenera)
        $historial = new HistorialMedicoUsuario(
            null, // El ID se asignará automáticamente en la base de datos
            $datos['cita_id'],
            $datos['descripcion'],
            $datos['observaciones'],
            $datos['fecha']
        );

        // Llamamos al DAO para insertar el historial en la base de datos
        return $this->dao->insertar($historial);
    }
    


    // 🗑️ Método para eliminar un historial médico por su ID
    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

?>
