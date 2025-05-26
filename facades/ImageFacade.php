<?php

namespace facades;

use services\ImageService;
use converters\ImageConverter;
use dtos\ImageDto;

/**
 * Facade para la gestión de imágenes.
 * Orquesta la lógica de negocio relacionada con las imágenes de las propiedades y su conversión entre modelos y DTOs.
 */
class ImageFacade
{
    private $imageService;
    private $imageConverter;

    /**
     * Constructor de ImageFacade.
     *
     * @param ImageService $imageService Servicio de imágenes.
     * @param ImageConverter $imageConverter Conversor de imágenes.
     */
    public function __construct(ImageService $imageService, ImageConverter $imageConverter)
    {
        $this->imageService = $imageService;
        $this->imageConverter = $imageConverter;
    }

    /**
     * Añade una imagen a una propiedad.
     *
     * @param ImageDto $imageDto DTO de la imagen.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function addImage($imageDto)
    {
        return $this->imageService->addImage($this->imageConverter->dtoToModel($imageDto));
    }

    /**
     * Obtiene una imagen por su ID.
     *
     * @param int $id ID de la imagen.
     * @return ImagenDto|null DTO de la imagen o null si no existe.
     */
    public function getFavoriteById($id)
    {
        $imageModel = $this->imageService->getImageById($id);
        if (!$imageModel) {
            return null;
        }
        return $this->imageConverter->modelToDto($imageModel);
    }

    /**
     * Obtiene todas las imágenes de una propiedad.
     *
     * @param int $propertyId ID de la propiedad.
     * @return ImageDto[] Array de DTOs de imágenes de esa propiedad.
     */
    public function getImagesByPropertyId($propertyId)
    {
        $imageModels = $this->imageService->getImagesByPropertyId($propertyId);
        return array_map([$this->imageConverter, 'modelToDto'], $imageModels);
    }

    /**
     * Obtiene la imagen principal (la que se mostrará en el anuncio) de una propiedad.
     *
     * @param int $propertyId ID de la propiedad.
     * @return ImagenDto|null DTO de la imagen o null si no existe.
     */
    public function getMainImageByPropertyId($propertyId)
    {
        $imageModel = $this->imageService->getMainImageByPropertyId($propertyId);
        if (!$imageModel) {
            return null;
        }
        return $this->imageConverter->modelToDto($imageModel);
    }

    /**
     * Elimina una imagen por su ID.
     *
     * @param int $id ID de la imagen.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteImageById($id)
    {
        return $this->imageService->deleteImageById($id);
    }
}