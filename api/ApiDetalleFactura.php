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



require_once __DIR__ . '/../controller/DetalleFacturaController.php';

class ApiDetalleFactura
{
    private $controller;

    public function __construct()
    {
        $this->controller = new DetalleFacturaController();
    }

    public function manejarPeticiones()
    {
        header('Content-Type: application/json; charset=utf-8');

        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                try {
                    if (isset($_GET['id'])) {
                        $id = intval($_GET['id']);
                        $detalle = $this->controller->obtenerPorId($id);

                        if ($detalle) {
                            echo json_encode($detalle);
                        } else {
                            http_response_code(404);
                            echo json_encode(['error' => 'Detalle de factura no encontrado']);
                        }
                    } else {
                        $detalles = $this->controller->obtenerTodos();
                        echo json_encode($detalles);
                    }
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'POST':
                try {
                    $inputJSON = file_get_contents('php://input');
                    $datos = json_decode($inputJSON, true);

                    if (!$datos) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Datos JSON inválidos']);
                        exit;
                    }

                    $resultado = $this->controller->insertar($datos);
                    if ($resultado) {
                        http_response_code(201);
                        echo json_encode(['mensaje' => 'Detalle de factura creado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al insertar el detalle de factura']);
                    }
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                try {
                    $id = $_GET['id'] ?? null;
                    if (!$id) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Falta ID para actualizar']);
                        exit;
                    }

                    $inputJSON = file_get_contents('php://input');
                    $datos = json_decode($inputJSON, true);

                    if (!$datos) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Datos JSON inválidos para actualizar']);
                        exit;
                    }

                    $resultado = $this->controller->actualizar($id, $datos);
                    if ($resultado) {
                        echo json_encode(['mensaje' => 'Detalle de factura actualizado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al actualizar el detalle de factura']);
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
                        echo json_encode(['mensaje' => 'Detalle de factura eliminado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al eliminar el detalle de factura']);
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

$api = new ApiDetalleFactura();
$api->manejarPeticiones();
