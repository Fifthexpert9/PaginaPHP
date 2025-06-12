<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\AddressConverter;

session_start();

$advertFacade = new AdvertFacade(
    new AdvertConverter(),
    new PropertyConverter(),
    new AddressConverter()
);

$filters = [];
if (!empty($_GET['action'])) {
    $filters['action'] = $_GET['action'];
}
if (!empty($_GET['property_types'])) {
    $filters['property_types'] = $_GET['property_types'];
}
if (!empty($_GET['price'])) {
    $filters['advert_price_max'] = $_GET['price'];
}
if (!empty($_GET['city'])) {
    $filters['city'] = $_GET['city'];
}
if (!empty($_GET['province'])) {
    $filters['province'] = $_GET['province'];
}
if (isset($_GET['immediate_availability']) && $_GET['immediate_availability'] !== '') {
    $filters['immediate_availability'] = $_GET['immediate_availability'];
}
if (!empty($_GET['status'])) {
    $filters['status'] = $_GET['status'];
}

if (!empty($_GET['room']) && is_array($_GET['room'])) {
    $roomFilters = [];
    if (isset($_GET['room']['private_bathroom']) && $_GET['room']['private_bathroom'] !== '') {
        $roomFilters['private_bathroom'] = $_GET['room']['private_bathroom'];
    }
    if (!empty($_GET['room']['max_roommates'])) {
        $roomFilters['max_roommates'] = $_GET['room']['max_roommates'];
    }
    if (isset($_GET['room']['pets_allowed']) && $_GET['room']['pets_allowed'] !== '') {
        $roomFilters['pets_allowed'] = $_GET['room']['pets_allowed'];
    }
    if (isset($_GET['room']['furnished']) && $_GET['room']['furnished'] !== '') {
        $roomFilters['furnished'] = $_GET['room']['furnished'];
    }
    if (isset($_GET['room']['students_only']) && $_GET['room']['students_only'] !== '') {
        $roomFilters['students_only'] = $_GET['room']['students_only'];
    }
    if (isset($_GET['room']['gender_restriction']) && $_GET['room']['gender_restriction'] !== '') {
        $roomFilters['gender_restriction'] = $_GET['room']['gender_restriction'];
    }
    if (!empty($roomFilters)) {
        $filters['room'] = $roomFilters;
    }
}

if (!empty($_GET['studio']) && is_array($_GET['studio'])) {
    $studioFilters = [];
    if (isset($_GET['studio']['furnished']) && $_GET['studio']['furnished'] !== '') {
        $studioFilters['furnished'] = $_GET['studio']['furnished'];
    }
    if (isset($_GET['studio']['balcony']) && $_GET['studio']['balcony'] !== '') {
        $studioFilters['balcony'] = $_GET['studio']['balcony'];
    }
    if (isset($_GET['studio']['air_conditioning']) && $_GET['studio']['air_conditioning'] !== '') {
        $studioFilters['air_conditioning'] = $_GET['studio']['air_conditioning'];
    }
    if (isset($_GET['studio']['pets_allowed']) && $_GET['studio']['pets_allowed'] !== '') {
        $studioFilters['pets_allowed'] = $_GET['studio']['pets_allowed'];
    }
    if (!empty($studioFilters)) {
        $filters['studio'] = $studioFilters;
    }
}

