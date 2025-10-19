(() => {
  'use strict';

  const form = document.getElementById('formulario');
  const alerta = document.getElementById('alerta');

  form.addEventListener('submit', async (event) => {
    event.preventDefault();

    if (!form.checkValidity()) {
      event.stopPropagation();
      form.classList.add('was-validated');
      return;
    }

    const formData = new FormData(form);
    const respuesta = await fetch('guardar.php', {
      method: 'POST',
      body: formData
    });

    const resultado = await respuesta.json();

    alerta.classList.remove('d-none', 'alert-success', 'alert-danger');
    alerta.classList.add('alert', resultado.success ? 'alert-success' : 'alert-danger');
    alerta.textContent = resultado.message;

    if (resultado.success) {
      form.reset();
      form.classList.remove('was-validated');
    }
  });
})();
