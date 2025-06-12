<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center">
        Usuario o contraseña incorrectos.
    </div>
<?php endif; ?>


<!doctype html>
<html lang="en">

<head>
    <title>MediSync - Iniciar Sesion</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font Awesome (íconos) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/index.css">


</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>

    <main>
        <div class="container-fluid login-container d-flex">
            <!-- Panel izquierdo (Logo) -->
            <div class="d-none d-md-flex flex-column justify-content-center align-items-center col-md-6 logo-panel">
                <img src="../img/logo_titulo.png" alt="MediSync Logo" class="img-fluid">
            </div>

            <!-- Panel derecho (Formulario) -->
            <div class="d-flex flex-column justify-content-center align-items-center col-12 col-md-6 p-5">
                <div class="w-100" style="max-width: 400px;">
                    <h3 class="mb-4 text-center">Iniciar sesión</h3>

                    <form method="post" action="/Proyecto_PHP/Proyecto_PHP/controller/LoginController.php"">
                        <div class=" mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Ingresar</button>

                <div class="text-center mt-4">
                    <span>¿No tienes una cuenta?</span>
                    <a href="#" class="text-decoration-none text-primary" data-bs-toggle="modal"
                        data-bs-target="#registroModal">Nuevo Usuario</a>
                </div>
                </form>
            </div>
        </div>
        </div>
    </main>

    <!-- Modal Registro -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formRegistro">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Crear Nueva Cuenta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="registroCedula" class="form-label">Cédula</label>
                            <input type="number" class="form-control" id="registroCedula" name="cedula" required>
                        </div>
                        <div class="mb-3">
                            <label for="registroNombre" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" id="registroNombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="registroEmail" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="registroEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="registroPassword" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="registroPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="registroConfirmPassword" class="form-label">Confirmar contraseña</label>
                            <input type="password" class="form-control" id="registroConfirmPassword"
                                name="confirm_password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script src="../js/UsuarioFunctions.js"></script>
</body>

</html>