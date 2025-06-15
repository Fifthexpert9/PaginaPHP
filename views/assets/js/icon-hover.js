/**
 * Script para animar los iconos de la barra de navegación o botones con efecto hover.
 *
 * - Cambia el icono de contorno (por ejemplo, bi-house-heart) por su versión rellena (bi-house-heart-fill) al pasar el mouse.
 * - Restaura el icono original al quitar el mouse.
 *
 * Dependencias:
 * - Los iconos deben estar dentro de un elemento con la clase .icon-hover.
 * - Los iconos deben usar clases de Bootstrap Icons (bi-*).
 *
 * Ejemplo de uso en HTML:
 * <div class="icon-hover"><i class="bi bi-house-heart icon"></i></div>
 */

document.querySelectorAll('.icon-hover .icon').forEach(function(icon) {
    icon.parentElement.addEventListener('mouseenter', function() {
        if (icon.classList.contains('bi-house-heart')) {
            icon.classList.remove('bi-house-heart');
            icon.classList.add('bi-house-heart-fill');
        }
        if (icon.classList.contains('bi-plus-circle')) {
            icon.classList.remove('bi-plus-circle');
            icon.classList.add('bi-plus-circle-fill');
        }
        if (icon.classList.contains('bi-person')) {
            icon.classList.remove('bi-person');
            icon.classList.add('bi-person-fill');
        }
        if (icon.classList.contains('bi-door-open')) {
            icon.classList.remove('bi-door-open');
            icon.classList.add('bi-door-open-fill');
        }
    });
    icon.parentElement.addEventListener('mouseleave', function() {
        if (icon.classList.contains('bi-house-heart-fill')) {
            icon.classList.remove('bi-house-heart-fill');
            icon.classList.add('bi-house-heart');
        }
        if (icon.classList.contains('bi-plus-circle-fill')) {
            icon.classList.remove('bi-plus-circle-fill');
            icon.classList.add('bi-plus-circle');
        }
        if (icon.classList.contains('bi-person-fill')) {
            icon.classList.remove('bi-person-fill');
            icon.classList.add('bi-person');
        }
        if (icon.classList.contains('bi-door-open-fill')) {
            icon.classList.remove('bi-door-open-fill');
            icon.classList.add('bi-door-open');
        }
    });
});