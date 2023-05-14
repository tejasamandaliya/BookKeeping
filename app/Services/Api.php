<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Api
{
    protected $client;

    protected $base_url;

    protected $api_version;

    protected $token;

    /**
     * create instance HTTP instance
     *
     * @param Http $client
     */
    public function __construct(Http $client)
    {
        $this->client = $client;
        $this->base_url = config("bookskeleton.api_url");
    }

    protected function makeRequest($method, $path, $params = [], $token = null)
    {
        $headers = [
            'Authorization' =>  "Bearer " . $token,
        ];

        $response = Http::timeout(60)->withHeaders($token != null ? $headers : [])->{$method}($this->base_url . $path, $params);
        if ($response->getStatusCode() != '429') {
            \Log::info(
                "Request successful, Server responded with $this->base_url , status_code: {$response->getStatusCode()}.",
                [$params, $response->json()]
            );
        } else {
            $delay = rand(1, 3);
            sleep($delay);
            \Log::info(
                "Retrying request for .  Server responded with {$response->getStatusCode()}. wait time $delay $path"
            );
        }

        return [
            "status_code" => $response->getStatusCode(),
            "data" => $response->json(),
        ];
    }
}
