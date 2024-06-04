<?php

namespace Controller;

class RequestHandler
{
    public function getRequestData()
    {
        $request_body = file_get_contents('php://input');
        return json_decode($request_body, true);
    }

    public function isValidRequest($data)
    {
        return isset($data['advertiser_id'], $data['start_date'], $data['end_date']);
    }
}
