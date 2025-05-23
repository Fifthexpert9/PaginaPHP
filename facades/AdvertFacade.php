<?php

namespace facades;

use services\AdvertService;
use services\PropertyService;
use services\AddressService;
use converters\AdvertConverter;
use dtos\AdvertDto;
use facades\PropertyFacade;

/**
 * Facade para la gestión de anuncios (advert).
 * Orquesta la lógica de negocio relacionada con anuncios y su conversión entre modelos y DTOs.
 */
class AdvertFacade
{
    private $advertService;
    private $advertConverter;
    private $propertyService;
    private $addressService;
    private $propertyFacade;

    /**
     * Constructor de AdvertFacade.
     *
     * @param AdvertService $advertService Servicio de anuncios.
     * @param AdvertConverter $advertConverter Conversor de anuncios.
     */
    public function __construct(AdvertService $advertService, AdvertConverter $advertConverter, PropertyService $propertyService, AddressService $addressService, PropertyFacade $propertyFacade)
    {
        $this->advertService = $advertService;
        $this->advertConverter = $advertConverter;
        $this->propertyService = $propertyService;
        $this->addressService = $addressService;
        $this->propertyFacade = $propertyFacade;
    }

    /**
     * Genera el título de un anuncio a partir del anuncio, la propiedad y la dirección.
     *
     * El título sigue la estructura:
     * "(property_type, de property) en (action, de advert) en (street, de address), (city, de address)"
     *
     * @param int $advertId ID del anuncio.
     * @param PropertyModel $propertyModel Modelo de la propiedad asociada.
     * @param AddressModel|null $addressModel Modelo de la dirección asociada o null.
     * @return string Título generado para el anuncio.
     */
    private function generateAdvertTitle($propertyModel, $action, $addressModel)
    {
        $propertyType = $propertyModel->getPropertyType() ?? '';
        $street = $addressModel ? $addressModel->getStreet() : '';
        $city = $addressModel ? $addressModel->getCity() : '';

        return "{$propertyType} en {$action} en {$street}, {$city}";
    }

    /**
     * Crea un nuevo anuncio.
     *
     * @param AdvertDto $advertDto DTO con los datos del anuncio.
     * @return array Resultado de la operación (success, message)
     */
    public function createAdvert(AdvertDto $advertDto)
    {
        $advertModel = $this->advertConverter->dtoToModel($advertDto);
        if ($this->advertService->createAdvert($advertModel)) {
            return ['success' => true, 'message' => 'Anuncio creado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al crear el anuncio.'];
        }
    }

    /**
     * Obtiene un anuncio por su ID, devolviendo el título generado y el DTO correspondiente.
     *
     * @param int $id ID del anuncio.
     * @return array|null Array con 'title' y 'advert' (AdvertDto), o null si no existe.
     */
    public function getAdvertById($id)
    {
        $advertModel = $this->advertService->getAdvertById($id);

        if (!$advertModel) return null;

        $propertyModel = $this->propertyService->getPropertyById($advertModel->getPropertyId());

        if (!$propertyModel) return null;

        $addressModel = $this->addressService->getAddressByPropertyId($propertyModel->getAddressId());

        return [
            'title' => $this->generateAdvertTitle($propertyModel, $advertModel->getAction(), $addressModel),
            'advert' => $this->advertConverter->modelToDto($advertModel)
        ];
    }

    /**
     * Obtiene los anuncios de un usuario, devolviendo un array de arrays con el título generado y el DTO correspondiente.
     *
     * @param int $userId ID del usuario.
     * @return array[] Array de arrays con 'title' y 'advert' (AdvertDto) de cada anuncio.
     */
    public function getAdvertsByUserId($userId)
    {
        $adverts = $this->advertService->getAdvertsByUserId($userId);

        $result = [];
        foreach ($adverts as $advertModel) {
            $propertyModel = $this->propertyService->getPropertyById($advertModel->getPropertyId());
            $addressModel = $this->addressService->getAddressByPropertyId($propertyModel->getAddressId());

            $result[] = [
                'title' => $this->generateAdvertTitle($propertyModel, $advertModel->getAction(), $addressModel),
                'advert' => $this->advertConverter->modelToDto($advertModel)
            ];
        }
        return $result;
    }

