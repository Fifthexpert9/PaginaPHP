/**
 * Script de validación para el formulario de registro de usuarios.
 *
 * Funcionalidades:
 * - Valida en tiempo real y al enviar el formulario los campos obligatorios: email, contraseña, nombre y apellido.
 * - Muestra mensajes de error personalizados y estilos de validación Bootstrap.
 * - Previene el envío del formulario si algún campo es inválido.
 *
 * Reglas de validación:
 * - Email: Debe tener formato válido.
 * - Contraseña: Al menos 8 caracteres, una mayúscula y un número.
 * - Nombre y apellido: No vacíos y al menos 3 caracteres.
 *
 * Dependencias:
 * - El formulario debe tener action="/controllers/Register.php".
 * - Los campos deben tener los IDs: email, password, name, last_name.
 * - Se usan clases de Bootstrap para feedback visual.
 */

document
  .querySelector('form[action="/controllers/Register.php"]')
  .addEventListener("submit", function (e) {
    let valid = true;

    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const name = document.getElementById("name");
    const lastName = document.getElementById("last_name");

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value.trim())) {
      email.classList.add('is-invalid');
      email.nextElementSibling.textContent = "Por favor, introduce un correo electrónico válido.";
      valid = false;
    }

    const passRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
    if (!passRegex.test(password.value)) {
      password.classList.add('is-invalid');
      password.nextElementSibling.textContent = "La contraseña debe tener al menos 8 caracteres, incluir al menos un número y una letra mayúscula.";
      valid = false;
    }

    if (name.value.trim() === "") {
      name.classList.add('is-invalid');
      name.nextElementSibling.textContent = "Por favor, rellena tu nombre.";
      valid = false;
    }

    if (lastName.value.trim() === "") {
      lastName.classList.add('is-invalid');
      lastName.nextElementSibling.textContent = "Por favor, rellena tu apellido.";
      valid = false;
    }

    if (!valid) e.preventDefault();
  });

function validateField(field) {
  let valid = true;
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const passRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

  if (field.id === "email") {
    if (!emailRegex.test(field.value.trim())) {
      field.classList.add('is-invalid');
      field.classList.remove('is-valid');
      field.nextElementSibling.textContent = "Por favor, introduce un correo electrónico válido.";
      valid = false;
    } else {
      field.classList.remove('is-invalid');
      field.classList.add('is-valid');
      field.nextElementSibling.textContent = "";
    }
  }

  if (field.id === "password") {
    if (!passRegex.test(field.value)) {
      field.classList.add('is-invalid');
      field.classList.remove('is-valid');
      field.nextElementSibling.textContent = "La contraseña debe tener al menos 8 caracteres, incluir al menos un número y una letra mayúscula.";
      valid = false;
    } else {
      field.classList.remove('is-invalid');
      field.classList.add('is-valid');
      field.nextElementSibling.textContent = "";
    }
  }

  if (field.id === "name") {
    if (field.value.trim().length < 3) {
      field.classList.add('is-invalid');
      field.classList.remove('is-valid');
      field.nextElementSibling.textContent = "El nombre debe tener al menos 3 caracteres.";
      valid = false;
    } else {
      field.classList.remove('is-invalid');
      field.classList.add('is-valid');
      field.nextElementSibling.textContent = "";
    }
  }

  if (field.id === "last_name") {
    if (field.value.trim().length < 3) {
      field.classList.add('is-invalid');
      field.classList.remove('is-valid');
      field.nextElementSibling.textContent = "El apellido debe tener al menos 3 caracteres.";
      valid = false;
    } else {
      field.classList.remove('is-invalid');
      field.classList.add('is-valid');
      field.nextElementSibling.textContent = "";
    }
  }

  return valid;
}

const form = document.querySelector('form[action="/controllers/Register.php"]');
const fields = ["email", "password", "name", "last_name"].map(id => document.getElementById(id));

fields.forEach(field => {
  field.addEventListener('input', function () {
    validateField(field);
  });
});

form.addEventListener("submit", function (e) {
  let valid = true;
  fields.forEach(field => {
    if (!validateField(field)) valid = false;
  });
  if (!valid) e.preventDefault();
});
