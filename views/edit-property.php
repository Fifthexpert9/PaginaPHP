<?php

namespace views;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\PropertyFacade;
use converters\PropertyConverter;
use converters\RoomConverter;
use converters\StudioConverter;
use converters\ApartmentConverter;
use converters\HouseConverter;
use converters\AddressConverter;
use converters\ImageConverter;

session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para acceder a esta funcionalidad.';
    header('Location: /message');
    exit();
}

$propertyId = $_GET['id'] ?? null;
$property = null;
if ($propertyId) {
    $propertyFacade = new PropertyFacade(
        new PropertyConverter(),
        new RoomConverter(),
        new StudioConverter(),
        new ApartmentConverter(),
        new HouseConverter(),
        new AddressConverter(),
        new ImageConverter()
    );
    $property = $propertyFacade->getCompletePropertyById($propertyId);
}

if ($property->user_id != $_SESSION['user']->id) {
    $_SESSION['message'] = 'No tienes permisos para editar esta propiedad.';
    header('Location: /message');
    exit();
}

if (!$property) {
    $_SESSION['message'] = 'Propiedad no encontrada.';
    header('Location: /message');
    exit();
}

// 3. Extraer datos genéricos y específicos
$address = $property->address ?? null;
$property_type = $property->property_type ?? '';
?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>
<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <h2 class="logo text-center mt-3">editar propiedad</h2>
                    <div class="card-body">
                        <form action="/controllers/EditProperty.php" method="POST">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($propertyId) ?>">
                            <!-- Dirección -->
                            <div class="border rounded p-3 mb-3">
                                <h4 class="mb-3">Datos de dirección</h4>
                                <div class="mb-3">
                                    <label for="street" class="form-label">Calle</label>
                                    <input type="text" class="form-control" id="street" name="street" value="<?= htmlspecialchars($address->street ?? '') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($address->city ?? '') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="province" class="form-label">Provincia</label>
                                    <input type="text" class="form-control" id="province" name="province" value="<?= htmlspecialchars($address->province ?? '') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="postal_code" class="form-label">Código postal</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?= htmlspecialchars($address->postal_code ?? '') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="country" class="form-label">País</label>
                                    <input type="text" class="form-control" id="country" name="country" value="<?= htmlspecialchars($address->country ?? '') ?>" required>
                                </div>
                            </div>
                            <!-- Datos genéricos -->
                            <div class="border rounded p-3 mb-3">
                                <h4 class="mb-3">Datos generales de la propiedad</h4>
                                <p>Si quieres cambiar el tipo o subir nuevas fotos, tendrás que borrar la propiedad por completo.</p>
                                <input type="hidden" name="property_type" value="<?= htmlspecialchars($property->property_type) ?>">
                                <div class="mb-3">
                                    <label for="built_size" class="form-label">Tamaño construido (m²)</label>
                                    <input type="number" class="form-control" id="built_size" name="built_size" value="<?= htmlspecialchars($property->built_size ?? '') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label d-block">Estatus</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_obranueva" value="Obra nueva" <?= ($property->status ?? '') === 'Obra nueva' ? 'checked' : '' ?>>
                                        <label for="status_obranueva" class="form-check-label">Obra nueva</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_reformado" value="Reformado" <?= ($property->status ?? '') === 'Reformado' ? 'checked' : '' ?>>
                                        <label for="status_reformado class=" form-check-label"">Reformado</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_areformar" value="A reformar" <?= ($property->status ?? '') === 'A reformar' ? 'checked' : '' ?>>
                                        <label for="status_areformar" class="form-check-label">A reformar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_buenestado" value="Buen estado" <?= ($property->status ?? '') === 'Buen estado' ? 'checked' : '' ?>>
                                        <label for="status_buenestado" class="form-check-label">En buen estado</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="immediate_availability" class="form-label d-block">Disponibilidad inmediata</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="immediate_availability" id="immediate_yes" value="1" <?= !empty($property->immediate_availability) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="immediate_yes">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="immediate_availability" id="immediate_no" value="0" <?= empty($property->immediate_availability) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="immediate_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="border rounded p-3 mb-3">
                                <h4 class="mb-3">Datos específicos de la propiedad</h4>
                                <?php if ($property_type === 'Habitación'): ?>
                                    <div class="mb-3">
                                        <label for="private_bathroom" class="form-label d-block">Baño privado</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="private_bathroom" id="private_bathroom_yes" value="1" <?= !empty($property->private_bathroom) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="private_bathroom_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="private_bathroom" id="private_bathroom_no" value="0" <?= empty($property->private_bathroom) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="private_bathroom_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="max_roommates" class="form-label">¿Cuántas personas comparten el piso?</label>
                                        <input type="number" class="form-control w-25" id="max_roommates" name="max_roommates" min="1" max="10" value="<?= htmlspecialchars($property->max_roommates ?? '') ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pets_allowed" class="form-label d-block">¿Se permiten mascotas?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pets_allowed" id="pets_allowed_yes" value="1" <?= !empty($property->pets_allowed) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pets_allowed_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pets_allowed" id="pets_allowed_no" value="0" <?= empty($property->pets_allowed) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pets_allowed_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="furnished" class="form-label d-block">¿Está amueblada?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="furnished" id="furnished_yes" value="1" <?= !empty($property->furnished) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="furnished_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="furnished" id="furnished_no" value="0" <?= empty($property->furnished) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="furnished_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="students_only" class="form-label d-block">¿Solo estudiantes?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="students_only" id="students_only_yes" value="1" <?= !empty($property->students_only) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="students_only_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="students_only" id="students_only_no" value="0" <?= empty($property->students_only) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="students_only_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="gender_restriction" class="form-label d-block">¿Hay restricción de género?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender_restriction" id="gender_restriction_none" value="Sin restricciones" <?= ($property->gender_restriction ?? '') === 'Sin restricciones' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="gender_restriction_none">Sin restricciones</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender_restriction" id="gender_restriction_male" value="Sólo chicos" <?= ($property->gender_restriction ?? '') === 'Sólo chicos' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="gender_restriction_male">Sólo chicos</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender_restriction" id="gender_restriction_female" value="Sólo chicas" <?= ($property->gender_restriction ?? '') === 'Sólo chicas' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="gender_restriction_female">Sólo chicas</label>
                                        </div>
                                    </div>
                                <?php elseif ($property_type === 'Estudio'): ?>
                                    <div class="mb-3">
                                        <label for="furnished" class="form-label d-block">¿Está amueblado?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="furnished" id="furnished_yes" value="1" <?= !empty($property->furnished) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="furnished_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="furnished" id="furnished_no" value="0" <?= empty($property->furnished) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="furnished_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="balcony" class="form-label d-block">¿Tiene balcón o terraza?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="balcony" id="balcony_yes" value="1" <?= !empty($property->balcony) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="balcony_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="balcony" id="balcony_no" value="0" <?= empty($property->balcony) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="balcony_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="air_conditioning" class="form-label d-block">¿Tiene aire acondicionado?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="air_conditioning" id="air_conditioning_yes" value="1" <?= !empty($property->air_conditioning) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="air_conditioning_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="air_conditioning" id="air_conditioning_no" value="0" <?= empty($property->air_conditioning) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="air_conditioning_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pets_allowed" class="form-label d-block">¿Se permiten mascotas?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pets_allowed" id="pets_allowed_yes" value="1" <?= !empty($property->pets_allowed) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pets_allowed_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pets_allowed" id="pets_allowed_no" value="0" <?= empty($property->pets_allowed) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pets_allowed_no">No</label>
                                        </div>
                                    </div>
                                <?php elseif ($property_type === 'Piso'): ?>
                                    <div class="mb-3">
                                        <label for="apartment_type" class="form-label d-block">Tipo de piso</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="apartment_type" id="apartment_type_estandar" value="Estándar" <?= ($property->apartment_type ?? '') === 'Estándar' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="apartment_type_estandar">Estándar</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="apartment_type" id="apartment_type_loft" value="Loft" <?= ($property->apartment_type ?? '') === 'Loft' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="apartment_type_loft">Loft</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="apartment_type" id="apartment_type_atico" value="Ático" <?= ($property->apartment_type ?? '') === 'Ático' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="apartment_type_atico">Ático</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="apartment_type" id="apartment_type_duplex" value="Dúplex" <?= ($property->apartment_type ?? '') === 'Dúplex' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="apartment_type_duplex">Dúplex</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="apartment_type" id="apartment_type_bajo" value="Bajo con jardín" <?= ($property->apartment_type ?? '') === 'Bajo con jardín' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="apartment_type_bajo">Bajo con jardín</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="num_rooms" class="form-label">Número de habitaciones</label>
                                        <input type="number" class="form-control w-25" id="num_rooms" name="num_rooms" min="1" max="10" value="<?= htmlspecialchars($property->num_rooms ?? '') ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="num_bathrooms" class="form-label">Número de baños</label>
                                        <input type="number" class="form-control w-25" id="num_bathrooms" name="num_bathrooms" min="1" max="10" value="<?= htmlspecialchars($property->num_bathrooms ?? '') ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="furnished" class="form-label d-block">¿Está amueblado?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="furnished" id="furnished_yes" value="1" <?= !empty($property->furnished) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="furnished_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="furnished" id="furnished_no" value="0" <?= empty($property->furnished) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="furnished_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="balcony" class="form-label d-block">¿Tiene balcón o terraza?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="balcony" id="balcony_yes" value="1" <?= !empty($property->balcony) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="balcony_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="balcony" id="balcony_no" value="0" <?= empty($property->balcony) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="balcony_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="floor" class="form-label">¿En qué planta está?</label>
                                        <input type="number" class="form-control w-25" id="floor" name="floor" min="0" max="25" value="<?= htmlspecialchars($property->floor ?? '') ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="elevator" class="form-label d-block">¿Tiene ascensor?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="elevator" id="elevator_yes" value="1" <?= !empty($property->elevator) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="elevator_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="elevator" id="elevator_no" value="0" <?= empty($property->elevator) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="elevator_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="air_conditioning" class="form-label d-block">¿Tiene aire acondicionado?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="air_conditioning" id="air_conditioning_yes" value="1" <?= !empty($property->air_conditioning) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="air_conditioning_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="air_conditioning" id="air_conditioning_no" value="0" <?= empty($property->air_conditioning) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="air_conditioning_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="garage" class="form-label d-block">¿Tiene garaje?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="garage" id="garage_yes" value="1" <?= !empty($property->garage) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="garage_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="garage" id="garage_no" value="0" <?= empty($property->garage) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="garage_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pets_allowed" class="form-label d-block">¿Se permiten mascotas?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pets_allowed" id="pets_allowed_yes" value="1" <?= !empty($property->pets_allowed) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pets_allowed_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pets_allowed" id="pets_allowed_no" value="0" <?= empty($property->pets_allowed) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pets_allowed_no">No</label>
                                        </div>
                                    </div>
                                <?php elseif ($property_type === 'Casa'): ?>
                                    <div class="mb-3">
                                        <label for="house_type" class="form-label d-block">Tipo de casa</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="house_type" id="house_type_unifamiliar" value="Unifamiliar" <?= ($property->house_type ?? '') === 'Unifamiliar' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="house_type_unifamiliar">Unifamiliar</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="house_type" id="house_type_chalet" value="Chalet" <?= ($property->house_type ?? '') === 'Chalet' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="house_type_chalet">Chalet</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="house_type" id="house_type_adosado" value="Adosado" <?= ($property->house_type ?? '') === 'Adosado' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="house_type_adosado">Adosado</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="house_type" id="house_type_pareado" value="Pareado" <?= ($property->house_type ?? '') === 'Pareado' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="house_type_pareado">Pareado</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="house_type" id="house_type_rural" value="Casa rural" <?= ($property->house_type ?? '') === 'Casa rural' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="house_type_rural">Casa rural</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="garden_size" class="form-label">Tamaño del jardín (m²)</label>
                                        <input type="number" class="form-control w-25" id="garden_size" name="garden_size" min="0" value="<?= htmlspecialchars($property->garden_size ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="num_floors" class="form-label">Número de plantas</label>
                                        <input type="number" class="form-control w-25" id="num_floors" name="num_floors" min="1" max="10" value="<?= htmlspecialchars($property->num_floors ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="num_rooms" class="form-label">Número de habitaciones</label>
                                        <input type="number" class="form-control w-25" id="num_rooms" name="num_rooms" min="1" max="20" value="<?= htmlspecialchars($property->num_rooms ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="num_bathrooms" class="form-label">Número de baños</label>
                                        <input type="number" class="form-control w-25" id="num_bathrooms" name="num_bathrooms" min="1" max="20" value="<?= htmlspecialchars($property->num_bathrooms ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="private_garage" class="form-label d-block">¿Tiene garaje privado?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="private_garage" id="private_garage_yes" value="1" <?= !empty($property->private_garage) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="private_garage_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="private_garage" id="private_garage_no" value="0" <?= empty($property->private_garage) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="private_garage_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="private_pool" class="form-label d-block">¿Tiene piscina privada?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="private_pool" id="private_pool_yes" value="1" <?= !empty($property->private_pool) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="private_pool_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="private_pool" id="private_pool_no" value="0" <?= empty($property->private_pool) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="private_pool_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="furnished" class="form-label d-block">¿Está amueblado?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="furnished" id="furnished_yes" value="1" <?= !empty($property->furnished) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="furnished_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="furnished" id="furnished_no" value="0" <?= empty($property->furnished) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="furnished_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="terrace" class="form-label d-block">¿Tiene terraza o porche?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="terrace" id="terrace_yes" value="1" <?= !empty($property->terrace) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="terrace_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="terrace" id="terrace_no" value="0" <?= empty($property->terrace) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="terrace_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="storage_room" class="form-label d-block">¿Tiene trastero?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="storage_room" id="storage_room_yes" value="1" <?= !empty($property->storage_room) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="storage_room_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="storage_room" id="storage_room_no" value="0" <?= empty($property->storage_room) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="storage_room_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="air_conditioning" class="form-label d-block">¿Tiene aire acondicionado?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="air_conditioning" id="air_conditioning_yes" value="1" <?= !empty($property->air_conditioning) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="air_conditioning_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="air_conditioning" id="air_conditioning_no" value="0" <?= empty($property->air_conditioning) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="air_conditioning_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pets_allowed" class="form-label d-block">¿Se permiten mascotas?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pets_allowed" id="pets_allowed_yes" value="1" <?= !empty($property->pets_allowed) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pets_allowed_yes">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pets_allowed" id="pets_allowed_no" value="0" <?= empty($property->pets_allowed) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pets_allowed_no">No</label>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg btn-font">guardar cambios</button>
                                <a href="/my-properties" class="btn btn-secondary btn-lg btn-font" title="Volver atrás">cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/partials/footer.php'; ?>