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


require_once __DIR__ . '/../accessData/DoctorDAO.php';
require_once __DIR__ . '/../model/Doctor.php';  // Asegúrate de incluir la clase Doctor
require_once __DIR__ . '/../controller/DoctorController.php'; // Para usar el controlador

class ApiDoctores
{
    private $controller;

    public function __construct()
    {
        $this->controller = new DoctorController();
    }

    public function manejarPeticiones()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $doctor = $this->controller->obtenerPorId($id);
                    if ($doctor) {
                        // También aquí puedes agregar categorías si quieres
                        $doctor->categorias = $this->controller->obtenerCategoriasPorDoctorId($id);
                        echo json_encode($doctor);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Doctor no encontrado']);
                    }
                } else {
                    $doctores = $this->controller->obtenerTodosConCategorias();
                    echo json_encode($doctores);
                }
                break;


            case 'POST':
                // Leer JSON desde el cuerpo de la solicitud
                $rawInput = file_get_contents('php://input');
                error_log("RAW INPUT: " . $rawInput);
                $datos = json_decode($rawInput, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(400);
                    echo json_encode([
                        'error' => 'Datos JSON inválidos',
                        'mensaje' => json_last_error_msg(),
                        'raw' => $rawInput
                    ]);
                    exit;
                }

                try {
                    $resultado = $this->controller->insertar($datos);
                    if ($resultado) {
                        http_response_code(201); // Created
                        echo json_encode(['mensaje' => 'Doctor creado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al insertar el doctor']);
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
                        echo json_encode(['mensaje' => 'Doctor actualizado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al actualizar el doctor']);
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
                        echo json_encode(['mensaje' => 'Doctor eliminado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al eliminar el doctor']);
                    }
                } catch (Exception $e) {
                    http_response_code(400);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            default:
                http_response_code(405); // Método no permitido
                echo json_encode(['error' => 'Método no soportado']);
                break;
        }
    }
}

// Crear instancia y ejecutar manejo de peticiones
$api = new ApiDoctores();
$api->manejarPeticiones();

?>