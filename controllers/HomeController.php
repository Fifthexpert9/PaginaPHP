<?php

use facades\AdvertFacade;
use converters\AdvertConverter;
use converters\ImageConverter;

class HomeController
{
    private $advertFacade;

    public function __construct(AdvertFacade $advertFacade)
    {
        $this->advertFacade = $advertFacade;
    }

    public function index()
    {
        $adverts = $this->advertFacade->getAllAdverts();

        // Renderizar la vista con los datos
        include '../views/home.php';
    }
}



$homeController = new HomeController(new AdvertFacade(new AdvertConverter(), new ImageConverter()));
$homeController->index();