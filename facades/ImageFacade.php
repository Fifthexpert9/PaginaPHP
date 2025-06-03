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
    public function addImage($imageDto)
    {
        return $this->imageService->addImage($this->imageConverter->dtoToModel($imageDto));
    }

    /**
     * Añade varias imágenes a una propiedad.
     *
     * Sube hasta 6 imágenes recibidas desde un formulario, las guarda en la carpeta /media,
     * y registra su información en la base de datos asociándolas a la propiedad indicada.
     * La primera imagen se marca como principal (is_main = true).
     *
     * @param array $images Array de archivos subidos ($_FILES['images']).
     * @param int $property_id ID de la propiedad a la que asociar las imágenes.
     * @return bool True si todas las imágenes se insertaron correctamente, false en caso contrario.
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
     * Obtiene una imagen por su ID.
     *
     * @param int $id ID de la imagen.
     * @return ImagenDto|null DTO de la imagen o null si no existe.
     */
    public function getImageById($id)
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
     * @return ImageDto|null DTO de la imagen o null si no existe.
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
