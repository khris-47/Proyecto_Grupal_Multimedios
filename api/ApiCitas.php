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


require_once __DIR__ . '/../controller/CitasController.php';

class ApiCitas {
    private $controller;

    public function __construct() {
        $this->controller = new CitasController();
    }

    public function manejarPeticiones() {
        $metodo = $_SERVER['REQUEST_METHOD'];
        header('Content-Type: application/json; charset=utf-8');

        switch ($metodo) {
            case 'GET':
                try {
                    if (isset($_GET['id'])) {
                        $id = intval($_GET['id']);
                        $cita = $this->controller->obtenerPorId($id);

                        if ($cita) {
                            echo json_encode($cita);
                        } else {
                            http_response_code(404);
                            echo json_encode(['error' => 'Cita no encontrada']);
                        }
                    } else {
                        echo json_encode($this->controller->obtenerTodos());
                    }
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'POST':
                try {
                    $datos = json_decode(file_get_contents('php://input'), true);

                    if (!$datos) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Datos JSON inválidos']);
                        exit;
                    }

                    $resultado = $this->controller->insertar($datos);
                    if ($resultado) {
                        http_response_code(201);
                        echo json_encode(['mensaje' => 'Cita creada correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al insertar la cita']);
                    }
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                try {
                    $id = $_GET['id'] ?? null;
                    $datos = json_decode(file_get_contents('php://input'), true);

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

                    $resultado = $this->controller->actualizar($id, $datos);
                    if ($resultado) {
                        echo json_encode(['mensaje' => 'Cita actualizada correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al actualizar la cita']);
                    }
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                try {
                    if (!isset($_GET['id'])) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Falta ID para eliminar']);
                        exit;
                    }

                    $id = intval($_GET['id']);
                    $resultado = $this->controller->eliminar($id);
                    if ($resultado) {
                        echo json_encode(['mensaje' => 'Cita eliminada correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al eliminar la cita']);
                    }
                } catch (Exception $e) {
                    http_response_code(500);
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
$api = new ApiCitas();
$api->manejarPeticiones();

?>
