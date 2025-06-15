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

  // Validación de dirección real solo en el paso 1
  if (stepNumber === 1 && allValid && nextBtn) {
    nextBtn.disabled = true; 
    validateAddressReal(1).then(isReal => {
      if (!isReal) {
        setFieldInvalid(document.getElementById('street'), "Introduce una dirección real y existente.");
        setFieldInvalid(document.getElementById('city'), "IIntroduce una ciudad real y existente.");
        setFieldInvalid(document.getElementById('province'), "Introduce una provincia real y existente.");
        setFieldInvalid(document.getElementById('country'), "Introduce un país real y existente.");
        nextBtn.disabled = true;
      } else {
        setFieldValid(document.getElementById('street'));
        setFieldValid(document.getElementById('city'));
        setFieldValid(document.getElementById('province'));
        setFieldValid(document.getElementById('country'));
        nextBtn.disabled = false;
      }
    });
  }
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

// Validación de dirección real usando Nominatim (OpenStreetMap)
async function validateAddressReal(stepNumber) {
  if (stepNumber !== 1) return true; // Solo validar en el paso 1

  const street = document.getElementById('street').value.trim();
  const city = document.getElementById('city').value.trim();
  const province = document.getElementById('province').value.trim();
  const country = document.getElementById('country').value.trim();

  // Solo validar si todos los campos tienen valor
  if (!street || !city || !province || !country) return false;


  const query = encodeURIComponent(`${street}, ${city}, ${province}, ${country}`);
  const url = `https://nominatim.openstreetmap.org/search?format=json&q=${query}&addressdetails=1&limit=1`;

  try {
    const response = await fetch(url, { headers: { 'Accept-Language': 'es' } });
    const data = await response.json();
    if (data.length === 0) return false;

    // Comprobación extra: que la ciudad, provincia y país coincidan
    const address = data[0].address;

    // Helper para comparar ignorando mayúsculas/minúsculas y tildes
    function normalize(str) {
      return str ? str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase() : "";
    }

    const inputCity = normalize(city);
    const inputProvince = normalize(province);
    const inputCountry = normalize(country);

    const cityMatch =
      [address.city, address.town, address.village, address.hamlet]
        .filter(Boolean)
        .some(val => normalize(val).includes(inputCity));

    const provinceMatch =
      [address.state, address.region, address.county, address.province]
        .filter(Boolean)
        .some(val => normalize(val).includes(inputProvince));

    const countryMatch = address.country && normalize(address.country).includes(inputCountry);

    if (cityMatch && provinceMatch && countryMatch) {
      return true;
    }
    return false;
  } catch (e) {
    
    return false;
  }
}
