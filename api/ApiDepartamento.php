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


require_once __DIR__ . '/../controller/DepartamentoController.php';

class APIDepartamento
{
    private $controller;

    // Constructor: crea una instancia del controlador de Departamento
    public function __construct()
    {
        $this->controller = new DepartamentoController();
    }

    // Método principal para manejar las peticiones HTTP
    public function manejarPeticiones()
    {
        // Indicamos que la respuesta será JSON
        header('Content-Type: application/json; charset=utf-8');

        $metodo = $_SERVER['REQUEST_METHOD'];

        // Controlamos el método HTTP que se usó
        switch ($metodo) {
            case 'GET':
                try {
                    // Si se envía un ID por query string, obtener un departamento específico
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
                        // Si no se envía ID, obtener todos los departamentos
                        $departamentos = $this->controller->obtenerTodos();
                        echo json_encode($departamentos);
                    }
                } catch (Exception $e) {
                    // Error inesperado en GET
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'POST':
                try {
                    // Leer datos JSON desde el cuerpo de la petición
                    $inputJSON = file_get_contents('php://input');
                    $datos = json_decode($inputJSON, true);

                    // Validar datos JSON
                    if (!$datos) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Datos JSON inválidos']);
                        exit;
                    }

                    // Insertar nuevo departamento
                    $resultado = $this->controller->insertar($datos);
                    if ($resultado) {
                        http_response_code(201);
                        echo json_encode(['mensaje' => 'Departamento creado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al insertar el departamento']);
                    }
                } catch (Exception $e) {
                    // Capturar errores de inserción o validación
                    http_response_code(400);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                try {
                    // Obtener ID del query string
                    $id = $_GET['id'] ?? null;
                    if (!$id) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Falta ID para actualizar']);
                        exit;
                    }

                    // Leer datos JSON para actualizar
                    $inputJSON = file_get_contents('php://input');
                    $datos = json_decode($inputJSON, true);

                    // Validar datos JSON
                    if (!$datos) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Datos JSON inválidos para actualizar']);
                        exit;
                    }

                    // Actualizar departamento
                    $resultado = $this->controller->actualizar($id, $datos);
                    if ($resultado) {
                        echo json_encode(['mensaje' => 'Departamento actualizado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al actualizar el departamento']);
                    }
                } catch (Exception $e) {
                    // Capturar errores de actualización o validación
                    http_response_code(400);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                try {
                    // Validar que venga ID para eliminar
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
                } catch (Exception $e) {
                    // Capturar errores al eliminar
                    http_response_code(400);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            default:
                // Método no soportado
                http_response_code(405);
                echo json_encode(['error' => 'Método no soportado']);
                break;
        }
    }
}

// Crear instancia y manejar la petición
$api = new APIDepartamento();
$api->manejarPeticiones();

