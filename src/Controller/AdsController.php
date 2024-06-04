<?php

namespace Controller;

use Service\AdsService;

class AdsController
{
    private $adsService;

    public function __construct(AdsService $adsService)
    {
        $this->adsService = $adsService;
    }

    public function showDashboard()
    {
        $data = $this->getRequestData();
        if ($this->isValidRequest($data)) {
            $dashboardData = $this->adsService->prepareDashboardData($data);
            $this->loadView('AdsCountByCompetitor', $dashboardData);
        } else {
            $this->loadView('ErrorView', ['error' => 'Please provide advertiser ID, start date, and end date.']);
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
