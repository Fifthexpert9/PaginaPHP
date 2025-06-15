<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para acceder a esta funcionalidad.';
    header('Location: /message');
    exit();
}
?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>
<main class="container d-flex justify-content-center align-items-center">
    <div class="card shadow-sm pt-2 ps-4 pe-4 pb-4" style="max-width: 800px; width: 100%;" style="height: 68vh;">
        <div class="text-center mt-1 mb-3">
            <h2 class="logo">Crear anuncio</h2>
        </div>
        <div class="d-none d-md-flex row">
            <div class="col-12 col-md-6 pe-3">
                <h4 class="text-center">No he registrado esta propiedad pero quiero anunciarla</h4>
                <a href="/new-property" class="btn btn-secondary btn-font w-100 my-3">Registrar propiedad</a>
                <h5 class="text-muted mt-3">Para crear un anuncio, primero debes registrar la propiedad</h5>
                <p>Es un proceso muy sencillo, en el que tendrás que indicar entre otros:</p>
                <ul>
                    <li>Dirección de la propiedad</li>
                    <li>Datos genéricos de la propiedad</li>
                    <li>Datos específicos</li>
                </ul>
                <p>Una vez termines de rellenar estos datos, podrás publicar tu anuncio, en el que podrás especificar el precio y qué quieres hacer con la vivienda.</p>
            </div>
            <div class="col-12 col-md-6 border-start ps-3">
                <h4 class="text-center">Ya tengo una propiedad, quiero anunciarla</h4>
                <a href="/new-advert" class="btn btn-secondary btn-font w-100 my-3">Crear anuncio</a>
                <h5 class="text-muted mt-3">¿Ya tienes la propiedad registrada? ¡Sólo quedan un par de pasos!</h5>
                <p>Sólo falta especificar qué quieres hacer con la propiedad (¿vender o comprar?) y el precio que quieras ponerle.</p>
                <p>Un administrador comprobará que no hayas infringido las normas del sitio y, si todo está bien, ¡tu anuncio verá la luz en muy poco tiempo!</p>
            </div>
        </div>

        <div class="d-md-none row">
            <div class="p-3">
                <h4 class="text-center">No he registrado esta propiedad pero quiero anunciarla</h4>
                <a href="/new-property" class="btn btn-secondary btn-font w-100 my-3">Registrar propiedad</a>
                <h5 class="text-muted mt-3">Para crear un anuncio, primero debes registrar la propiedad</h5>
                <p>Es un proceso muy sencillo, en el que tendrás que indicar entre otros:</p>
                <ul>
                    <li>Dirección de la propiedad</li>
                    <li>Datos genéricos de la propiedad</li>
                    <li>Datos específicos</li>
                </ul>
                <p>Una vez termines de rellenar estos datos, podrás publicar tu anuncio, en el que podrás especificar el precio y qué quieres hacer con la vivienda.</p>
            </div>
            <div class="border-top p-3">
                <h4 class="text-center">Ya tengo una propiedad, quiero anunciarla</h4>
                <a href="/new-advert" class="btn btn-secondary btn-font w-100 my-3">crear anuncio</a>
                <h5 class="text-muted mt-3">¿Ya tienes la propiedad registrada? ¡Sólo quedan un par de pasos!</h5>
                <p>Sólo falta especificar qué quieres hacer con la propiedad (¿vender o comprar?) y el precio que quieras ponerle.</p>
                <p>Un administrador comprobará que no hayas infringido las normas del sitio y, si todo está bien, ¡tu anuncio verá la luz en muy poco tiempo!</p>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>