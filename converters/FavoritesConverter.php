<?php

namespace converters;

use models\FavoritesModel;
use dtos\FavoritesDto;

/**
 * Clase encargada de convertir entre FavoritesModel y FavoritesDto
 * para la transferencia de datos de favoritos.
 *
 * Métodos:
 * - modelToDto: Convierte un modelo de dominio FavoritesModel en un DTO FavoritesDto.
 * - dtoToModel: Convierte un DTO FavoritesDto en un modelo de dominio FavoritesModel.
 */
class FavoritesConverter {
    /**
     * Convierte un FavoritesModel en FavoritesDto.
     *
     * @param FavoritesModel $model Modelo de dominio con los datos del favorito.
     * @return FavoritesDto DTO resultante con la información del favorito.
     */
    public static function modelToDto(FavoritesModel $model): FavoritesDto {        
        return new FavoritesDto(
            $model->getId(),
            $model->getUserId(),
            $model->getAdvertId(),
            $model->getCreatedAt()
        );
    }

    /**
     * Convierte un FavoritesDto en FavoritesModel.
     *
     * @param FavoritesDto $dto DTO con los datos del favorito.
     * @return FavoritesModel Modelo de dominio con los datos del favorito.
     */
    public static function dtoToModel(FavoritesDto $dto): FavoritesModel {
        return new FavoritesModel(
            $dto->id,
            $dto->user_id,
            $dto->advert_id,
            $dto->created_at
        );
    }
}