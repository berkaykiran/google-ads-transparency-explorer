<?php

namespace Model;

use Model\Competitor;

class CompetitorService
{
    public function getCompetitors()
    {
        $jsonPath = __DIR__ . '/../../resources/jsons/competitors.json';
        $json = file_get_contents($jsonPath);
        $competitorsArray = json_decode($json, true);
        $competitors = [];
        foreach ($competitorsArray as $competitor) {
            if (isset($competitor['advertiser_id']) && isset($competitor['advertiser_name'])) {
                $competitors[] = new Competitor($competitor['advertiser_id'], $competitor['advertiser_name']);
            }
        }
        return $competitors;
    }
}
