<?php

namespace facades;

use services\PropertyService;
use services\RoomService;
use services\StudioService;
use services\ApartmentService;
use services\HouseService;
use converters\PropertyConverter;
use converters\RoomConverter;
use converters\StudioConverter;
use converters\ApartmentConverter;
use converters\HouseConverter;
use dtos\PropertyDto;

/**
 * Facade para la gestión de propiedades.
 * Orquesta la lógica de negocio relacionada con propiedades y su conversión entre modelos y DTOs.
 */
class PropertyFacade
{
    private $propertyService;
    private $roomService;
    private $studioService;
    private $apartmentService;
    private $houseService;
    private $propertyConverter;
    private $roomConverter;
    private $studioConverter;
    private $apartmentConverter;
    private $houseConverter;

    /**
     * Constructor de PropertyFacade.
     *
     * Inicializa la fachada de propiedades con los servicios y conversores necesarios para cada tipo de propiedad.
     * Permite gestionar propiedades de tipo habitación, estudio, piso y casa, utilizando el servicio y conversor adecuado según el tipo.
     *
     * @param PropertyService $propertyService Servicio principal de propiedades.
     * @param RoomService $roomService Servicio específico para habitaciones.
     * @param StudioService $studioService Servicio específico para estudios.
     * @param ApartmentService $apartmentService Servicio específico para pisos.
     * @param HouseService $houseService Servicio específico para casas.
     * @param RoomConverter $roomConverter Conversor para habitaciones.
     * @param StudioConverter $studioConverter Conversor para estudios.
     * @param ApartmentConverter $apartmentConverter Conversor para pisos.
     * @param HouseConverter $houseConverter Conversor para casas.
     */
    public function __construct(
        PropertyService $propertyService,
        RoomService $roomService,
        StudioService $studioService,
        ApartmentService $apartmentService,
        HouseService $houseService,
        PropertyConverter $propertyConverter,
        RoomConverter $roomConverter,
        StudioConverter $studioConverter,
        ApartmentConverter $apartmentConverter,
        HouseConverter $houseConverter,
    ) {
        $this->propertyService = $propertyService;
        $this->roomService = $roomService;
        $this->studioService = $studioService;
        $this->apartmentService = $apartmentService;
        $this->houseService = $houseService;
        $this->propertyConverter = $propertyConverter;
        $this->roomConverter = $roomConverter;
        $this->studioConverter = $studioConverter;
        $this->apartmentConverter = $apartmentConverter;
        $this->houseConverter = $houseConverter;
    }

    /**
     * Crea una nueva propiedad.
     *
     * @param mixed $propertyDto DTO con los datos de la propiedad (RoomDto, StudioDto, ApartmentDto o HouseDto).
     * @return int|string Devuelve el ID de la propiedad creada si tiene éxito, o un mensaje de error si falla.
     */
    public function createProperty($propertyDto)
    {
        try {
            if ($propertyDto instanceof \dtos\RoomDto) {
                $propertyModel = $this->roomConverter->dtoToPropertyModel($propertyDto);
            } elseif ($propertyDto instanceof \dtos\StudioDto) {
                $propertyModel = $this->studioConverter->dtoToPropertyModel($propertyDto);
            } elseif ($propertyDto instanceof \dtos\ApartmentDto) {
                $propertyModel = $this->apartmentConverter->dtoToPropertyModel($propertyDto);
            } elseif ($propertyDto instanceof \dtos\HouseDto) {
                $propertyModel = $this->houseConverter->dtoToPropertyModel($propertyDto);
            } else {
                return "Ha ocurrido un error al crear la propiedad.";
            }

            $result = $this->propertyService->createProperty($propertyModel);
            if (is_numeric($result) && $result > 0) {
                return $result;
            } else {
                return "Ha ocurrido un error al crear la propiedad.";
            }
        } catch (\Throwable $e) {
            return "Ha ocurrido un error al crear la propiedad.";
        }
    }

    /**
     * Obtiene una propiedad completa por su ID.
     *
     * Este método busca una propiedad por su identificador. Si la propiedad existe,
     * detecta su tipo (Habitación, Estudio, Piso o Casa) y utiliza el conversor y servicio
     * específico para obtener el DTO correspondiente con todos los datos, tanto generales
     * como específicos del tipo de propiedad.
     *
     * Si la propiedad no existe o el tipo no es reconocido, devuelve un mensaje de error.
     *
     * @param int $id ID de la propiedad.
     * @return mixed Devuelve el DTO específico de la propiedad (RoomDto, StudioDto, ApartmentDto, HouseDto)
     *               o un mensaje de error si no existe o hay un problema.
     */
    public function getCompletePropertyById($id)
    {
        $propertyModel = $this->propertyService->getPropertyById($id);
        if ($propertyModel) {
            switch ($propertyModel->getPropertyType()) {
                case 'Habitación':
                    $roomModel = $this->roomService->getRoomByPropertyId($propertyModel->getId());
                    if ($roomModel) {
                        return $this->roomConverter->modelToDto($propertyModel, $roomModel);
                    }
                    break;
                case 'Estudio':
                    $studioModel = $this->studioService->getStudioByPropertyId($propertyModel->getId());
                    if ($studioModel) {
                        return $this->studioConverter->modelToDto($propertyModel, $studioModel);
                    }
                    break;
                case 'Piso':
                    $apartmentModel = $this->apartmentService->getApartmentByPropertyId($propertyModel->getId());
                    if ($apartmentModel) {
                        return $this->apartmentConverter->modelToDto($propertyModel, $apartmentModel);
                    }
                    break;
                case 'Casa':
                    $houseModel = $this->houseService->getHouseByPropertyId($propertyModel->getId());
                    if ($houseModel) {
                        return $this->houseConverter->modelToDto($propertyModel, $houseModel);
                    }
                    break;
            }
            return "Ha ocurrido un error al obtener la propiedad específica.";
        } else {
            return "Ha ocurrido un error al obtener la propiedad.";
        }
    }

    /**
     * Obtiene todas las propiedades de un usuario.
     *
     * @param int $userId ID del usuario.
     * @return PropertyDto[] Array de DTOs de propiedades del usuario.
     */
    public function getPropertiesByUserId($userId)
    {
        $propertyModels = $this->propertyService->getPropertiesByUserId($userId);
        return array_map([$this->propertyConverter, 'modelToDto'], $propertyModels);
    }

    /**
     * Actualiza una propiedad existente.
     *
     * @param int $id ID de la propiedad a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateProperty($id, $fields)
    {
        return $this->propertyService->updateProperty($id, $fields);
    }

    /**
     * Elimina una propiedad por su ID.
     *
     * @param int $id ID de la propiedad a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteProperty($id)
    {
        return $this->propertyService->deleteProperty($id);
    }
}
