<?php
session_start();
$rol = $_SESSION['rol'] ?? null; // Si no hay sesión, $rol será null
?>



<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        MediSync
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&amp;display=swap" rel="stylesheet" />
    <style>
        .text-shadow {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
        }
    </style>
</head>

<body class="bg-white text-gray-900">

    <!-- Barra de navegación -->
    <?php include 'navbar.php'; ?>

    <!-- Sección Principal (Hero) -->
    <section class="relative bg-[#3b82f6] overflow-hidden pt-20">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-20 flex flex-col md:flex-row items-center justify-between">
            <div class="text-white max-w-xl md:max-w-lg">
                <h1 class="text-3xl md:text-4xl font-semibold leading-tight mb-6"
                    style="font-family: Montserrat, sans-serif;">
                    OFRECEMOS LA MEJOR<br />
                    ATENCIÓN MÉDICA
                </h1>
                <p class="text-white text-sm md:text-base mb-8 leading-relaxed"
                    style="font-family: Montserrat, sans-serif;">
                    Nuestros doctores y enfermeros brindan una atención médica perfecta. Un sistema avanzado de apoyo
                    humano que te ayuda a vivir una vida más feliz y saludable, con un hospital completo, servicios
                    médicos y tecnología avanzada de salud.
                </p>
                <button
                    class="bg-[#e6d7c7] text-[#3b82f6] font-semibold px-6 py-2 rounded-md hover:bg-[#d4c3b3] transition"
                    style="font-family: Montserrat, sans-serif;">
                    Leer Más
                </button>
            </div>
        </div>

        <!-- Navegación por puntos -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
            <span class="w-3 h-3 rounded-full bg-white opacity-80"></span>
            <span class="w-3 h-3 rounded-full bg-white opacity-40"></span>
            <span class="w-3 h-3 rounded-full bg-white opacity-40"></span>
        </div>

        <!-- Forma de onda -->
        <svg class="w-full -mb-1" fill="none" preserveaspectratio="none" viewbox="0 0 1440 80"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M0 80C120 0 360 0 720 0C1080 0 1320 80 1440 80V80H0V80Z" fill="white"></path>
        </svg>
    </section>

    <!-- Nuestros Departamentos -->
    <section class="max-w-7xl mx-auto px-6 md:px-12 py-16 text-center">
        <h2 class="text-gray-900 font-semibold text-lg mb-2" style="font-family: Montserrat, sans-serif;">
            NUESTROS DEPARTAMENTOS
        </h2>
        <p class="text-gray-600 text-sm mb-12 max-w-2xl mx-auto" style="font-family: Montserrat, sans-serif;">
            Todos los departamentos trabajan de manera colaborativa para brindar la mejor atención médica. Médicos y
            enfermeros entregan conocimiento y cuidado con gran profesionalismo.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 max-w-5xl mx-auto">
            <!-- Tarjeta 1 -->
            <div class="space-y-4">
                <div
                    class="w-16 h-16 mx-auto rounded-full bg-[#3b82f6] flex items-center justify-center text-white text-xl">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h3 class="text-gray-900 font-semibold text-base" style="font-family: Montserrat, sans-serif;">
                    CARDIOLOGÍA
                </h3>
                <p class="text-gray-600 text-xs leading-tight" style="font-family: Montserrat, sans-serif;">
                    El corazón es un órgano vital que bombea sangre al resto del cuerpo a través de una circulación
                    constante.
                </p>
            </div>
            <!-- Tarjeta 2 -->
            <div class="space-y-4">
                <div
                    class="w-16 h-16 mx-auto rounded-full bg-[#3b82f6] flex items-center justify-center text-white text-xl">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <h3 class="text-gray-900 font-semibold text-base" style="font-family: Montserrat, sans-serif;">
                    DIAGNÓSTICO
                </h3>
                <p class="text-gray-600 text-xs leading-tight" style="font-family: Montserrat, sans-serif;">
                    El proceso de identificar una enfermedad o afección mediante la evaluación médica del cuerpo.
                </p>
            </div>
            <!-- Tarjeta 3 -->
            <div class="space-y-4">
                <div
                    class="w-16 h-16 mx-auto rounded-full bg-[#3b82f6] flex items-center justify-center text-white text-xl">
                    <i class="fas fa-user-md"></i>
                </div>
                <h3 class="text-gray-900 font-semibold text-base" style="font-family: Montserrat, sans-serif;">
                    CIRUGÍA
                </h3>
                <p class="text-gray-600 text-xs leading-tight" style="font-family: Montserrat, sans-serif;">
                    Tratamiento médico de enfermedades o lesiones mediante incisiones o manipulaciones sobre el cuerpo.
                </p>
            </div>
            <!-- Tarjeta 4 -->
            <div class="space-y-4">
                <div
                    class="w-16 h-16 mx-auto rounded-full bg-[#3b82f6] flex items-center justify-center text-white text-xl">
                    <i class="fas fa-briefcase-medical"></i>
                </div>
                <h3 class="text-gray-900 font-semibold text-base" style="font-family: Montserrat, sans-serif;">
                    PRIMEROS AUXILIOS
                </h3>
                <p class="text-gray-600 text-xs leading-tight" style="font-family: Montserrat, sans-serif;">
                    La asistencia inmediata brindada a cualquier persona que sufra una enfermedad o lesión súbita.
                </p>
            </div>
        </div>
        <button class="mt-12 bg-[#3b82f6] text-white font-semibold px-8 py-2 rounded-md hover:bg-[#2563eb] transition"
            style="font-family: Montserrat, sans-serif;">
            Ver Todos
        </button>
    </section>

    <!-- Sobre Nosotros -->
    <section class="max-w-7xl mx-auto px-6 md:px-12 py-16 flex flex-col md:flex-row items-center gap-10">
        <div class="flex-shrink-0 w-full md:w-1/3 rounded-lg overflow-hidden shadow-lg">
            <img alt="Doctora sentada en escritorio con plantas y libros de fondo" class="w-full h-full object-cover"
                draggable="false" height="480"
                src="https://storage.googleapis.com/a1aa/image/fba2d006-0556-4b3b-d120-ad30bb07286e.jpg" width="400" />
        </div>
        <div class="w-full md:w-2/3">
            <h2 class="text-gray-900 font-semibold text-lg mb-4" style="font-family: Montserrat, sans-serif;">
                SOBRE NOSOTROS
            </h2>
            <p class="text-gray-600 text-sm leading-relaxed mb-6" style="font-family: Montserrat, sans-serif;">
                Existen muchas variaciones de fragmentos de Lorem Ipsum disponibles, pero la mayoría han sufrido
                alteraciones en alguna forma, ya sea por humor insertado o palabras aleatorias que no parecen ser
                creíbles. Si vas a usar un texto de Lorem Ipsum, debes asegurarte de que no haya nada embarazoso oculto
                en medio del texto.
            </p>
            <button class="bg-[#3b82f6] text-white font-semibold px-6 py-2 rounded-md hover:bg-[#2563eb] transition"
                style="font-family: Montserrat, sans-serif;">
                Leer Más
            </button>
        </div>
    </section>
</body>


</html>