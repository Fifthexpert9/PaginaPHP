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

  // Property select
  const property = document.getElementById('property_id');
  if (!property.value) {
    setFieldInvalid(property, "Selecciona una propiedad.");
    allValid = false;
  } else {
    setFieldValid(property);
  }

  // Action radios
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

  // Price
  const price = document.getElementById('price');
  if (!price.value || parseInt(price.value) < 1) {
    setFieldInvalid(price, "Introduce un precio válido.");
    allValid = false;
  } else {
    setFieldValid(price);
  }

  // Description
  const description = document.getElementById('description');
  if (!description.value.trim()) {
    setFieldInvalid(description, "Introduce una descripción.");
    allValid = false;
  } else {
    setFieldValid(description);
  }

  // Habilita o deshabilita el botón de crear anuncio
  const submitBtn = document.querySelector('form[action="/controllers/CreateAdvert.php"] button[type="submit"]');
  if (submitBtn) submitBtn.disabled = !allValid;

  return allValid;
}

document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('form[action="/controllers/CreateAdvert.php"]');
  if (!form) return;

  // Mostrar errores al cargar la página y bloquear el botón si hay errores
  checkAdvertForm();

  // Validación en tiempo real
  form.querySelectorAll('input, select, textarea').forEach(field => {
    field.addEventListener('input', checkAdvertForm);
    field.addEventListener('change', checkAdvertForm);
  });

  // Validación al enviar
  form.addEventListener('submit', function (e) {
    if (!checkAdvertForm()) e.preventDefault();
  });
});