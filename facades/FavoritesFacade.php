<?php

namespace facades;

use services\FavoritesService;
use converters\FavoritesConverter;
use dtos\FavoritesDto;

/**
 * Facade para la gestión de favoritos.
 * Orquesta la lógica de negocio relacionada con favoritos y su conversión entre modelos y DTOs.
 */
class FavoritesFacade
{
    private $favoritesService;
    private $favoritesConverter;

    /**
     * Constructor de FavoritesFacade.
     *
     * @param FavoritesService $favoritesService Servicio de favoritos.
     * @param FavoritesConverter $favoritesConverter Conversor de favoritos.
     */
    public function __construct(FavoritesConverter $favoritesConverter)
    {
        $this->favoritesService = FavoritesService::getInstance();
        $this->favoritesConverter = $favoritesConverter;
    }

    /**
     * Añade un anuncio a favoritos para un usuario.
     *
     * @param int $userId ID del usuario.
     * @param int $advertId ID del anuncio.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function addFavorite($userId, $advertId)
    {
        return $this->favoritesService->addFavorite($userId, $advertId);
    }

    /**
     * Obtiene un favorito por su ID.
     *
     * @param int $id ID del favorito.
     * @return FavoritesDto|null DTO del favorito o null si no existe.
     */
    public function getFavoriteById($id)
    {
        $favoriteModel = $this->favoritesService->getFavoriteById($id);
        if (!$favoriteModel) {
            return null;
        }
        return $this->favoritesConverter->modelToDto($favoriteModel);
    }

    /**
     * Obtiene todos los favoritos de un usuario.
     *
     * @param int $userId ID del usuario.
     * @return FavoritesDto[] Array de DTOs de favoritos del usuario.
     */
    public function getFavoritesByUserId($userId)
    {
        $favoriteModels = $this->favoritesService->getFavoritesByUserId($userId);
        return array_map([$this->favoritesConverter, 'modelToDto'], $favoriteModels);
    }

    /**
     * Elimina un favorito por usuario y anuncio.
     *
     * @param int $userId ID del usuario.
     * @param int $advertId ID del anuncio.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function removeFavorite($userId, $advertId)
    {
        return $this->favoritesService->removeFavorite($userId, $advertId);
    }

    /**
     * Elimina un favorito por su ID.
     *
     * @param int $id ID del favorito.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteFavoriteById($id)
    {
        return $this->favoritesService->deleteFavoriteById($id);
    }
}