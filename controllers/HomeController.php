<?php

use facades\AdvertFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
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
        // Construir filtros desde GET
        $filters = [];
        if (!empty($_GET['tipo'])) {
            $filters['property_types'] = [$_GET['tipo']];
        }
        if (!empty($_GET['precio'])) {
            $filters['price_max'] = $_GET['precio'];
        }
        if (!empty($_GET['city'])) {
            $filters['city'] = $_GET['city'];
        }

        // Obtener anuncios filtrados o todos si no hay filtros
        if (!empty($filters)) {
            $adverts = $this->advertFacade->searchAdverts($filters);
            if (is_string($adverts)) {
                $adverts = [];
            }
        } else {
            $adverts = $this->advertFacade->getAllAdverts();
        }

        // Normalizar: filtrar solo los anuncios que tienen 'advert' y 'property'
        $adverts = array_filter($adverts, function($item) {
            return is_array($item) && isset($item['advert']) && isset($item['property']);
        });

        // Paginación
        $advertsPerPage = 6;
        $totalAdverts = count($adverts);
        $totalPages = ceil($totalAdverts / $advertsPerPage);
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $start = ($page - 1) * $advertsPerPage;
        $advertsToShow = array_slice($adverts, $start, $advertsPerPage);

        // Renderizar la vista con los datos
        include '../views/home.php';
    }
}



$homeController = new HomeController(new AdvertFacade(new AdvertConverter(), new PropertyConverter(), new ImageConverter()));
$homeController->index();