<?php

namespace Service;

use Model\AdsModel;
use Service\RegionService;

class AdsService
{
    private $adsModel;
    private $regionService;

    public function __construct(AdsModel $adsModel, RegionService $regionService)
    {
        $this->adsModel = $adsModel;
        $this->regionService = $regionService;
    }

    public function prepareDashboardData($data)
    {
        $regions = $this->regionService->getRegions();
        $adsCounts = $this->adsModel->fetchAdsCount(array_keys($regions), $data['advertiser_id'], $data['start_date'], $data['end_date']);
        uasort($adsCounts, function ($a, $b) {
            return $b - $a;
        });
        return ['adsCounts' => $adsCounts, 'regions' => $regions];
    }
}
