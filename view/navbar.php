<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Simulamos el tipo de usuario (en producción sacarlo de $_SESSION o DB)
$rol = $_SESSION['usuario_rol'] ?? null;  // 'paciente', 'secretaria', 'doctor' o null

?>
<nav
    class="fixed top-0 left-0 w-full flex items-center justify-between px-6 py-4 max-w-7xl mx-auto z-50 bg-transparent">
    <div class="text-white font-semibold text-lg text-shadow" style="font-family: Montserrat, sans-serif;">
        MediSync
    </div>
    <ul class="hidden md:flex space-x-8 text-white text-shadow text-sm font-semibold"
        style="font-family: Montserrat, sans-serif;">
        <li><a class="hover:underline" href="#">Inicio</a></li>

         <!-- Paciente -->
        <?php if ($rol === 3 ): ?>
            <li><a class="hover:underline" href="historial.php">Mi Historial Médico</a></li>
            <li><a class="hover:underline" href="">Pedir Cita</a></li>
            <li><a class="hover:underline" href="logout.php">Cerrar Sesion</a></li>

            <!-- Admin -->
        <?php elseif ($rol === 1 ): ?> 
            <li><a class="hover:underline" href="">Citas en Espera</a></li>
            <li><a class="hover:underline" href="">Listas</a></li>
            <li><a class="hover:underline" href="logout.php">Cerrar Sesion</a></li>

        <!-- Dcotor -->
        <?php elseif ($rol === 2 ): ?> 
            <li><a class="hover:underline" href="">Citas Aceptadas</a></li>
            <li><a class="hover:underline" href="logout.php">Cerrar Sesion</a></li>

        <?php else: ?>
            <!-- Usuario no logueado -->
            <li><a class="hover:underline" href="login.php">Iniciar Sesión</a></li>
        <?php endif; ?>
    </ul>
</nav>
