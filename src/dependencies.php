<?php

use Model\AdsModel;
use Model\Region;
use Model\CompetitorService;

// Dependency container
$container = [];

// Define dependencies
$container['HomeController'] = function () {
    return new \Controller\HomeController(new CompetitorService());
};

$container['AdsController'] = function () {
    return new \Controller\AdsController(new AdsModel(), new Region());
};

return $container;