if (!empty($_GET['apartment']) && is_array($_GET['apartment'])) {
    $apartmentFilters = [];
    if (!empty($_GET['apartment']['apartment_type'])) {
        $apartmentFilters['apartment_type'] = $_GET['apartment']['apartment_type'];
    }
    if (!empty($_GET['apartment']['num_rooms'])) {
        $apartmentFilters['num_rooms'] = $_GET['apartment']['num_rooms'];
    }
    if (!empty($_GET['apartment']['num_bathrooms'])) {
        $apartmentFilters['num_bathrooms'] = $_GET['apartment']['num_bathrooms'];
    }
    if (isset($_GET['apartment']['furnished']) && $_GET['apartment']['furnished'] !== '') {
        $apartmentFilters['furnished'] = $_GET['apartment']['furnished'];
    }
    if (isset($_GET['apartment']['balcony']) && $_GET['apartment']['balcony'] !== '') {
        $apartmentFilters['balcony'] = $_GET['apartment']['balcony'];
    }
    if (!empty($_GET['apartment']['floor'])) {
        $apartmentFilters['floor'] = $_GET['apartment']['floor'];
    }
    if (isset($_GET['apartment']['elevator']) && $_GET['apartment']['elevator'] !== '') {
        $apartmentFilters['elevator'] = $_GET['apartment']['elevator'];
    }
    if (isset($_GET['apartment']['air_conditioning']) && $_GET['apartment']['air_conditioning'] !== '') {
        $apartmentFilters['air_conditioning'] = $_GET['apartment']['air_conditioning'];
    }
    if (isset($_GET['apartment']['garage']) && $_GET['apartment']['garage'] !== '') {
        $apartmentFilters['garage'] = $_GET['apartment']['garage'];
    }
    if (isset($_GET['apartment']['pets_allowed']) && $_GET['apartment']['pets_allowed'] !== '') {
        $apartmentFilters['pets_allowed'] = $_GET['apartment']['pets_allowed'];
    }
    if (!empty($apartmentFilters)) {
        $filters['apartment'] = $apartmentFilters;
    }
}

if (!empty($_GET['house']) && is_array($_GET['house'])) {
    $houseFilters = [];
    if (!empty($_GET['house']['house_type'])) {
        $houseFilters['house_type'] = $_GET['house']['house_type'];
    }
    if (!empty($_GET['house']['garden_size_min'])) {
        $houseFilters['garden_size_min'] = $_GET['house']['garden_size_min'];
    }
    if (!empty($_GET['house']['garden_size_max'])) {
        $houseFilters['garden_size_max'] = $_GET['house']['garden_size_max'];
    }
    if (!empty($_GET['house']['num_floors_min'])) {
        $houseFilters['num_floors_min'] = $_GET['house']['num_floors_min'];
    }
    if (!empty($_GET['house']['num_floors_max'])) {
        $houseFilters['num_floors_max'] = $_GET['house']['num_floors_max'];
    }
    if (!empty($_GET['house']['num_rooms_min'])) {
        $houseFilters['num_rooms_min'] = $_GET['house']['num_rooms_min'];
    }
    if (!empty($_GET['house']['num_rooms_max'])) {
        $houseFilters['num_rooms_max'] = $_GET['house']['num_rooms_max'];
    }
    if (!empty($_GET['house']['num_bathrooms_min'])) {
        $houseFilters['num_bathrooms_min'] = $_GET['house']['num_bathrooms_min'];
    }
    if (!empty($_GET['house']['num_bathrooms_max'])) {
        $houseFilters['num_bathrooms_max'] = $_GET['house']['num_bathrooms_max'];
    }
    if (isset($_GET['house']['private_garage']) && $_GET['house']['private_garage'] !== '') {
        $houseFilters['private_garage'] = $_GET['house']['private_garage'];
    }
    if (isset($_GET['house']['private_pool']) && $_GET['house']['private_pool'] !== '') {
        $houseFilters['private_pool'] = $_GET['house']['private_pool'];
    }
    if (isset($_GET['house']['furnished']) && $_GET['house']['furnished'] !== '') {
        $houseFilters['furnished'] = $_GET['house']['furnished'];
    }
    if (isset($_GET['house']['terrace']) && $_GET['house']['terrace'] !== '') {
        $houseFilters['terrace'] = $_GET['house']['terrace'];
    }
    if (isset($_GET['house']['storage_room']) && $_GET['house']['storage_room'] !== '') {
        $houseFilters['storage_room'] = $_GET['house']['storage_room'];
    }
    if (isset($_GET['house']['air_conditioning']) && $_GET['house']['air_conditioning'] !== '') {
        $houseFilters['air_conditioning'] = $_GET['house']['air_conditioning'];
    }
    if (isset($_GET['house']['pets_allowed']) && $_GET['house']['pets_allowed'] !== '') {
        $houseFilters['pets_allowed'] = $_GET['house']['pets_allowed'];
    }
    if (!empty($houseFilters)) {
        $filters['house'] = $houseFilters;
    }
}

if (!empty($filters)) {
    $adverts = $advertFacade->searchAdverts($filters);
    if (is_string($adverts)) {
        $adverts = [];
    }
} else {
    $adverts = $advertFacade->getAllAdverts();
}