    /**
     * Obtiene los anuncios asociados a una propiedad.
     *
     * @param int $propertyId ID de la propiedad.
     * @return array[] Array de arrays con 'title' y 'advert' (AdvertDto) de cada anuncio.
     */
    public function getAdvertsByPropertyId($propertyId)
    {
        $adverts = $this->advertService->getAdvertsByPropertyId($propertyId);

        $result = [];
        foreach ($adverts as $advertModel) {
            $propertyModel = $this->propertyService->getPropertyById($advertModel->getPropertyId());
            $addressModel = $this->addressService->getAddressByPropertyId($propertyModel->getAddressId());

            $result[] = [
                'title' => $this->generateAdvertTitle($propertyModel, $advertModel->getAction(), $addressModel),
                'advert' => $this->advertConverter->modelToDto($advertModel)
            ];
        }
        return $result;
    }

    /**
     * Obtiene todos los anuncios.
     *
     * @return array[] Array de arrays con 'title' y 'advert' (AdvertDto) de cada anuncio.
     */
    public function getAllAdverts()
    {
        $adverts = $this->advertService->getAllAdverts();

        $result = [];
        foreach ($adverts as $advertModel) {
            $propertyModel = $this->propertyService->getPropertyById($advertModel->getPropertyId());
            $addressModel = $this->addressService->getAddressByPropertyId($propertyModel->getAddressId());

            $result[] = [
                'title' => $this->generateAdvertTitle($propertyModel, $advertModel->getAction(), $addressModel),
                'advert' => $this->advertConverter->modelToDto($advertModel)
            ];
        }
        return $result;
    }

    /**
     * Actualiza los datos de un anuncio.
     *
     * @param int $id ID del anuncio a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return array Resultado de la operación (success, message)
     */
    public function updateAdvert($id, $fields)
    {
        if (empty($fields)) {
            return ['success' => false, 'message' => 'No se han proporcionado campos para actualizar.'];
        }
        if ($this->advertService->updateAdvert($id, $fields)) {
            return ['success' => true, 'message' => 'Anuncio actualizado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar el anuncio.'];
        }
    }

    /**
     * Elimina un anuncio por su ID.
     *
     * @param int $id ID del anuncio a eliminar.
     * @return array Resultado de la operación (success, message)
     */
    public function deleteAdvert($id)
    {
        if ($this->advertService->deleteAdvert($id)) {
            return ['success' => true, 'message' => 'Anuncio eliminado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el anuncio.'];
        }
    }

    /**
     * Busca anuncios cuyas propiedades cumplen los filtros dados.
     *
     * Este método permite buscar anuncios aplicando filtros generales y específicos sobre las propiedades,
     * como tipo de propiedad, precio, ubicación, número de habitaciones, baños, etc.
     * Utiliza el servicio de anuncios para obtener los modelos que cumplen los filtros y, para cada anuncio,
     * obtiene la información de la propiedad y la dirección asociada.
     * Devuelve un array con el título generado para cada anuncio y su DTO correspondiente.
     * Si no se encuentran anuncios que cumplan los filtros, devuelve un mensaje de texto informativo.
     *
     * @param array $filters Filtros de búsqueda para las propiedades. Puede incluir filtros generales
     *                       (precio, acción, ciudad, provincia, país, tamaño, estado, disponibilidad)
     *                       y filtros específicos por tipo de propiedad (habitaciones, estudios, pisos, casas).
     *                       Ejemplo:
     *                       [
     *                         'property_types' => ['Piso', 'Casa'],
     *                         'apartment' => ['num_bathrooms' => 2],
     *                         'house' => ['num_bathrooms_min' => 2]
     *                       ]
     * @return array[]|string Array de arrays con 'title' y 'advert' (AdvertDto) de cada anuncio,
     *                        o un string con un mensaje si no hay resultados.
     */
    public function searchAdverts($filters = [])
    {
        $advertModels = $this->advertService->searchAdverts($filters);

        if (empty($advertModels)) {
            return "No se han encontrado anuncios que cumplan con los filtros.";
        }

        $result = [];

        foreach ($advertModels as $advertModel) {
            $propertyModel = $this->propertyService->getPropertyById($advertModel->getPropertyId());
            $addressModel = $this->addressService->getAddressByPropertyId($propertyModel->getAddressId());
            $result[] = [
                'title' => $this->generateAdvertTitle($propertyModel, $advertModel->getAction(), $addressModel),
                'advert' => $this->advertConverter->modelToDto($advertModel)
            ];
        }

        return $result;
    }
}
