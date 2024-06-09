<?php

namespace Controller;

use Service\CompetitorService;

class HomeController
{
    private $competitorService;

    public function __construct(CompetitorService $competitorService)
    {
        $this->competitorService = $competitorService;
    }

    public function showHome()
    {
        require __DIR__ . '/../View/HomeView.php';
    }

    public function showCompetitors()
    {
        $competitors = $this->competitorService->getCompetitors();

        // Generate the options
        foreach ($competitors as $competitor) {
            echo '<option value="' . $competitor->id . '">' . $competitor->name . '</option>';
        }
    }
}
