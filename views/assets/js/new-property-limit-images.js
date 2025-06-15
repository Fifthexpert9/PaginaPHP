/**
 * Script para limitar la cantidad de imágenes que se pueden subir en el formulario de nueva propiedad.
 *
 * Funcionalidad:
 * - Permite seleccionar hasta 6 imágenes como máximo.
 * - Si el usuario selecciona más de 6 imágenes, muestra una alerta y limpia el campo de archivos.
 *
 * Dependencias:
 * - El input de tipo file debe tener el id="images".
 */

document.getElementById('images').addEventListener('change', function () {
    if (this.files.length > 6) {
        alert('Sólo puedes subir hasta 6 imágenes.');
        this.value = '';
    }
});