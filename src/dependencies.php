<?php

use Model\AdsModel;
use Service\CompetitorService;
use Service\AdsService;
use Service\RegionService;

// Dependency container
$container = [];

// Define dependencies for services
$container['AdsService'] = function () {
    return new \Service\AdsService(new \Model\AdsModel(), new \Service\RegionService());
};

// Define dependencies
$container['HomeController'] = function () {
    return new \Controller\HomeController(new CompetitorService());
};

$container['AdsController'] = function () use ($container) {
    return new \Controller\AdsController($container['AdsService']());
};

return $container;
