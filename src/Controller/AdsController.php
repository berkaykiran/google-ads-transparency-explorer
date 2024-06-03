<?php

namespace Controller;

use Model\AdsModel;
use Model\Region;

class AdsController
{
    private $model;
    private $region;

    public function __construct(AdsModel $model, Region $region)
    {
        $this->model = $model;
        $this->region = $region;
    }

    public function showDashboard()
    {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body, true);
        $advertiser_id = $data['advertiser_id'] ?? null;
        $start_date = $data['start_date'] ?? null;
        $end_date = $data['end_date'] ?? null;
        $regions = $this->region->getRegions();
        if ($advertiser_id && $start_date && $end_date) {
            $adsCounts = $this->model->fetchAdsCount(array_keys($regions), $advertiser_id, $start_date, $end_date);
            // Sort regions by ad count
            uasort($adsCounts, function ($a, $b) {
                return $b - $a;
            });
            require __DIR__ . '/../View/AdsDashboard.php';
        } else {
            echo "Please provide advertiser ID, start date, and end date.";
        }
    }
}
