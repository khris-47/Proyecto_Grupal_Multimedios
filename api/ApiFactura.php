
<?php

require_once __DIR__ . '/../controller/FacturaController.php';

class ApiFactura
{
    private $controller;

    public function __construct()
    {
        $this->controller = new FacturaController();
    }

    public function manejarPeticiones()
    {
        header('Content-Type: application/json; charset=utf-8');

        $metodo = $_SERVER['REQUEST_METHOD'];

        try {
            switch ($metodo) {
                case 'GET':
                    if (isset($_GET['id'])) {
                        $id = intval($_GET['id']);
                        $factura = $this->controller->obtenerPorId($id);

                        if ($factura) {
                            echo json_encode($factura);
                        } else {
                            http_response_code(404);
                            echo json_encode(['error' => 'Factura no encontrada']);
                        }
                    } else {
                        $facturas = $this->controller->obtenerTodos();
                        echo json_encode($facturas);
                    }
                    break;

                case 'POST':
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
                        echo json_encode(['mensaje' => 'Factura creada correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al insertar la factura']);
                    }
                    break;

                case 'PUT':
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
                        echo json_encode(['mensaje' => 'Factura actualizada correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al actualizar la factura']);
                    }
                    break;

                case 'DELETE':
                    if (!isset($_GET['id'])) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Falta ID para eliminar']);
                        exit;
                    }
                    $id = intval($_GET['id']);
                    $resultado = $this->controller->eliminar($id);
                    if ($resultado) {
                        echo json_encode(['mensaje' => 'Factura eliminada correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al eliminar la factura']);
                    }
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(['error' => 'Método no soportado']);
                    break;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

$api = new ApiFactura();
$api->manejarPeticiones();

