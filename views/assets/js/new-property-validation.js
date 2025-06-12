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

function checkStepFields(stepNumber) {
  const step = document.getElementById("step-" + stepNumber);
  if (!step) return;
  let allValid = true;

  // Selecciona todos los inputs, selects y textareas requeridos visibles en este paso
  const requiredFields = step.querySelectorAll(
    "input[required], select[required], textarea[required]"
  );

  // Para evitar mensajes duplicados en radios
  const radioGroupsChecked = new Set();

  requiredFields.forEach((field) => {
    // Para radio/checkbox, comprobar si hay alguno seleccionado en el grupo
    if (field.type === "radio") {
      if (radioGroupsChecked.has(field.name)) return; // Ya validado este grupo
      radioGroupsChecked.add(field.name);
      const group = step.querySelectorAll(`input[name="${field.name}"]`);
      const checked = step.querySelectorAll(`input[name="${field.name}"]:checked`);
      group.forEach(radio => {
        if (checked.length === 0) {
          setFieldInvalid(radio, "Este campo no puede estar vacío");
          allValid = false;
        } else {
          setFieldValid(radio);
        }
      });
    } else if (field.type === "checkbox") {
      // Para checkbox individuales
      if (!field.checked) {
        setFieldInvalid(field, "Este campo no puede estar vacío");
        allValid = false;
      } else {
        setFieldValid(field);
      }
    } else {
      if (!field.value || field.value.trim() === "") {
        setFieldInvalid(field, "Este campo no puede estar vacío");
        allValid = false;
      } else {
        setFieldValid(field);
      }
    }
  });

  // Habilita o deshabilita el botón "siguiente" de este paso
  const nextBtn = step.querySelector(
    'button.btn-secondary[onclick^="nextStep"]'
  );
  if (nextBtn) nextBtn.disabled = !allValid;
}

// Inicializa la validación en todos los pasos
function initStepValidation() {
  // Para cada paso
  document.querySelectorAll(".step").forEach((step, idx) => {
    const stepNumber = idx + 1;
    // Para cada campo requerido en el paso
    step
      .querySelectorAll("input[required], select[required], textarea[required]")
      .forEach((field) => {
        field.addEventListener("input", () => checkStepFields(stepNumber));
        field.addEventListener("change", () => checkStepFields(stepNumber));
      });
    // Comprobar al cargar
    checkStepFields(stepNumber);
  });
}

// Llama a la función al cargar la página
window.addEventListener("DOMContentLoaded", initStepValidation);

// --- INTEGRACIÓN CON CAMPOS DINÁMICOS DEL PASO 3 ---
// Sobrescribe la función loadFieldsForType para reinicializar la validación cuando cambian los campos dinámicos
const originalLoadFieldsForType = window.loadFieldsForType;
window.loadFieldsForType = function (type) {
  originalLoadFieldsForType(type);
  // Vuelve a inicializar la validación para los nuevos campos
  initStepValidation();
  // Y comprueba el paso actual (3)
  checkStepFields(3);
};
