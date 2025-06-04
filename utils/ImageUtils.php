<?php

namespace utils;

use services\ImageService;
use converters\PropertyConverter;
use converters\AdvertConverter;
use converters\ImageConverter;
use dtos\ImageDto;

/**
 * Facade para la gestión de imágenes.
 * Orquesta la lógica de negocio relacionada con las imágenes de las propiedades y su conversión entre modelos y DTOs.
 */
class ImageUtils
{
    private $imageService;
    private $imageConverter;

    /**
     * Constructor de ImageFacade.
     *
     * @param ImageConverter $imageConverter Conversor de imágenes.
     */
    public function __construct(ImageConverter $imageConverter)
    {
        $this->imageService = ImageService::getInstance();
        $this->imageConverter = $imageConverter;
    }

    /**
     * Añade una imagen a una propiedad.
     *
     * @param ImageDto $imageDto DTO de la imagen.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    /*public function addImage($imageDto)
    {
        return $this->imageService->addImage($this->imageConverter->dtoToModel($imageDto));
    }*/

    /**
     * Transforma un array de archivos subidos ($_FILES) en un array de objetos ImageDto.
     *
     * Procesa hasta 6 imágenes subidas, las mueve al directorio de medios y crea un ImageDto por cada imagen válida.
     * Marca la primera imagen como principal (is_main = true). Si alguna imagen falla al subirse, se registra en el log.
     *
     * @param array $images Array $_FILES con las imágenes subidas.
     * @param int $property_id ID de la propiedad a la que asociar las imágenes.
     * @return ImageDto[] Array de objetos ImageDto generados a partir de las imágenes subidas.
     */
    public function transformImagesToArrayDto($images, $property_id)
    {
        $imageDtos = [];
        if (!empty($images) && !empty($images['name'][0])) {
            $max_files = min(count($images['name']), 6);
            $upload_dir = __DIR__ . '/../media/';

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            for ($i = 0; $i < $max_files; $i++) {
                $is_main = ($i == 0);

                if ($images['error'][$i] === UPLOAD_ERR_OK) {
                    $file_type = pathinfo($images['name'][$i], PATHINFO_EXTENSION);
                    $file_name = 'property_' . $property_id . '_' . $i . '.' . $file_type;
                    $destination = $upload_dir . $file_name;

                    if (move_uploaded_file($images['tmp_name'][$i], $destination)) {
                        error_log("Archivo subido correctamente: " . $destination);
                        $imageDtos[] = new ImageDto(
                            1,
                            $property_id,
                            'media/' . $file_name,
                            $is_main,
                            date('Y-m-d H:i:s')
                        );
                    } else {
                        error_log("Fallo al mover el archivo: " . $images['tmp_name'][$i] . " a " . $destination);
                    }
                } else {
                    error_log("Error en la subida del archivo: " . $images['name'][$i] . " - Código de error: " . $images['error'][$i]);
                }
            }
        }

        return $imageDtos;
    }

    /**
     * Inserta varias imágenes en la base de datos asociadas a una propiedad.
     *
     * Recorre el array de DTOs de imágenes y las inserta una a una en la base de datos.
     * Si alguna inserción falla, devuelve un mensaje de error indicando la imagen que falló.
     * Si el array está vacío, devuelve false.
     *
     * @param ImageDto[] $imageDtos Array de objetos ImageDto a insertar.
     * @return bool|string True si todas las imágenes se insertaron correctamente,
     *                     o un string con el mensaje de error si alguna falla.
     */
    public function addImages($imageDtos)
    {
        foreach ($imageDtos as $imageDto) {
            $result = $this->imageService->addImage($this->imageConverter->dtoToModel($imageDto));
            if (!$result) {
                return "Error al insertar la imagen: " . $imageDto->imagePath;
            }
        }

        return $result;
    }

    /**
     * Obtiene todas las imágenes de una propiedad.
     *
     * @param int $property_id ID de la propiedad.
     * @return ImageDto[] Array de DTOs de imágenes de esa propiedad, o una imagen por defecto si no tiene ninguna.
     */
    /*public function getImagesByPropertyId($property_id)
    {
        $imageModels = $this->imageService->getImagesByPropertyId($property_id);

        if (empty($imageModels)) {
            return [new ImageDto(0, 0, 'media/no-image.jpg', 1, null)];
        }

        return array_map([$this->imageConverter, 'modelToDto'], $imageModels);
    }*/

    /**
     * Obtiene la imagen principal de una propiedad.
     *
     * Busca la imagen marcada como principal (is_main = true) para la propiedad indicada.
     * Si no existe ninguna imagen principal, devuelve un DTO con una imagen por defecto.
     *
     * @param int $property_id ID de la propiedad.
     * @return ImageDto DTO de la imagen principal, o una imagen por defecto si no existe.
     */
    /*public function getMainImageByPropertyId($property_id)
    {
        $imageModel = $this->imageService->getMainImageByPropertyId($property_id);
        if (!$imageModel) {
            return new ImageDto(0, 0, 'media/no-image.jpg', 1, null);
        }
        return $this->imageConverter->modelToDto($imageModel);
    }*/

    /**
     * Obtiene la imagen principal asociada a un anuncio.
     *
     * Busca el anuncio por su ID, obtiene el property_id asociado y recupera la imagen principal de esa propiedad.
     * Si no existe imagen principal, devuelve un DTO con una imagen por defecto.
     * Si el anuncio no existe o no tiene propiedad asociada, devuelve un mensaje de error.
     *
     * @param int $advert_id ID del anuncio.
     * @return ImageDto|string DTO de la imagen principal, una imagen por defecto, o un mensaje de error si no existe anuncio o propiedad.
     */
    /*public function getMainImageByAdvertId($advert_id)
    {
        $advertFacade = new AdvertFacade(new AdvertConverter(), new PropertyConverter(), $this->imageConverter);

        $advert = $advertFacade->getAdvertById($advert_id);

        if (!$advert || !isset($advert['advert']->property_id)) {
            return 'No existe el anuncio o no tiene una propiedad asociada.';
        }

        $imageModel = $this->imageService->getMainImageByPropertyId($advert['advert']->property_id);

        if (!$imageModel) {
            return new ImageDto(0, 0, 'media/no-image.jpg', 1, null);
        }
        return $this->imageConverter->modelToDto($imageModel);
    }*/

    /*public function getImagesByAdvertId($advert_id)
    {
        $advertFacade = new AdvertFacade(new AdvertConverter(), new PropertyConverter(), $this->imageConverter);

        $advert = $advertFacade->getAdvertById($advert_id);

        if (!$advert || !isset($advert['advert']->property_id)) {
            return null;
        }

        $imageModel = $this->imageService->getImagesByPropertyId($advert['advert']->property_id);

        if (!$imageModel || empty($imageModel)) {
            return new ImageDto(0, 0, 'media/no-image.jpg', 1, null);
        } else {
                    return array_map([$this->imageConverter, 'modelToDto'], $imageModels);

        }
    }*/

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
