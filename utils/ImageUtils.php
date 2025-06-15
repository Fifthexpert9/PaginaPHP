<?php

namespace utils;

use services\ImageService;
use converters\ImageConverter;
use dtos\ImageDto;

/**
 * Útil para la gestión de imágenes de propiedades.
 *
 * Esta clase orquesta la lógica de negocio relacionada con las imágenes de las propiedades y su conversión entre modelos y DTOs.
 * Permite transformar archivos subidos en DTOs, insertar imágenes en la base de datos, y eliminar imágenes por su ID.
 * Facilita la integración entre la capa de servicios y la capa de presentación.
 *
 * Métodos principales:
 * - __construct(ImageConverter $imageConverter): Inicializa el facade con el conversor de imágenes.
 * - transformImagesToArrayDto($images, $property_id): Convierte archivos subidos ($_FILES) en un array de ImageDto.
 * - addImages($imageDtos): Inserta varias imágenes en la base de datos asociadas a una propiedad.
 * - deleteImageById($id): Elimina una imagen por su ID.
 */
class ImageUtils
{
    private $imageService;
    private $imageConverter;

    /**
     * Constructor de ImageUtils.
     *
     * @param ImageConverter $imageConverter Conversor de imágenes.
     */
    public function __construct(ImageConverter $imageConverter)
    {
        $this->imageService = ImageService::getInstance();
        $this->imageConverter = $imageConverter;
    }

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
