<?php

namespace facades;

use services\PropertyService;
use services\RoomService;
use services\StudioService;
use services\ApartmentService;
use services\HouseService;
use services\AddressService;
use services\ImageService;
use converters\PropertyConverter;
use converters\RoomConverter;
use converters\StudioConverter;
use converters\ApartmentConverter;
use converters\HouseConverter;
use converters\AddressConverter;
use converters\ImageConverter;
use dtos\PropertyDto;
use dtos\AddressDto;

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
    private $addressService;
    private $imageService;
    private $propertyConverter;
    private $roomConverter;
    private $studioConverter;
    private $apartmentConverter;
    private $houseConverter;
    private $addressConverter;
    private $imageConverter;

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
        PropertyConverter $propertyConverter,
        RoomConverter $roomConverter,
        StudioConverter $studioConverter,
        ApartmentConverter $apartmentConverter,
        HouseConverter $houseConverter,
        AddressConverter $addressConverter,
        ImageConverter $imageConverter
    ) {
        $this->propertyService = PropertyService::getInstance();
        $this->roomService = RoomService::getInstance();
        $this->studioService = StudioService::getInstance();
        $this->apartmentService = ApartmentService::getInstance();
        $this->houseService = HouseService::getInstance();
        $this->addressService = AddressService::getInstance();
        $this->imageService = ImageService::getInstance();
        $this->propertyConverter = $propertyConverter;
        $this->roomConverter = $roomConverter;
        $this->studioConverter = $studioConverter;
        $this->apartmentConverter = $apartmentConverter;
        $this->houseConverter = $houseConverter;
        $this->addressConverter = $addressConverter;
        $this->imageConverter = $imageConverter;
    }

    /**
     * Crea una nueva propiedad en la base de datos junto con su dirección, datos específicos y, opcionalmente, imágenes.
     *
     * Este método orquesta la creación completa de una propiedad:
     *  - Inserta la dirección asociada a la propiedad (tabla `address`).
     *  - Inserta los datos generales de la propiedad (tabla `property`).
     *  - Inserta los datos específicos según el tipo de propiedad:
     *      - Si es habitación: tabla `property_room`
     *      - Si es estudio: tabla `property_studio`
     *      - Si es piso: tabla `property_apartment`
     *      - Si es casa: tabla `property_house`
     *  - Inserta las imágenes asociadas (tabla `property_image`), si se proporcionan.
     *
     * El método devuelve el ID de la propiedad creada si todo el proceso es exitoso.
     * Si ocurre cualquier error en alguno de los pasos, devuelve un mensaje de error como string.
     *
     * @param AddressDto $addressDto DTO con los datos de la dirección.
     * @param PropertyDto $propertyDto DTO con los datos generales de la propiedad.
     * @param mixed $specificDto DTO con los datos específicos de la propiedad (RoomDto, StudioDto, ApartmentDto o HouseDto).
     * @param array $imagesDtos Array de ImageDto con las imágenes asociadas (opcional).
     * @return int|string Devuelve el ID de la propiedad creada si tiene éxito, o un mensaje de error si falla.
     *
     * @throws \Throwable Si ocurre un error inesperado durante el proceso de creación.
     */
    public function createProperty($addressDto, $propertyDto, $specificDto, $imagesDtos = [])
    {
        try {
            $property_id = null;

            // Crear la dirección e insertarla en la bbdd
            if (isset($addressDto)) {
                $addressModel = $this->addressConverter->dtoToModel($addressDto);
                $address_id = $this->addressService->createAddress($addressModel);
                if (is_numeric($address_id) && $address_id > 0) {
                    $propertyDto->address_id = $address_id;
                } else {
                    return "Ha ocurrido un error al registrar la dirección.";
                }
            } else {
                return "La dirección es obligatoria para registrar la propiedad.";
            }

            // Crear la propiedad e insertarla en la bbdd
            if (isset($propertyDto)) {
                $propertyModel = $this->propertyConverter->dtoToModel($propertyDto);
                $property_id = $this->propertyService->createProperty($propertyModel);
                if (!is_numeric($property_id) || $property_id <= 0) {
                    return "Ha ocurrido un error al registrar los datos generales de la propiedad.";
                } else {
                    $specificDto->property_id = $property_id;
                    $specificDto->address = $this->addressService->getAddressByPropertyId($property_id);
                }
            } else {
                return "Los datos generales de la propiedad son obligatorios para registrar la propiedad.";
            }

            // Crear los datos específicos según el tipo de propiedad e insertarlos en la bbdd
            if ($specificDto instanceof \dtos\RoomDto) {
                $roomModel = $this->roomConverter->dtoToRoomModel($specificDto);
                $auxR = $this->roomService->createRoom($roomModel);
                if (!$auxR) {
                    return "Ha ocurrido un error al registrar los datos específicos de la habitación.";
                }
            } elseif ($specificDto instanceof \dtos\StudioDto) {
                $studioModel = $this->studioConverter->dtoToStudioModel($specificDto);
                $auxS = $this->studioService->createStudio($studioModel);
                if (!$auxS) {
                    return "Ha ocurrido un error al registrar los datos específicos del estudio.";
                }
            } elseif ($specificDto instanceof \dtos\ApartmentDto) {
                $apartmentModel = $this->apartmentConverter->dtoToApartmentModel($specificDto);
                $auxA = $this->apartmentService->createApartment($apartmentModel);
                if (!$auxA) {
                    return "Ha ocurrido un error al registrar los datos específicos del piso.";
                }
            } elseif ($specificDto instanceof \dtos\HouseDto) {
                $houseModel = $this->houseConverter->dtoToHouseModel($specificDto);
                $auxH = $this->houseService->createHouse($houseModel);
                if (!$auxH) {
                    return "Ha ocurrido un error al registrar los datos específicos de la casa.";
                }
            } else {
                return "El tipo de propiedad no es válido.";
            }

            /*foreach ($imagesDtos as $imageDto) {
                $imageModel = $this->imageConverter->dtoToModel($imageDto, $propertyId);
                $this->imageService->addImage($imageModel);
            }*/

            return $property_id;
        } catch (\Throwable $e) {
            return "Ha ocurrido un error al registrar la propiedad.";
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
     * Obtiene todas las propiedades de un usuario, devolviendo su id, tipo y ciudad.
     *
     * Este método recupera todas las propiedades asociadas a un usuario concreto,
     * devolviendo un array donde cada elemento contiene el identificador de la propiedad,
     * el tipo de propiedad y la ciudad en la que se encuentra.
     *
     * @param int $userId ID del usuario.
     * @return array[] Array de arrays con las claves 'id', 'property_type' y 'city' de cada propiedad.
     */
    public function getPropertiesByUserId($user_id)
    {
        $propertyModels = $this->propertyService->getPropertiesByUserId($user_id);

        $properties = [];

        if (!empty($propertyModels)) {
            foreach ($propertyModels as $propertyModel) {
                $address = $this->addressService->getAddressByPropertyId($propertyModel->getId());
                $city = $address ? $address->getCity() : 'Sin ciudad';
                $properties[] = [
                    'id' => $propertyModel->getId(),
                    'text' => $propertyModel->getId() . ' - ' . $propertyModel->getPropertyType() . ' en ' . $city
                ];
            }
        }

        return $properties;
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
