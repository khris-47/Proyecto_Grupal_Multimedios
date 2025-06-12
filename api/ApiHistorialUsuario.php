<?php

require_once __DIR__ . '/../controller/HistorialUsuarioController.php';

class ApiHistorialUsuario {
    private $controller;

    public function __construct() {
        $this->controller = new HistorialUsuarioController();
    }

    public function manejarPeticiones() {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $historial = $this->controller->obtenerPorId($id);

                    if ($historial) {
                        echo json_encode($historial);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Registro no encontrado']);
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
                        echo json_encode(['mensaje' => 'Historial creado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al insertar el historial']);
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
                        echo json_encode(['mensaje' => 'Historial actualizado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al actualizar el historial']);
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
                        echo json_encode(['mensaje' => 'Historial eliminado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al eliminar el historial']);
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
$api = new ApiHistorialUsuario();
$api->manejarPeticiones();

?>
