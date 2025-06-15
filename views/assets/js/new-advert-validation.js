/**
 * Script de validación para el formulario de creación de anuncios.
 *
 * Funcionalidades:
 * - Valida en tiempo real los campos obligatorios del formulario de anuncio.
 * - Muestra mensajes de error personalizados y estilos de validación Bootstrap.
 * - Deshabilita el botón de envío si algún campo es inválido.
 * - Previene el envío del formulario si la validación falla.
 *
 * Campos validados:
 * - Propiedad seleccionada (select con id="property_id").
 * - Acción seleccionada (radio con name="action").
 * - Precio válido (input con id="price").
 * - Descripción no vacía (textarea con id="description").
 *
 * Dependencias:
 * - El formulario debe tener action="/controllers/CreateAdvert.php".
 * - Los campos deben tener los IDs y names mencionados.
 * - Se usan clases de Bootstrap para feedback visual.
 */

function setFieldInvalid(field, message) {
  field.classList.add('is-invalid');
  field.classList.remove('is-valid');
  let feedback = field.parentNode.querySelector('.invalid-feedback');
  if (!feedback) {
    feedback = document.createElement('div');
    feedback.className = 'invalid-feedback';
    field.parentNode.appendChild(feedback);
  }
  feedback.textContent = message;
  feedback.style.display = 'block';
}

function setFieldValid(field) {
  field.classList.remove('is-invalid');
  field.classList.add('is-valid');
  let feedback = field.parentNode.querySelector('.invalid-feedback');
  if (feedback) {
    feedback.textContent = '';
    feedback.style.display = 'none';
  }
}

function checkAdvertForm() {
  let allValid = true;

  const property = document.getElementById('property_id');
  if (!property.value) {
    setFieldInvalid(property, "Selecciona una propiedad.");
    allValid = false;
  } else {
    setFieldValid(property);
  }

  const actionRadios = document.querySelectorAll('input[name="action"]');
  const actionChecked = document.querySelector('input[name="action"]:checked');
  actionRadios.forEach(radio => {
    if (!actionChecked) {
      setFieldInvalid(radio, "Selecciona una opción.");
      allValid = false;
    } else {
      setFieldValid(radio);
    }
  });

  const price = document.getElementById('price');
  if (!price.value || parseInt(price.value) < 1) {
    setFieldInvalid(price, "Introduce un precio válido.");
    allValid = false;
  } else {
    setFieldValid(price);
  }

  const description = document.getElementById('description');
  if (!description.value.trim()) {
    setFieldInvalid(description, "Introduce una descripción.");
    allValid = false;
  } else {
    setFieldValid(description);
  }

  const submitBtn = document.querySelector('form[action="/controllers/CreateAdvert.php"] button[type="submit"]');
  if (submitBtn) submitBtn.disabled = !allValid;

  return allValid;
}

document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('form[action="/controllers/CreateAdvert.php"]');
  if (!form) return;

  checkAdvertForm();

  form.querySelectorAll('input, select, textarea').forEach(field => {
    field.addEventListener('input', checkAdvertForm);
    field.addEventListener('change', checkAdvertForm);
  });

  form.addEventListener('submit', function (e) {
    if (!checkAdvertForm()) e.preventDefault();
  });
});