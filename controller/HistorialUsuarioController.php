<?php


require_once __DIR__ . '/../accessData/HistorialMedicoUsuarioDAO.php';
require_once __DIR__ . '/../model/HistorialMedicoUsuario.php';



class HistorialUsuarioController {


    private $dao;


    public function __construct() {
        $this->dao = new HistorialMedicoUsuarioDAO();
    }


    public function obtenerTodos() {
        return $this->dao->obtenerTodos();
    }


    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }
    public function obtenerPorPaciente($paciente_id) {
    return $this->dao->obtenerPorPaciente($paciente_id);
    
    }

    public function insertar($datos) {
        if (
            empty($datos['cita_id']) ||
            empty($datos['descripcion']) ||
            empty($datos['observaciones']) ||
            empty($datos['fecha'])
        ) {
            throw new Exception("Faltan datos obligatorios.");
        }

        // Obtener el paciente_id desde la tabla g2_citas
        $stmt = $this->dao->getPDO()->prepare("SELECT paciente_id FROM g2_citas WHERE id = ?");
        $stmt->execute([$datos['cita_id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new Exception("No se encontró la cita asociada.");
        }

        $paciente_id = $row['paciente_id'];

        $historial = new HistorialMedicoUsuario(
            null,
            $paciente_id,                // <--- este es el nuevo campo
            $datos['cita_id'],
            $datos['descripcion'],
            $datos['observaciones'],
            $datos['fecha']
        );

        return $this->dao->insertar($historial);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}
?>
