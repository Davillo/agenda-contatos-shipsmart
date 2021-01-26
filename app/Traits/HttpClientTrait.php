<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait HttpClientTrait
{
    function jsonRequest(string $method, string $uri , $params = []){
            $client = new Client([
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/json",
            ]
        ]);

        $response = $client->request($method, $uri, ["json" => $params]);
        return json_decode($response->getBody()->getContents());
    }
}
