<?php

namespace converters;

use models\UserModel;
use dtos\UserDto;
use facades\AdvertFacade;
use services\FavoritesService;

class UserConverter
{
    private $favoritesService;
    private $advertFacade;

    /**
     * Constructor de UserConverter.
     *
     * Inicializa los servicios necesarios para la conversión.
     */
    public function __construct(AdvertFacade $advertFacade)
    {
        $this->favoritesService = FavoritesService::getInstance();
        $this->advertFacade = $advertFacade;
    }

    /**
     * Convierte un UserModel en UserDto.
     */
    public function modelToDto(UserModel $userModel): UserDto
    {
        $eagerFavorites = $this->favoritesService->getFavoritesByUserId($userModel->getId());
        $favoriteAdvertsDtos = [];
        if ($eagerFavorites) {
            foreach ($eagerFavorites as $favorite) {
                $advert = $this->advertFacade->getAdvertById($favorite->getAdvertId());
                if ($advert) {
                    $favoriteAdvertsDtos[] = [
                        'title' => $advert['title'],
                        'advert' => $advert['advert'],
                        'property' => $advert['property']
                    ];
                }
            }
        }

        return new UserDto(
            $userModel->getId(),
            $userModel->getName(),
            $userModel->getLastName(),
            $userModel->getUsername(),
            $userModel->getEmail(),
            $userModel->getRole(),
            $userModel->getRegistrationDate(),
            $favoriteAdvertsDtos
        );
    }

    /**
     * Convierte un UserDto en UserModel.
     */
    public function dtoToModel(UserDto $userDto): UserModel
    {
        return new UserModel(
            $userDto->id,
            $userDto->name,
            $userDto->last_name,
            $userDto->username,
            $userDto->email,
            null, // password
            $userDto->role,
            $userDto->registration_date
        );
    }
}
