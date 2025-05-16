<?php

namespace controllers;

use services\StudioService;
use models\StudioModel;

class StudioController {
    private $studioService;

    public function __construct(StudioService $studioService) {
        $this->studioService = $studioService;
    }

    /**
     * Crea los detalles de un estudio.
     * @param int $property_id ID de la propiedad principal
     * @param array $data Datos específicos del estudio
     * @return bool True si se creó correctamente
     */
    public function createStudio($property_id, $data) {
        $studio = new StudioModel(
            $property_id,
            $data['furnished'],
            $data['balcony'],
            $data['air_conditioning'],
            $data['pets_allowed']
        );
        return $this->studioService->createStudio($studio);
    }

    /**
     * Obtiene los detalles de un estudio por property_id.
     * @param int $property_id
     * @return StudioModel|null
     */
    public function getStudioByPropertyId($property_id) {
        return $this->studioService->getStudioByPropertyId($property_id);
    }

    /**
     * Actualiza los detalles de un estudio.
     * @param int $property_id
     * @param array $fields Campos a actualizar
     * @return bool
     */
    public function updateStudio($property_id, $fields) {
        return $this->studioService->updateStudio($property_id, $fields);
    }

    /**
     * Elimina los detalles de un estudio por property_id.
     * @param int $property_id
     * @return bool
     */
    public function deleteStudio($property_id) {
        return $this->studioService->deleteStudio($property_id);
    }
}