<?php

namespace Service;

use Model\Region;

class RegionService
{
    public function getRegions()
    {
        $jsonPath = __DIR__ . '/../../resources/jsons/regions.json';
        $json = file_get_contents($jsonPath);
        $regionsArray = json_decode($json, true);
        $regions = [];

        foreach ($regionsArray as $regionData) {
            if (isset($regionData['1']) && isset($regionData['3']) && isset($regionData['4'])) {
                $region_code = $regionData['1'];
                $region_alpha_2 = $regionData['3'];
                $region_name = $regionData['4'];
                $region = new Region($region_code, $region_alpha_2, $region_name);
                $regions[$region_code] = $region;  // Add Region object to the array
            }
        }
        return $regions;
    }
}
