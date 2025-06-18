<?php

require_once __DIR__ . '/../controller/MedicamentoController.php';

class ApiMedicamento
{
    private $controller;

    public function __construct()
    {
        $this->controller = new MedicamentoController();
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
                        $medicamento = $this->controller->obtenerPorId($id);

                        if ($medicamento) {
                            echo json_encode($medicamento);
                        } else {
                            http_response_code(404);
                            echo json_encode(['error' => 'Medicamento no encontrado']);
                        }
                    } else {
                        $medicamentos = $this->controller->obtenerTodos();
                        echo json_encode($medicamentos);
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

                    if (!isset($datos['nombre']) || !isset($datos['descripcion']) || !isset($datos['precio']) || !isset($datos['stock'])) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Faltan campos obligatorios: nombre, descripcion, precio, stock']);
                        exit;
                    }

                    $resultado = $this->controller->insertar($datos);
                    if ($resultado) {
                        http_response_code(201);
                        echo json_encode(['mensaje' => 'Medicamento creado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al insertar el medicamento']);
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

                    if (!isset($datos['nombre']) && !isset($datos['descripcion']) && !isset($datos['precio']) && !isset($datos['stock'])) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Se requiere al menos un campo para actualizar']);
                        exit;
                    }

                    $resultado = $this->controller->actualizar($id, $datos);
                    if ($resultado) {
                        echo json_encode(['mensaje' => 'Medicamento actualizado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al actualizar el medicamento']);
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
                        echo json_encode(['mensaje' => 'Medicamento eliminado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al eliminar el medicamento']);
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

$api = new ApiMedicamento();
$api->manejarPeticiones();
