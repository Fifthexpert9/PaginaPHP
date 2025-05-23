<?php

namespace facades;

use services\RoomService;
use services\PropertyService;
use services\AddressService;
use services\ImageService;
use converters\RoomConverter;
use converters\ImageConverter;
use dtos\RoomDto;

/**
 * Facade para operaciones de habitaciones (Room).
 * Orquesta la obtención de datos de habitación, propiedad, dirección e imágenes,
 * y construye el DTO RoomDto para la capa de presentación o API.
 */
class RoomFacade
{
    private $roomService;
    private $propertyService;
    private $addressService;
    private $imageService;
    private $roomConverter;
    private $imageConverter;

    public function __construct(
        RoomService $roomService,
        PropertyService $propertyService,
        AddressService $addressService,
        ImageService $imageService,
        RoomConverter $roomConverter,
        ImageConverter $imageConverter
    ) {
        $this->roomService = $roomService;
        $this->propertyService = $propertyService;
        $this->addressService = $addressService;
        $this->imageService = $imageService;
        $this->roomConverter = $roomConverter;
        $this->imageConverter = $imageConverter;
    }

    /**
     * Obtiene el DTO de una habitación a partir del ID de la propiedad.
     *
     * @param int $propertyId ID de la propiedad asociada a la habitación.
     * @return RoomDto|null
     */
    public function getRoomDtoByPropertyId($propertyId)
    {
        $propertyModel = $this->propertyService->getPropertyById($propertyId);
        if (!$propertyModel) return null;

        $roomModel = $this->roomService->getRoomByPropertyId($propertyId);
        if (!$roomModel) return null;

        $roomDto = $this->roomConverter->modelToDto($propertyModel, $roomModel);

        return $roomDto;
    }
}
