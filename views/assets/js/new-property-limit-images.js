document.getElementById('images').addEventListener('change', function () {
    if (this.files.length > 6) {
        alert('Sólo puedes subir hasta 6 imágenes.');
        this.value = '';
    }
});