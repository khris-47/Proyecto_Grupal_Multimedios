document.addEventListener('DOMContentLoaded', () => {

  // Seleccionamos el formulario dentro del modal de registro
  const formRegistro = document.querySelector('#registroModal form');

  // Si no existe el formulario (p.ej. en otra página), salir
  if (!formRegistro) return;

  // Escuchar el evento submit del formulario
  formRegistro.addEventListener('submit', async function (e) {
    // Evitar que el formulario se envíe por defecto (recarga página)
    e.preventDefault();

    // Obtener los valores de las contraseñas
    const pass = document.getElementById('registroPassword').value;
    const confirmPass = document.getElementById('registroConfirmPassword').value;

    // Validar que las contraseñas coincidan
    if (pass !== confirmPass) {
      alert('Las contraseñas no coinciden.');
      return; // Detener ejecución si no coinciden
    }

    // Construir un objeto con los datos del formulario para enviar por JSON
    const datos = {
      cedula: document.getElementById('registroCedula').value.trim(),
      nombre: document.getElementById('registroNombre').value.trim(),
      email: document.getElementById('registroEmail').value.trim(),
      password: pass
    };

    // Enviar los datos al servidor usando fetch con método POST
    const respuesta = await fetch('/Proyecto_PHP/Proyecto_PHP/controller/ApiUsuarios.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'  // Indicamos que enviamos JSON
      },
      body: JSON.stringify(datos)  // Convertimos objeto a JSON string
    });

    // Esperar y convertir la respuesta JSON del servidor
    const resultado = await respuesta.json();

    console.log(respuesta)

    if (respuesta.ok) {
      // Si el servidor respondió bien (200 OK)
      alert(resultado.mensaje || 'Registro exitoso');

      // Cerrar el modal usando Bootstrap JS
      const modal = bootstrap.Modal.getInstance(document.getElementById('registroModal'));
      if (modal) modal.hide();

      // Limpiar el formulario para la próxima vez
      formRegistro.reset();

    } else {
      // Si hubo un error, mostrar mensaje enviado por servidor o genérico
      alert(resultado.error || 'Error al registrar usuario');
    }


  });
});
