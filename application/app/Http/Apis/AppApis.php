<?php

namespace App\Http\Apis;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use function env;

class AppApis
{
    protected $client;
    public function __construct(){
        $this->client = new Client([
            'base_uri' => 'http://developer.tum.ac.ke/v1/',
            'auth' => [env('STAFF_API_USERNAME'), env('STAFF_API_PASSWORD')],
        ]);
    }

    public function fetchStaff($staffNumber, $userId)
    {
        try {
            $uri = "staff/profile/{$staffNumber}/{$userId}";
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

    public function sendSMS($phoneNumber, $message){
        try {
            $uri = "sms/send";
            $body = [
                'mobile_number' => $phoneNumber,
                'text_message' => $message,
            ];
            $response = $this->client->request('POST', $uri, ['json' => $body]);
            $responseBody = $response->getBody()->getContents();
            if ($response->getStatusCode() === 200) {
                $getMessage = json_decode($responseBody, true);
                return $getMessage;
            }
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }

    public function createStudent($student)
    {
        try {
            $uri = "finance/student";
            $response = $this->client->request('POST', $uri, ['json' => $student]);
            $responseBody = $response->getBody()->getContents();
            if ($response->getStatusCode() === 200) {
                $getMessage = json_decode($responseBody, true);
                return $getMessage;
            }
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }
    public function fetchVoteheads(){
        try{
            $uri = "finance/voteheads";
            $allVoteheads = collect();

        $currentPage = 1;
        do {
            $response = $this->client->request('GET', $uri, ['query' => ['page' => $currentPage]]);

            if ($response->getStatusCode() === 200) {
                $voteheadData = json_decode($response->getBody(), true);
                $data = $voteheadData['dataPayload']['data'];
                $allVoteheads = $allVoteheads->merge($data);

                // Check if there are more pages
                $currentPage++;
                $totalPages = $voteheadData['dataPayload']['totalPages'];
            } else {
                // Handle other status codes if needed
                // For example, if the API returns a 404 or 500 error
                // You may choose to return an error message or log the error
                return response()->json(['error' => 'Failed to fetch data from API'], $response->getStatusCode());
                // break;
            }
        } while ($currentPage <= $totalPages);

        // Now $allVoteheads contains all the data from all pages
        // dd($allVoteheads);
        return $allVoteheads;
        // You can process the $allVoteheads collection further as needed

        }catch(GuzzleException $e){
            return $e->getMessage();
        }
    }
}
