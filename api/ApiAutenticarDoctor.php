<?php

// Permitir CORS para desarrollo
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Responder a la petición OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


require_once __DIR__ . '/../controller/DoctorController.php';
header('Content-Type: application/json');

try {

    // Obtener cuerpo JSON
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Verificar campos obligatorios
    if (empty($data['email']) || empty($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan email o contraseña']);
        exit;
    }

    $controller = new DoctorController();
    $usuario = $controller->autenticar($data['email'], $data['password']);

    // Verificar si usuario existe y ES doctor
    if ($usuario && $usuario->id_rol == 2) { 
        echo json_encode([
            'mensaje' => 'Doctor autenticado correctamente',
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'id_rol' => $usuario->id_rol,
                'telefono' => $usuario->telefono
            ]
        ]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Acceso denegado. No es doctor o credenciales incorrectas']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error del servidor: ' . $e->getMessage()]);
}
