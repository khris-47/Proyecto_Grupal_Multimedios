<?php

require_once __DIR__ . '/../accessData/UsuariosDAO.php';
require_once __DIR__ . '/../model/Usuario.php';  // asegúrate de incluir la clase Usuario
require_once __DIR__ . '/../controller/UsuariosController.php'; // para usar el controlador

class UsuarioAPIController
{

    private $controller;

    public function __construct()
    {
        $this->controller = new UsuarioController();
    }

    public function manejarPeticiones()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']); // Sanitizar el ID
                    $usuario = $this->controller->obtenerPorId($id);

                    if ($usuario) {
                        echo json_encode($usuario);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Usuario no encontrado']);
                    }
                } else {
                    $usuarios = $this->controller->obtenerTodos();
                    echo json_encode($usuarios);
                }
                break;

            case 'POST':
                // Leer JSON desde el cuerpo de la solicitud
                $datos = json_decode(file_get_contents('php://input'), true);

                if (!$datos) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Datos JSON inválidos']);
                    exit;
                }

                try {
                    $resultado = $this->controller->insertar($datos);
                    if ($resultado) {
                        http_response_code(201); // Created
                        echo json_encode(['mensaje' => 'Usuario creado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al insertar el usuario']);
                    }
                } catch (Exception $e) {
                    http_response_code(400);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                // Para PUT, el id puede venir como query (?id=) o en JSON
                parse_str(file_get_contents('php://input'), $put_vars);
                $datos = json_decode(file_get_contents('php://input'), true);

                // Prioridad a id en query string, si no en JSON
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
                        echo json_encode(['mensaje' => 'Usuario actualizado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al actualizar el usuario']);
                    }
                } catch (Exception $e) {
                    http_response_code(400);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                // ID para eliminar por query string ?id=
                if (!isset($_GET['id'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta ID para eliminar']);
                    exit;
                }
                $id = $_GET['id'];

                try {
                    $resultado = $this->controller->eliminar($id);
                    if ($resultado) {
                        echo json_encode(['mensaje' => 'Usuario eliminado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al eliminar el usuario']);
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
$api = new UsuarioAPIController();
$api->manejarPeticiones();

?>