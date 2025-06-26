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


// Requerimos las clases necesarias para trabajar con usuarios desde su DAO y modelo
require_once __DIR__ . '/../accessData/UsuariosDAO.php';
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../controller/UsuariosController.php';

// Esta clase maneja las peticiones HTTP relacionadas con los usuarios
class UsuarioAPIController
{
    private $controller;

    // Constructor que inicializa el controlador de usuarios
    public function __construct()
    {
        $this->controller = new UsuarioController();
    }

    // Función principal que se encarga de manejar las peticiones entrantes
    public function manejarPeticiones()
    {
        // Detectamos qué método HTTP se está utilizando
        $metodo = $_SERVER['REQUEST_METHOD'];

        // Según el tipo de método, ejecutamos una lógica diferente
        switch ($metodo) {
            case 'GET':
                try {
                    // Si se pasa un ID por la URL, se busca un usuario específico
                    if (isset($_GET['id'])) {
                        $id = intval($_GET['id']); // Convertimos a entero por seguridad
                        $usuario = $this->controller->obtenerPorId($id);

                        if ($usuario) {
                            echo json_encode($usuario);
                        } else {
                            http_response_code(404); // No encontrado
                            echo json_encode(['error' => 'Usuario no encontrado']);
                        }
                    } else {
                        // Si no se pasa ID, se devuelven todos los usuarios
                        $usuarios = $this->controller->obtenerTodos();
                        echo json_encode($usuarios);
                    }
                } catch (Exception $e) {
                    http_response_code(500); // Error del servidor
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'POST':
                // Leemos el cuerpo de la petición, esperamos un JSON
                $datos = json_decode(file_get_contents('php://input'), true);

                // Validamos que el JSON sea válido
                if (!$datos) {
                    http_response_code(400); // Bad Request
                    echo json_encode(['error' => 'Datos JSON inválidos']);
                    exit;
                }

                try {
                    // Insertamos el nuevo usuario usando el controlador
                    $resultado = $this->controller->insertar($datos);
                    if ($resultado) {
                        http_response_code(201); // Created
                        echo json_encode(['mensaje' => 'Usuario creado correctamente']);
                    } else {
                        http_response_code(500); // Error interno
                        echo json_encode(['error' => 'Error al insertar el usuario']);
                    }
                } catch (Exception $e) {
                    http_response_code(400); // Error de datos o validación
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                // Obtenemos los datos para actualizar (JSON desde el cuerpo)
                $datos = json_decode(file_get_contents('php://input'), true);

                // Tratamos de obtener el ID desde la URL o desde el JSON
                $id = $_GET['id'] ?? ($datos['id'] ?? null);

                // Si no se proporcionó un ID, no podemos actualizar
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
                    // Intentamos actualizar con los datos nuevos
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
                // Verificamos si nos pasaron un ID por la URL para eliminar
                if (!isset($_GET['id'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta ID para eliminar']);
                    exit;
                }

                $id = $_GET['id'];

                try {
                    // Intentamos eliminar el usuario
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
                // Si se usa un método no permitido, se devuelve error
                http_response_code(405);
                echo json_encode(['error' => 'Método no soportado']);
                break;
        }
    }
}

// Creamos una instancia de la API y ejecutamos la función para manejar peticiones
$api = new UsuarioAPIController();
$api->manejarPeticiones();

?>
