/**
 * Script para gestionar la navegación por pasos en el formulario de nueva propiedad.
 *
 * Funcionalidades:
 * - Permite avanzar (nextStep) o retroceder (prevStep) entre los diferentes pasos del formulario.
 * - Oculta todos los pasos y muestra solo el paso actual según el número de paso recibido.
 *
 * Dependencias:
 * - Cada paso del formulario debe tener la clase .step y un id="step-X" donde X es el número del paso.
 * - Los botones de navegación deben llamar a nextStep(n) o prevStep(n) según corresponda.
 */

function nextStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.add('d-none'));
    document.getElementById('step-' + step).classList.remove('d-none');
}

function prevStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.add('d-none'));
    document.getElementById('step-' + step).classList.remove('d-none');
}