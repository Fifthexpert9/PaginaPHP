function nextStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.add('d-none'));
    document.getElementById('step-' + step).classList.remove('d-none');
}

function prevStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.add('d-none'));
    document.getElementById('step-' + step).classList.remove('d-none');
}