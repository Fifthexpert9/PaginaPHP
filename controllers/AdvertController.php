<?php

namespace controllers;

use services\AdvertService;
use models\AdvertModel;

class AdvertController {
    private $advertService;

    public function __construct(AdvertService $advertService) {
        $this->advertService = $advertService;
    }

    /**
     * Crea un nuevo anuncio.
     * @param array $data Datos del anuncio (property_id, user_id, price, action, description, created_at)
     * @return bool True si se creó correctamente
     */
    public function createAdvert($data) {
        $advert = new AdvertModel(
            null,
            $data['property_id'],
            $data['user_id'],
            $data['price'],
            $data['action'],
            $data['description'],
            $data['created_at']
        );
        return $this->advertService->createAdvert($advert);
    }

    /**
     * Obtiene un anuncio por su ID.
     * @param int $id
     * @return AdvertModel|null
     */
    public function getAdvertById($id) {
        return $this->advertService->getAdvertById($id);
    }

    /**
     * Obtiene todos los anuncios de un usuario.
     * @param int $user_id
     * @return AdvertModel[]
     */
    public function getAdvertsByUserId($user_id) {
        return $this->advertService->getAdvertsByUserId($user_id);
    }

    /**
     * Actualiza un anuncio existente.
     * @param int $id
     * @param array $fields Campos a actualizar
     * @return bool
     */
    public function updateAdvert($id, $fields) {
        return $this->advertService->updateAdvert($id, $fields);
    }

    /**
     * Elimina un anuncio por su ID.
     * @param int $id
     * @return bool
     */
    public function deleteAdvert($id) {
        return $this->advertService->deleteAdvert($id);
    }

    /**
     * Obtiene los anuncios destacados.
     * @return AdvertModel[]
     */
    public function getFeaturedAdverts() {
        return $this->advertService->getFeaturedAdverts();
    }
}