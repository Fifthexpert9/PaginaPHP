<?php

namespace facades;

use services\AdvertService;
use services\PropertyService;
use services\AddressService;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\AddressConverter;
use dtos\AdvertDto;

/**
 * Facade para la gestión de anuncios (advert).
 * Orquesta la lógica de negocio relacionada con anuncios y su conversión entre modelos y DTOs.
 */
class AdvertFacade
{
    private $advertService;
    private $propertyService;
    private $addressService;
    private $advertConverter;
    private $propertyConverter;
    private $addressConverter;

    /**
     * Constructor de AdvertFacade.
     *
     * @param AdvertConverter $advertConverter Conversor de anuncios.
     * @param PropertyConverter $propertyConverter Conversor de propiedades.
     * @param AddressConverter $addressConverter Conversor de direcciones.
     */
    public function __construct(
        AdvertConverter $advertConverter,
        PropertyConverter $propertyConverter,
        AddressConverter $addressConverter 
    ) {
        $this->advertService = AdvertService::getInstance();
        $this->propertyService = PropertyService::getInstance();
        $this->addressService = AddressService::getInstance();
        $this->advertConverter = $advertConverter;
        $this->propertyConverter = $propertyConverter;
        $this->addressConverter = $addressConverter; 
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
        $action = strtolower($action);
        $street = $addressModel ? $addressModel->getStreet() : '';

        return "{$propertyType} en {$action} en {$street}";
    }

    /**
     * Crea un nuevo anuncio en el sistema.
     *
     * Convierte el DTO recibido a modelo de dominio y lo inserta en la base de datos.
     * Devuelve un mensaje indicando si la operación fue exitosa o si ocurrió un error.
     *
     * @param AdvertDto $advertDto DTO con los datos del anuncio a crear.
     * @return string Mensaje indicando el resultado de la operación.
     */
    public function createAdvert(AdvertDto $advertDto)
    {
        $advertModel = $this->advertConverter->dtoToModel($advertDto);
        if ($this->advertService->createAdvert($advertModel)) {
            return 'Anuncio creado correctamente.';
        } else {
            return 'Error al crear el anuncio.';
        }
    }

    /**
     * Obtiene un anuncio por su ID, devolviendo el título generado, el advertDto correspondiente, y el propertyDto correspondiente.
     *
     * @param int $id ID del anuncio.
     * @return array|null Array con 'title', 'advert' (AdvertDto) y 'property' (PropertyDto), o null si no existe.
     */
    public function getAdvertById($id)
    {
        $advertModel = $this->advertService->getAdvertById($id);

        if (!$advertModel) return null;

        $propertyModel = $this->propertyService->getPropertyById($advertModel->getPropertyId());

        if (!$propertyModel) return null;

        $addressModel = $this->addressService->getAddressByPropertyId($propertyModel->getId());


        return [
            'title' => $this->generateAdvertTitle($propertyModel, $advertModel->getAction(), $addressModel),
            'advert' => $this->advertConverter->modelToDto($advertModel),
            'property' => $this->propertyConverter->modelToDto($propertyModel)
        ];
    }

    /**
     * Obtiene todos los anuncios publicados por un usuario.
     *
     * Recupera todos los anuncios asociados al usuario indicado por su ID.
     * Para cada anuncio, obtiene el modelo de la propiedad y la dirección asociada,
     * y construye un array con:
     *  - 'title': título generado a partir del tipo de propiedad, acción y dirección,
     *  - 'advert': DTO del anuncio,
     *  - 'property': DTO de la propiedad asociada.
     *
     * @param int $userId ID del usuario cuyos anuncios se desean obtener.
     * @return array[] Array de arrays con las claves:
     *                 - 'title' (string): Título generado para el anuncio.
     *                 - 'advert' (AdvertDto): DTO del anuncio.
     *                 - 'property' (PropertyDto): DTO de la propiedad asociada.
     */
    public function getAdvertsByUserId($userId)
    {
        $adverts = $this->advertService->getAdvertsByUserId($userId);

        $result = [];
        foreach ($adverts as $advertModel) {
            $propertyModel = $this->propertyService->getPropertyById($advertModel->getPropertyId());
            if (!$propertyModel) continue;
            $addressModel = $this->addressService->getAddressByPropertyId($propertyModel->getId());

            $result[] = [
                'title' => $this->generateAdvertTitle($propertyModel, $advertModel->getAction(), $addressModel),
                'advert' => $this->advertConverter->modelToDto($advertModel),
                'property' => $this->propertyConverter->modelToDto($propertyModel),
                'address' => $addressModel ? $this->addressConverter->modelToDto($addressModel) : null
            ];
        }
        return $result;
    }

