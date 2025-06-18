<?php


// reparar esto
//---------------------------------


session_start();

require_once __DIR__ . '/UsuariosController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuarioController = new UsuarioController();

    $usuario = $usuarioController->autenticar($email, $password);

    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['usuario_nombre'] = $usuario->nombre;
        $_SESSION['usuario_rol'] = $usuario->id_rol;

        // Redirigir según rol
        switch ($usuario->id_rol) {
            case 1: // Admin
                header('Location: /Proyecto_PHP/Proyecto_PHP/view/index.php');
                break;
            case 2: // Doctor

                break;

            case 3: // Paciente
                header('Location: /Proyecto_PHP/Proyecto_PHP/view/index.php');
                break;
            default:
                header('Location: /Proyecto_PHP/Proyecto_PHP/view/index.php');
                break;
        }
        exit();
    } else {
        header("Location: /Proyecto_PHP/Proyecto_PHP/view/login.php?error=1");
        exit();
    }
}
?>