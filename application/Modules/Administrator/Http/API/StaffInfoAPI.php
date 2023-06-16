<?php

namespace Modules\Administrator\Http\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class StaffInfoAPI
{
    protected $client;

    public function __construct(){

        $this->client = new Client([
            'base_uri' => 'http://developer.tum.ac.ke/v1/staff/',
            'auth' => [env('STAFF_API_USERNAME'), env('STAFF_API_PASSWORD')],
        ]);

    }

    public function fetchStaff($staffNumber, $userId)
    {
        try {
            $uri = "profile/{$staffNumber}/{$userId}";

            $response = $this->client->request('GET', $uri);

            if ($response->getStatusCode() === 200) {
                $userData = json_decode($response->getBody(), true);
                return $userData;
            }

            // Handle other response codes if necessary

        } catch (GuzzleException $e) {

            return [];

//            return $e->getMessage();
            // Handle Guzzle exceptions here
        }

        return [];
    }


}