    /**
     * Obtiene todos los anuncios asociados a una propiedad concreta.
     *
     * Recupera todos los anuncios cuyo property_id coincide con el proporcionado.
     * Para cada anuncio, obtiene el modelo de la propiedad y la dirección asociada,
     * y construye un array con:
     *  - 'title': título generado a partir del tipo de propiedad, acción y dirección,
     *  - 'advert': DTO del anuncio,
     *  - 'property': DTO de la propiedad asociada.
     *
     * @param int $propertyId ID de la propiedad cuyos anuncios se desean obtener.
     * @return array[] Array de arrays con las claves:
     *                 - 'title' (string): Título generado para el anuncio.
     *                 - 'advert' (AdvertDto): DTO del anuncio.
     *                 - 'property' (PropertyDto): DTO de la propiedad asociada.
     */
    public function getAdvertsByPropertyId($propertyId)
    {
        $adverts = $this->advertService->getAdvertsByPropertyId($propertyId);

        $result = [];
        foreach ($adverts as $advertModel) {
            $propertyModel = $this->propertyService->getPropertyById($advertModel->getPropertyId());
            if (!$propertyModel) continue;
            $addressModel = $this->addressService->getAddressByPropertyId($propertyModel->getId());

            $result[] = [
                'title' => $this->generateAdvertTitle($propertyModel, $advertModel->getAction(), $addressModel),
                'advert' => $this->advertConverter->modelToDto($advertModel),
                'property' => $this->propertyConverter->modelToDto($propertyModel),
                'address' => $addressModel ? $this->addressConverter->modelToDto($addressModel) : null
            ];
        }
        return $result;
    }

    /**
     * Obtiene todos los anuncios del sistema.
     *
     * Recupera todos los anuncios existentes en la base de datos. Para cada anuncio,
     * obtiene el modelo de la propiedad y la dirección asociada, y construye un array con:
     *  - 'title': título generado a partir del tipo de propiedad, acción y dirección,
     *  - 'advert': DTO del anuncio,
     *  - 'property': DTO de la propiedad asociada.
     *
     * @return array[] Array de arrays con las claves:
     *                 - 'title' (string): Título generado para el anuncio.
     *                 - 'advert' (AdvertDto): DTO del anuncio.
     *                 - 'property' (PropertyDto): DTO de la propiedad asociada.
     */
    public function getAllAdverts()
    {
        $adverts = $this->advertService->getAllAdverts();

        $result = [];
        foreach ($adverts as $advertModel) {
            $propertyModel = $this->propertyService->getPropertyById($advertModel->getPropertyId());
            if (!$propertyModel) continue;
            $addressModel = $this->addressService->getAddressByPropertyId($propertyModel->getId());

            $result[] = [
                'title' => $this->generateAdvertTitle($propertyModel, $advertModel->getAction(), $addressModel),
                'advert' => $this->advertConverter->modelToDto($advertModel),
                'property' => $this->propertyConverter->modelToDto($propertyModel),
                'address' => $addressModel ? $this->addressConverter->modelToDto($addressModel) : null
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
            return 'Anuncio actualizado correctamente.';
        } else {
            return 'Error al actualizar el anuncio.';
        }
    }

    /**
     * Elimina un anuncio por su ID.
     *
     * @param int $id ID del anuncio a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteAdvert($id)
    {
        return $this->advertService->deleteAdvert($id);
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
            if (!$propertyModel) continue;
            $addressModel = $this->addressService->getAddressByPropertyId($propertyModel->getId());

            $result[] = [
                'title' => $this->generateAdvertTitle($propertyModel, $advertModel->getAction(), $addressModel),
                'advert' => $this->advertConverter->modelToDto($advertModel),
                'property' => $this->propertyConverter->modelToDto($propertyModel),
                'address' => $addressModel ? $this->addressConverter->modelToDto($addressModel) : null
            ];
        }
        return $result;
    }
}
