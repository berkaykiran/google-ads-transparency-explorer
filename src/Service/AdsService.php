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
        $advertiser_id = $data['advertiser_id'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        $adsCounts = $this->adsModel->fetchAdsCount(
            $regions,
            $advertiser_id,
            $start_date,
            $end_date
        );
        uasort($adsCounts, function ($a, $b) {
            return $b - $a;
        });
        return ['adsCounts' => $adsCounts, 'regions' => $regions, 'advertiser_id' => $advertiser_id];
    }
}
