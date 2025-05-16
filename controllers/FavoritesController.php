<?php
<?php

namespace controllers;

use services\FavoritesService;

class FavoritesController {
    private $favoritesService;

    public function __construct(FavoritesService $favoritesService) {
        $this->favoritesService = $favoritesService;
    }

    /**
     * Añade un anuncio a favoritos de un usuario.
     * @param int $user_id ID del usuario
     * @param int $advert_id ID del anuncio
     * @return bool True si se añadió correctamente
     */
    public function addFavorite($user_id, $advert_id) {
        return $this->favoritesService->addFavorite($user_id, $advert_id);
    }

    /**
     * Obtiene un favorito por su ID.
     * @param int $id ID del favorito
     * @return array|null Favorito encontrado o null si no existe
     */
    public function getFavoriteById($id) {
        return $this->favoritesService->getFavoriteById($id);
    }

    /**
     * Obtiene todos los favoritos de un usuario.
     * @param int $user_id ID del usuario
     * @return array Lista de favoritos
     */
    public function getFavoritesByUserId($user_id) {
        return $this->favoritesService->getFavoritesByUserId($user_id);
    }

    /**
     * Elimina un favorito por usuario y anuncio.
     * @param int $user_id ID del usuario
     * @param int $advert_id ID del anuncio
     * @return bool True si se eliminó correctamente
     */
    public function removeFavorite($user_id, $advert_id) {
        return $this->favoritesService->removeFavorite($user_id, $advert_id);
    }

    /**
     * Elimina un favorito por su ID.
     * @param int $id ID del favorito
     * @return bool True si se eliminó correctamente
     */
    public function deleteFavoriteById($id) {
        return $this->favoritesService->deleteFavoriteById($id);
    }
}