<?php

namespace Model;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

class AdsModel
{
    private $client;
    private $apiUrl = 'https://adstransparency.google.com/anji/_/rpc/SearchService/SearchCreatives';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchAdsCount(array $regions, $advertiser_id, $start_date, $end_date)
    {
        $promises = $this->buildPromises($regions, $advertiser_id, $start_date, $end_date);
        $results = Utils::settle($promises)->wait();
        return $this->processResults($results);
    }

    private function buildPromises($regions, $advertiser_id, $start_date, $end_date)
    {
        $promises = [];
        foreach ($regions as $regionObject) {
            $regionCode = $regionObject->getRegionCode();
            $encodedData = $this->buildRequestBody(
                $advertiser_id,
                $regionCode,
                $start_date,
                $end_date
            );
            $promises[$regionCode] = $this->client->postAsync('', ['body' => "f.req=$encodedData"]);
        }
        return $promises;
    }

    private function processResults($results)
    {
        $adsCounts = [];
        foreach ($results as $regionCode => $response) {
            if ($response['state'] === 'fulfilled') {
                $data = json_decode($response['value']->getBody()->getContents(), true);
                $adsCounts[$regionCode] = $data['5'] ?? 0;
            } else {
                $adsCounts[$regionCode] = 0;
            }
        }
        return $adsCounts;
    }

    private function buildRequestBody($advertiser_id, $region_code, $start_date, $end_date)
    {
        $request_body = [
            "2" => 0,
            "3" => [
                "13" => ["1" => [$advertiser_id]],
                "12" => [
                    "1" => "",
                    "2" => true,
                ],
            ],
            "7" => [
                "1" => 1,
                "2" => 30,
                "3" => 2528
            ]
        ];

        if ($region_code) {
            $request_body["3"]["8"] = [$region_code];
        }

        if ($start_date && $end_date) {
            $request_body["3"]["6"] = $start_date;
            $request_body["3"]["7"] = $end_date;
        }

        $jsonData = json_encode($request_body);
        return urlencode($jsonData);
    }
}
