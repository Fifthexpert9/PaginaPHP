<?php
$types = $_GET['type'] ?? [];
if (!is_array($types)) {
    $types = [$types];
}

foreach ($types as $type) {
    switch ($type) {
        case 'Habitación':
?>
            <div class="border rounded">
                <div class="card-header bg-secondary text-white">
                    <strong>Filtrar habitaciones</strong>
                </div>
                <div class="p-2">
                    <div class="mb-3">
                        <label for="private_bathroom" class="form-label">Baño privado</label>
                        <select class="form-select" id="private_bathroom" name="room[private_bathroom]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="max_roommates" class="form-label">Máximo de compañeros</label>
                        <input type="number" class="form-control" id="max_roommates" name="room[max_roommates]" min="1" max="20" placeholder="Ej: 3">
                    </div>
                    <div class="mb-3">
                        <label for="pets_allowed" class="form-label">¿Se permiten mascotas?</label>
                        <select class="form-select" id="pets_allowed" name="room[pets_allowed]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="furnished" class="form-label">¿Amueblada?</label>
                        <select class="form-select" id="furnished" name="room[furnished]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="students_only" class="form-label">¿Solo estudiantes?</label>
                        <select class="form-select" id="students_only" name="room[students_only]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gender_restriction" class="form-label">Restricciones de género</label>
                        <select class="form-select" id="gender_restriction" name="room[gender_restriction]">
                            <option value="">Cualquiera</option>
                            <option value="Solo chicos">Sólo chicos</option>
                            <option value="Solo chicas">Sólo chicas</option>
                            <option value="Sin restricciones">Sin restricciones</option>
                        </select>
                    </div>
                </div>
            </div>
        <?php
            break;
        case 'Estudio':
        ?>
            <div class="border rounded">
                <div class="card-header bg-secondary text-white">
                    <strong>Filtrar estudios</strong>
                </div>
                <div class="p-2">
                    <div class="mb-3">
                        <label for="studio_furnished" class="form-label">¿Amueblado?</label>
                        <select class="form-select" id="studio_furnished" name="studio[furnished]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="studio_balcony" class="form-label">¿Balcón/terraza?</label>
                        <select class="form-select" id="studio_balcony" name="studio[balcony]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="studio_air_conditioning" class="form-label">¿Aire acondicionado?</label>
                        <select class="form-select" id="studio_air_conditioning" name="studio[air_conditioning]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="studio_pets_allowed" class="form-label">¿Se permiten mascotas?</label>
                        <select class="form-select" id="studio_pets_allowed" name="studio[pets_allowed]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>
        <?php
            break;
        case 'Piso':
        ?>
            <div class="border rounded">
                <div class="card-header bg-secondary text-white">
                    <strong>Filtrar pisos</strong>
                </div>
                <div class="p-2">
                    <div class="mb-3">
                        <label class="form-label">Tipo de piso</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="apartment[apartment_type][]" id="tipo_estandar" value="Estándar">
                                <label class="form-check-label" for="tipo_estandar">Estándar</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="apartment[apartment_type][]" id="tipo_loft" value="Loft">
                                <label class="form-check-label" for="tipo_loft">Loft</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="apartment[apartment_type][]" id="tipo_atico" value="Ático">
                                <label class="form-check-label" for="tipo_atico">Ático</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="apartment[apartment_type][]" id="tipo_duplex" value="Dúplex">
                                <label class="form-check-label" for="tipo_duplex">Dúplex</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="apartment[apartment_type][]" id="tipo_bajo" value="Bajo con jardín">
                                <label class="form-check-label" for="tipo_bajo">Bajo con jardín</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="num_rooms" class="form-label">Nº de habitaciones</label>
                        <input type="number" class="form-control" id="num_rooms" name="apartment[num_rooms]" min="1" max="20">
                    </div>
                    <div class="mb-3">
                        <label for="num_bathrooms" class="form-label">Nº de baños</label>
                        <input type="number" class="form-control" id="num_bathrooms" name="apartment[num_bathrooms]" min="1" max="10">
                    </div>
                    <div class="mb-3">
                        <label for="apartment_furnished" class="form-label">¿Amueblado?</label>
                        <select class="form-select" id="apartment_furnished" name="apartment[furnished]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="apartment_balcony" class="form-label">¿Balcón/terraza?</label>
                        <select class="form-select" id="apartment_balcony" name="apartment[balcony]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="floor" class="form-label">Planta</label>
                        <input type="number" class="form-control" id="floor" name="apartment[floor]" min="0" max="50">
                    </div>
                    <div class="mb-3">
                        <label for="elevator" class="form-label">¿Ascensor?</label>
                        <select class="form-select" id="elevator" name="apartment[elevator]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="apartment_air_conditioning" class="form-label">¿Aire acondicionado?</label>
                        <select class="form-select" id="apartment_air_conditioning" name="apartment[air_conditioning]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="garage" class="form-label">¿Garaje?</label>
                        <select class="form-select" id="garage" name="apartment[garage]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="apartment_pets_allowed" class="form-label">¿Se permiten mascotas?</label>
                        <select class="form-select" id="apartment_pets_allowed" name="apartment[pets_allowed]">
                            <option value="">Cualquiera</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>
        <?php
            break;
        case 'Casa':
        ?>
            <div class="border rounded">
                <div class="card-header bg-secondary text-white">
                    <strong>Filtrar casas</strong>
                </div>
                <div class="p-2">
                    <div class="mb-3">
                        <label for="house_type" class="form-label">Tipo de casa</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="house[house_type][]" id="tipo_unifamiliar" value="Unifamiliar">
                                <label class="form-check-label" for="tipo_unifamiliar">Unifamiliar</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="house[house_type][]" id="tipo_chalet" value="Chalet">
                                <label class="form-check-label" for="tipo_chalet">Chalet</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="house[house_type][]" id="tipo_adosado" value="Adosado">
                                <label class="form-check-label" for="tipo_adosado">Adosado</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="house[house_type][]" id="tipo_pareado" value="Pareado">
                                <label class="form-check-label" for="tipo_pareado">Pareado</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="house[house_type][]" id="tipo_casarural" value="Bajo con Casa rural">
                                <label class="form-check-label" for="tipo_casarural">Casa rural</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tamaño del jardín (m²)</label>
                            <div class="input-group">
                                <span class="input-group-text">Mín</span>
                                <input type="number" class="form-control" name="house[garden_size_min]" min="0" placeholder="Mínimo">
                                <span class="input-group-text">Máx</span>
                                <input type="number" class="form-control" name="house[garden_size_max]" min="0" placeholder="Máximo">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nº de plantas</label>
                            <div class="input-group">
                                <span class="input-group-text">Mín</span>
                                <input type="number" class="form-control" name="house[num_floors_min]" min="1" placeholder="Mínimo">
                                <span class="input-group-text">Máx</span>
                                <input type="number" class="form-control" name="house[num_floors_max]" min="1" placeholder="Máximo">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nº de habitaciones</label>
                            <div class="input-group">
                                <span class="input-group-text">Mín</span>
                                <input type="number" class="form-control" name="house[num_rooms_min]" min="1" placeholder="Mínimo">
                                <span class="input-group-text">Máx</span>
                                <input type="number" class="form-control" name="house[num_rooms_max]" min="1" placeholder="Máximo">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nº de baños</label>
                            <div class="input-group">
                                <span class="input-group-text">Mín</span>
                                <input type="number" class="form-control" name="house[num_bathrooms_min]" min="1" placeholder="Mínimo">
                                <span class="input-group-text">Máx</span>
                                <input type="number" class="form-control" name="house[num_bathrooms_max]" min="1" placeholder="Máximo">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="private_garage" class="form-label">¿Garaje privado?</label>
                            <select class="form-select" id="private_garage" name="house[private_garage]">
                                <option value="">Cualquiera</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="private_pool" class="form-label">¿Piscina privada?</label>
                            <select class="form-select" id="private_pool" name="house[private_pool]">
                                <option value="">Cualquiera</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="house_furnished" class="form-label">¿Amueblada?</label>
                            <select class="form-select" id="house_furnished" name="house[furnished]">
                                <option value="">Cualquiera</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="terrace" class="form-label">¿Terraza/poche?</label>
                            <select class="form-select" id="terrace" name="house[terrace]">
                                <option value="">Cualquiera</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="storage_room" class="form-label">¿Trastero?</label>
                            <select class="form-select" id="storage_room" name="house[storage_room]">
                                <option value="">Cualquiera</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="house_air_conditioning" class="form-label">¿Aire acondicionado?</label>
                            <select class="form-select" id="house_air_conditioning" name="house[air_conditioning]">
                                <option value="">Cualquiera</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="house_pets_allowed" class="form-label">¿Se permiten mascotas?</label>
                            <select class="form-select" id="house_pets_allowed" name="house[pets_allowed]">
                                <option value="">Cualquiera</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
    <?php
            break;
    }
}
    ?>