<?php

require_once __DIR__ . '/../controller/DepartamentoController.php';

class APIDepartamento
{
    private $controller;

    public function __construct()
    {
        $this->controller = new DepartamentoController();
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
                        $departamento = $this->controller->obtenerPorId($id);

                        if ($departamento) {
                            echo json_encode($departamento);
                        } else {
                            http_response_code(404);
                            echo json_encode(['error' => 'Departamento no encontrado']);
                        }
                    } else {
                        $departamentos = $this->controller->obtenerTodos();
                        echo json_encode($departamentos);
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
                        echo json_encode(['mensaje' => 'Departamento creado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al insertar el departamento']);
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
                        echo json_encode(['mensaje' => 'Departamento actualizado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al actualizar el departamento']);
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
                        echo json_encode(['mensaje' => 'Departamento eliminado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al eliminar el departamento']);
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

// Crear instancia y manejar la petición
$api = new APIDepartamento();
$api->manejarPeticiones();
