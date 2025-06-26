<?php

// Permitir CORS para desarrollo
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT,  OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Responder a la petición OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../controller/CategoriaDoctorController.php';

class CategoriaDoctorAPIController
{
    private $controller;

    public function __construct()
    {
        $this->controller = new CategoriaDoctorController();
    }

    public function manejarPeticiones()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $categoriaDoctor = $this->controller->obtenerPorId($id);

                    if ($categoriaDoctor) {
                        echo json_encode($categoriaDoctor);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Relación no encontrada']);
                    }
                } else {
                    echo json_encode($this->controller->obtenerTodos());
                }
                break;

            case 'POST':
                $datos = json_decode(file_get_contents('php://input'), true);
                if (!$datos) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Datos JSON inválidos']);
                    exit;
                }

                try {
                    $resultado = $this->controller->insertar($datos);
                    if ($resultado) {
                        http_response_code(201);
                        echo json_encode(['mensaje' => 'Relación creada correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al insertar la relación']);
                    }
                } catch (Exception $e) {
                    http_response_code(400);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                parse_str(file_get_contents('php://input'), $put_vars);
                $datos = json_decode(file_get_contents('php://input'), true);

                $id = $_GET['id'] ?? ($datos['id'] ?? null);

                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta ID para actualizar']);
                    exit;
                }

                if (!$datos) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Datos JSON inválidos para actualizar']);
                    exit;
                }

                try {
                    $resultado = $this->controller->actualizar($id, $datos);
                    if ($resultado) {
                        echo json_encode(['mensaje' => 'Relación actualizada correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al actualizar la relación']);
                    }
                } catch (Exception $e) {
                    http_response_code(400);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                if (!isset($_GET['id'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta ID para eliminar']);
                    exit;
                }
                $id = $_GET['id'];

                try {
                    $resultado = $this->controller->eliminar($id);
                    if ($resultado) {
                        echo json_encode(['mensaje' => 'Relación eliminada correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al eliminar la relación']);
                    }
                } catch (Exception $e) {
                    http_response_code(400);
                    echo json_encode(['error' => $e->getMessage()]);
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
$api = new CategoriaDoctorAPIController();
$api->manejarPeticiones();

?>
