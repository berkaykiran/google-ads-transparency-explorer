<?php

namespace Controller;

use Service\AdsService;
use Controller\RequestHandler;
use Service\ViewLoader;

class AdsController
{
    private $adsService;
    private $requestHandler;
    private $viewLoader;

    public function __construct(AdsService $adsService, RequestHandler $requestHandler, ViewLoader $viewLoader)
    {
        $this->adsService = $adsService;
        $this->requestHandler = $requestHandler;
        $this->viewLoader = $viewLoader;
    }

    public function showDashboard()
    {
        $data = $this->requestHandler->getRequestData();
        if ($this->requestHandler->isValidRequest($data)) {
            $dashboardData = $this->adsService->prepareDashboardData($data);
            $this->viewLoader->loadView('AdsCountByCompetitor', $dashboardData);
        } else {
            $this->viewLoader->loadView('ErrorView', ['error' => 'Please provide advertiser ID, start date, and end date.']);
        }
    }
}
