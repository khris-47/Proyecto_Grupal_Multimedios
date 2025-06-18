<?php

require_once __DIR__ . '/../controller/CitasController.php';

class ApiCitas {
    private $controller;

    public function __construct() {
        $this->controller = new CitasController();
    }

    public function manejarPeticiones() {
        header('Content-Type: application/json; charset=utf-8');

        $metodo = $_SERVER['REQUEST_METHOD'];

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

                    if (!isset($datos['paciente_id']) || !isset($datos['fecha']) || !isset($datos['hora'])) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Faltan campos obligatorios: paciente_id, fecha, hora']);
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

                    if (!$id) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Falta ID para actualizar']);
                        exit;
                    }

                    $datos = json_decode(file_get_contents('php://input'), true);

                    if (!$datos) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Datos JSON inválidos para actualizar']);
                        exit;
                    }

                    if (!isset($datos['fecha']) && !isset($datos['hora']) && !isset($datos['motivo'])) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Se requiere al menos un campo para actualizar: fecha, hora o motivo']);
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

$api = new ApiCitas();
$api->manejarPeticiones();
