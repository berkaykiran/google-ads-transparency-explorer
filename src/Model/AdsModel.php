<?php

namespace Model;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

class AdsModel
{
    private $client;
    private $apiUrl = 'https://adstransparency.google.com/anji/_/rpc/SearchService/SearchCreatives';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'proxy' => 'localhost:8888',
            'verify' => false, // Disable SSL verification for 'localhost'
            'headers' => [
                'Connection' => 'keep-alive',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36'
            ]
        ]);
    }

    public function fetchAdsCount(array $regions, $advertiser_id, $start_date, $end_date)
    {
        $promises = [];
        foreach ($regions as $region_code) {
            $encodedData = $this->buildRequestBody($advertiser_id, $region_code, $start_date, $end_date);
            $promises[$region_code] = $this->client->postAsync('', [
                'body' => "f.req=$encodedData",
                'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']
            ]);
        }

        $results = Utils::settle($promises)->wait();
        $adsCounts = [];
        foreach ($results as $region => $response) {
            if ($response['state'] === 'fulfilled') {
                $data = json_decode($response['value']->getBody()->getContents(), true);
                $adsCounts[$region] = $data['5'] ?? 0; // Assuming '5' is where the ad count is stored
            } else {
                $adsCounts[$region] = 0; // Handle error or rejected promise
            }
        }
        return $adsCounts;
    }

    private function buildRequestBody($advertiser_id, $region_code, $start_date, $end_date)
    {
        $request_body = [
            "2" => 0, // Number of results to return, 0 means only count
            "3" => [
                "13" => ["1" => [$advertiser_id]],
                "12" => [
                    "1" => "",
                    "2" => true,
                ],
            ],
            "7" => [
                "1" => 1, // Just some example parameters
                "2" => 30, // You might need to adjust these as per your API's specification
                "3" => 2528
            ]
        ];

        // Include region code if provided
        if ($region_code) {
            $request_body["3"]["8"] = [$region_code];
        }

        // Include date range if both dates are provided
        if ($start_date && $end_date) {
            $request_body["3"]["6"] = $start_date;
            $request_body["3"]["7"] = $end_date;
        }

        $jsonData = json_encode($request_body);
        return urlencode($jsonData); // URL encode the JSON string
    }
}