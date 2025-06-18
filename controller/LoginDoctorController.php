<?php
session_start();


// reparar esto antes de usar

require_once __DIR__ . '/DoctorController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanear email
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    $doctorController = new DoctorController();

    // falta agregar esto al controller de doctores
    $doctor = $doctorController->autenticar($email, $password);

    if ($doctor) {
        // Guardar datos en sesión
        $_SESSION['doctor_id'] = $doctor->id;
        $_SESSION['doctor_nombre'] = $doctor->nombre;
        $_SESSION['doctor_rol'] = $doctor->id_rol;
        $_SESSION['doctor_departamento_id'] = $doctor->departamento_id;

        // Redirigir a dashboard del doctor (ajusta la ruta según tu proyecto)
        header('Location: /Proyecto_PHP/Proyecto_PHP/view/doctor_dashboard.php');
        exit();
    } else {
        // Si falla autenticación, redirigir a login con error
        header('Location: /Proyecto_PHP/Proyecto_PHP/view/doctor_login.php?error=1');
        exit();
    }
}
?>
