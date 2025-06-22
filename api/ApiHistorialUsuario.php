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

// Importamos el controlador necesario para manejar la lógica del historial médico del usuario
require_once __DIR__ . '/../controller/HistorialUsuarioController.php';

// Creamos la clase API que se encargará de recibir las solicitudes HTTP (GET, POST, PUT, DELETE)
class ApiHistorialUsuario {
    // Propiedad privada donde guardamos una instancia del controlador
    private $controller;

    // Constructor que inicializa el controlador cuando se crea la API
    public function __construct() {
        $this->controller = new HistorialUsuarioController();
    }

    // Esta función se encarga de manejar las diferentes peticiones que llegan a esta API
    public function manejarPeticiones() {
        // Detectamos el tipo de petición HTTP que se hizo (GET, POST, PUT, DELETE)
        $metodo = $_SERVER['REQUEST_METHOD'];

        // Usamos un switch para ejecutar acciones dependiendo del método HTTP
        switch ($metodo) {

            // Caso para obtener datos (lectura)
            case 'GET':
                try {
                    // Si se pasó un parámetro 'id', buscamos un historial específico
                    if (isset($_GET['id'])) {
                        $id = intval($_GET['id']);
                        $historial = $this->controller->obtenerPorId($id);

                        // Si se encuentra, lo devolvemos en formato JSON
                        if ($historial) {
                            echo json_encode($historial);
                        } else {
                            // Si no se encuentra, devolvemos error 404
                            http_response_code(404);
                            echo json_encode(['error' => 'Registro no encontrado']);
                        }
                    } else {
                        // Si no se envió 'id', devolvemos todos los historiales
                        echo json_encode($this->controller->obtenerTodos());
                    }
                } catch (Exception $e) {
                    // En caso de error general, devolvemos error 500
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            // Caso para crear un nuevo historial médico
            case 'POST':
                // Obtenemos los datos enviados en formato JSON desde el cuerpo de la solicitud
                $datos = json_decode(file_get_contents('php://input'), true);

                // Validamos que los datos sean válidos
                if (!$datos) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Datos JSON inválidos']);
                    exit;
                }

                try {
                    // Insertamos los datos usando el controlador
                    $resultado = $this->controller->insertar($datos);
                    if ($resultado) {
                        http_response_code(201); // 201 = creado
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
                
                
            // Caso para eliminar un historial existente
            case 'DELETE':
                // Validamos que se haya enviado el ID
                if (!isset($_GET['id'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Falta ID para eliminar el historial del usuario']);
                    exit;
                }

                $id = intval($_GET['id']);

                try {
                    // Llamamos al método para eliminar el historial
                    $resultado = $this->controller->eliminar($id);
                    if ($resultado) {
                        echo json_encode(['mensaje' => 'Historial de usuario eliminado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al eliminar el historial de usuario']);
                    }
                } catch (Exception $e) {
                    http_response_code(400);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            // Si el método HTTP no está soportado
            default:
                http_response_code(405); // 405 = método no permitido
                echo json_encode(['error' => 'Método no soportado']);
                break;
        }
    }
}

// Finalmente, instanciamos la clase de la API y ejecutamos la función que maneja las peticiones
$api = new ApiHistorialUsuario();
$api->manejarPeticiones();

?>
