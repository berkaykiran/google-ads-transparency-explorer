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
        $data = $this->getRequestData();
        if ($this->isValidRequest($data)) {
            $regions = $this->region->getRegions();
            $adsCounts = $this->model->fetchAdsCount(array_keys($regions), $data['advertiser_id'], $data['start_date'], $data['end_date']);
            uasort($adsCounts, function ($a, $b) {
                return $b - $a;
            });
            $this->loadView('AdsCountByCompetitor', ['adsCounts' => $adsCounts, 'regions' => $regions]);
        } else {
            echo "Please provide advertiser ID, start date, and end date.";
        }
    }

    private function getRequestData()
    {
        $request_body = file_get_contents('php://input');
        return json_decode($request_body, true);
    }

    private function isValidRequest($data)
    {
        return isset($data['advertiser_id'], $data['start_date'], $data['end_date']);
    }

    private function loadView($viewName, $data)
    {
        extract($data);
        require __DIR__ . '/../View/' . $viewName . '.php';
    }
}
