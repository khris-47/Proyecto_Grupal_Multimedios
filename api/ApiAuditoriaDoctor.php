<?php

require_once __DIR__ . '/../controller/AuditoriaDoctorController.php';

class ApiAuditoriaDoctor {
    private $controller;

    public function __construct() {
        $this->controller = new AuditoriaDoctorController();
    }

    public function manejarPeticiones() {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $auditoria = $this->controller->obtenerPorId($id);

                    if ($auditoria) {
                        echo json_encode($auditoria);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Registro de auditoría no encontrado']);
                    }
                } else {
                    echo json_encode($this->controller->obtenerTodos());
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no soportado']);
                break;
        }
    }
}

// Crear instancia y ejecutar manejo de peticiones
$api = new ApiAuditoriaDoctor();
$api->manejarPeticiones();

?>
