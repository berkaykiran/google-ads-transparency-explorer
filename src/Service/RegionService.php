<?php

namespace Service;

class RegionService
{
    public function getRegions()
    {
        $jsonPath = __DIR__ . '/../../resources/jsons/regions.json';
        $json = file_get_contents($jsonPath);
        $regionsArray = json_decode($json, true);
        $regions = [];
        foreach ($regionsArray as $region) {
            if (isset($region['1']) && isset($region['4'])) {
                $regions[$region['1']] = $region['4'];  // Store region code as key and name as value
            }
        }
        return $regions;
    }
}
