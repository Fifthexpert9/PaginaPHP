<?php

namespace models;

/**
 * Modelo de dominio para representar una imagen asociada a una propiedad.
 *
 * Esta clase encapsula los datos y comportamientos relacionados con una imagen de una propiedad inmobiliaria.
 * Permite almacenar información relevante como la ruta de la imagen, si es la imagen principal, la fecha de subida, etc.
 * Se utiliza para transferir información entre las capas de dominio y presentación o persistencia.
 */
class ImageModel
{
    /**
     * @var int $id ID único de la imagen.
     */
    private $id;

    /**
     * @var int $propertyId ID de la propiedad a la que pertenece la imagen.
     */
    private $propertyId;

    /**
     * @var string $imagePath Ruta o URL de la imagen.
     */
    private $imagePath;

    /**
     * @var bool $isMain Indica si la imagen es la principal de la propiedad.
     */
    private $isMain;

    /**
     * @var string|null $uploadedAt Fecha y hora en la que se subió la imagen (formato timestamp o datetime).
     */
    private $uploadedAt;

    /**
     * Constructor de ImageModel.
     *
     * @param int         $id         ID de la imagen.
     * @param int         $propertyId ID de la propiedad asociada.
     * @param string      $imagePath  Ruta o URL de la imagen.
     * @param bool        $isMain     Indica si es la imagen principal.
     * @param string|null $uploadedAt Fecha de subida de la imagen.
     */
    public function __construct($id, $propertyId, $imagePath, $isMain = false, $uploadedAt = null)
    {
        $this->id = $id;
        $this->propertyId = $propertyId;
        $this->imagePath = $imagePath;
        $this->isMain = $isMain;
        $this->uploadedAt = $uploadedAt;
    }

    /**
     * Obtiene el ID de la imagen.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Obtiene el ID de la propiedad asociada.
     *
     * @return int
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * Obtiene la ruta o URL de la imagen.
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Indica si la imagen es la principal de la propiedad.
     *
     * @return bool
     */
    public function isMain()
    {
        return $this->isMain;
    }

    /**
     * Obtiene la fecha de subida de la imagen.
     *
     * @return string|null
     */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }

    /**
     * Establece el ID de la propiedad asociada.
     *
     * @param int $propertyId
     * @return void
     */
    public function setPropertyId($propertyId)
    {
        $this->propertyId = $propertyId;
    }

    /**
     * Establece la ruta o URL de la imagen.
     *
     * @param string $imagePath
     * @return void
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * Establece si la imagen es la principal de la propiedad.
     *
     * @param bool $isMain
     * @return void
     */
    public function setIsMain($isMain)
    {
        $this->isMain = $isMain;
    }

    /**
     * Establece la fecha de subida de la imagen.
     *
     * @param string|null $uploadedAt
     * @return void
     */
    public function setUploadedAt($uploadedAt)
    {
        $this->uploadedAt = $uploadedAt;
    }
}
